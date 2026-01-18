<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Services\SmsService;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSmsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public Notification $notification) {}

    public function handle(): void
    {
        $notification = $this->notification->fresh([
            'witness',
            'schedule.hearing.case.court',
            'schedule.template'
        ]);

        $witness  = $notification->witness;
        $schedule = $notification->schedule;
        $hearing  = $schedule?->hearing;
        $case     = $hearing?->case;
        $court    = $case?->court;
        $template = $schedule?->template;

        /** 🔴 Hard validation */
        if (!$witness || !$schedule || !$hearing || !$case || !$court || !$template) {
            Log::error('SMS aborted – missing relation', [
                'notification_id' => $notification->id,
                'has_witness'  => (bool) $witness,
                'has_schedule' => (bool) $schedule,
                'has_hearing'  => (bool) $hearing,
                'has_case'     => (bool) $case,
                'has_court'    => (bool) $court,
                'has_template' => (bool) $template,
            ]);
            return;
        }

        /** 🕒 Safe hearing date handling */
        try {
            $hearingDate = Carbon::parse($hearing->hearing_date)->format('d M Y');
        } catch (\Throwable $e) {
            Log::error('Invalid hearing_date', [
                'notification_id' => $notification->id,
                'value' => $hearing->hearing_date,
            ]);
            return;
        }

        /** 🧾 Prepare SMS body */
        $message = str_replace(
            ['{witness_name}', '{hearing_date}', '{court_name}', '{case_no}'],
            [
                $witness->name,
                $hearingDate,
                $court->name_bn ?? $court->name_en ?? $court->name,
                $case->case_no,
            ],
            $template->body_bn_sms
        );

        Log::info('Sending SMS', [
            'notification_id' => $notification->id,
            'to' => $witness->phone,
            'message' => $message,
        ]);

        /** 🚀 Send SMS – prepend 88 for international format */
        $sms = app(SmsService::class)->send([
            [
                'to' => '88' . $witness->phone,
                'message' => $message,
            ]
        ]);

        $response = $sms['response'][0] ?? [];
        $success = ($response['response_code'] ?? null) === 200;

        $notification->update([
            'status'   => $success ? 'sent' : 'failed',
            'sent_at'  => $success ? now() : null,
            'response' => $response,
        ]);

        Log::info('SMS processed', [
            'notification_id' => $notification->id,
            'status' => $notification->status,
        ]);
    }
}
