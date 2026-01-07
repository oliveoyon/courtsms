<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;
use App\Jobs\SendSmsJob;
use Carbon\Carbon;

class SendScheduledSms extends Command
{
    protected $signature = 'sms:send-scheduled';
    protected $description = 'Send pending scheduled SMS notifications in batch';

    public function handle()
    {
        $now = Carbon::now();

        // Fetch pending notifications in chunks to reduce memory usage
        Notification::where('status', 'pending')
            ->whereHas('schedule', fn($q) => $q->where('schedule_date', '<=', $now))
            ->with(['witness', 'schedule.template'])
            ->chunkById(200, function ($notifications) {
                foreach ($notifications as $notification) {
                    SendSmsJob::dispatch($notification);
                }
                $this->info(count($notifications).' notifications dispatched.');
            });
    }
}
