<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;
use App\Jobs\SendSmsJob;
use Illuminate\Support\Facades\DB;

class SendScheduledSms extends Command
{
    protected $signature = 'sms:send-scheduled';
    protected $description = 'Send scheduled SMS to witnesses';

    protected int $batchSize = 100;
    protected int $maxPerRun = 300; // safety cap

    public function handle()
    {
        $this->info('Starting SMS dispatch: ' . now());

        // Select only a limited set of due pending notifications

	$notifications = Notification::with([
        'witness',
        'schedule.hearing.case.court',
        'schedule.template'
    ])
    ->where('status', 'pending')
    ->whereHas('schedule', function ($q) {
        $q->where('status', 'active')
          ->where('schedule_date', '<=', now());
    })
    ->orderBy('id')
    ->limit(300)
    ->get();





        $total = $notifications->count();
        $this->info("Total pending notifications (selected this run): {$total}");

        if ($total === 0) {
            $this->info("No notifications to send now.");
            return 0;
        }

        // IMPORTANT: lock them immediately so they won't be selected again on next run
        // TEMP: using 'failed' as "queued" marker to stop duplicate dispatch.
        // Next step we will replace this with a proper 'queued' status or queued_at column.
        DB::transaction(function () use ($notifications) {
            Notification::whereIn('id', $notifications->pluck('id'))
                ->where('status', 'pending')
                ->update([
                    'status' => 'queued',
                    'updated_at' => now(),
                ]);
        });

        // Dispatch jobs
        $notifications->chunk($this->batchSize)->each(function ($batch) {
            foreach ($batch as $notification) {
                SendSmsJob::dispatch($notification)->onQueue('sms');
            }
        });

        $this->info('Dispatching jobs finished.');
        return 0;
    }
}
