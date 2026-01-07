<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Services\ScheduledSmsService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Notification $notification;
    protected ScheduledSmsService $smsService;

    // Allowed sending hours (configurable)
    protected int $startHour = 8;
    protected int $endHour = 20;

    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
        $this->smsService = new ScheduledSmsService();
    }

    public function handle()
    {
        $now = Carbon::now();

        // ⚠ Only send in allowed hours
        if ($now->hour < $this->startHour || $now->hour >= $this->endHour) {
            $nextSend = Carbon::today()->addHours($this->startHour);
            if ($now->hour >= $this->endHour) $nextSend->addDay();

            self::dispatch($this->notification)->delay($nextSend->diffInSeconds($now));
            return;
        }

        // Render SMS template
        $template = $this->notification->schedule->template;
        $message = $template->body_en_sms ?? '';
        $message = str_replace(
            ['{witness_name}', '{hearing_date}', '{court_name}', '{case_no}'],
            [
                $this->notification->witness->name,
                $this->notification->witness->hearing->hearing_date,
                $this->notification->witness->hearing->case->court->name,
                $this->notification->witness->hearing->case->case_no
            ],
            $message
        );

        // Send SMS
        $smsResult = $this->smsService->sendSms('88'.$this->notification->witness->phone, $message);

        // Update notification status
        $this->notification->status = $smsResult['success'] ? 'sent' : 'failed';
        $this->notification->sent_at = $smsResult['success'] ? now() : null;
        $this->notification->response = $smsResult['response'];
        $this->notification->attempts = $smsResult['attempts'];
        $this->notification->save();
    }
}
