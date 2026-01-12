<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;
use App\Jobs\SendSmsJob;

class SendScheduledSms extends Command
{
    protected $signature = 'sms:send-scheduled';
    protected $description = 'Send scheduled SMS to witnesses';

    protected int $batchSize = 100; // Adjust per server

    public function handle()
    {
        $this->info('Starting SMS dispatch: ' . now());

        $notifications = Notification::with('witness', 'schedule.case.court', 'schedule.template')
            ->where('status', 'pending')
            ->whereHas('schedule', function ($q) {
                $q->where('status', 'active')
                  ->where('schedule_date', '<=', now());
            })
            ->orderBy('id')
            ->get();

        $total = $notifications->count();
        $this->info("Total pending notifications: {$total}");

        if ($total === 0) {
            $this->info("No notifications to send now.");
            return 0;
        }

        $notifications->chunk($this->batchSize)->each(function ($batch) {
            foreach ($batch as $notification) {
                SendSmsJob::dispatch($notification)->onQueue('sms');
            }
        });

        $this->info('Dispatching jobs finished.');
        return 0;
    }
}
