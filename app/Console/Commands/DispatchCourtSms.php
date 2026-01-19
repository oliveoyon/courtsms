<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;
use App\Jobs\SendSmsJob;

class DispatchCourtSms extends Command
{
    protected $signature = 'court:sms:dispatch';
    protected $description = 'Dispatch pending Court SMS notifications to the queue';

    public function handle(): void
    {
        $pending = Notification::where('status', 'pending')->get();

        if ($pending->isEmpty()) {
            $this->info('No pending notifications found.');
            return;
        }

        foreach ($pending as $notification) {
            SendSmsJob::dispatch($notification);
        }

        $this->info('Dispatched '.$pending->count().' pending notifications to the queue.');
    }
}
