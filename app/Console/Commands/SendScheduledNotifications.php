<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class SendScheduledNotifications extends Command
{
    protected $signature = 'notifications:send-scheduled';
    protected $description = 'Send scheduled SMS and WhatsApp notifications';

    public function handle()
    {
        $now = Carbon::now();

        $notifications = Notification::where('status', 'pending')
            ->whereHas('schedule', function($q) use ($now) {
                $q->where('schedule_date', '<=', $now)
                  ->where('status', 'active');
            })
            ->get();

        foreach ($notifications as $notification) {
            $phone = $notification->witness->phone;
            $message = $notification->schedule->template->body;

            if ($notification->channel === 'sms') {
                $this->sendSms($phone, $message);
            } elseif ($notification->channel === 'whatsapp') {
                $this->sendWhatsApp($phone, $message);
            }

            $notification->update(['status' => 'sent']);
        }

        $this->info("Processed " . $notifications->count() . " notifications.");
    }

    private function sendSms($phone, $message)
    {
        $config = config('notification_channels.sms');

        Http::post($config['url'], [
            'api_key' => $config['key'],
            'to'      => $phone,
            'message' => $message,
        ]);
    }

    private function sendWhatsApp($phone, $message)
    {
        $config = config('notification_channels.whatsapp');

        Http::post($config['url'], [
            'api_key' => $config['key'],
            'to'      => $phone,
            'message' => $message,
        ]);
    }
}
