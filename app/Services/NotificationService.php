<?php

namespace App\Services;

use App\Models\Notification;

class NotificationService
{
    /**
     * Send a notification via SMS or WhatsApp.
     *
     * @param Notification $notification
     * @return bool
     */
    public static function send(Notification $notification)
    {
        try {
            // You can integrate your actual SMS/WhatsApp API here
            $channel = $notification->channel;
            $witnessPhone = $notification->witness->phone;
            $message = $notification->schedule->template->body;

            // Replace placeholders in the message
            $message = str_replace('{witness_name}', $notification->witness->name, $message);
            $message = str_replace('{case_no}', $notification->schedule->case->case_no, $message);
            $message = str_replace('{hearing_date}', $notification->schedule->case->hearing_date, $message);

            // Example sending (replace with real API call)
            if ($channel === 'sms') {
                // SmsApi::send($witnessPhone, $message);
            } elseif ($channel === 'whatsapp') {
                // WhatsAppApi::send($witnessPhone, $message);
            }

            // Mark as sent
            $notification->update(['status' => 'sent']);

            return true;
        } catch (\Exception $e) {
            \Log::error('Notification sending failed: '.$e->getMessage());
            return false;
        }
    }
}
