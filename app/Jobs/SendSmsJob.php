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

    /**
     * Notification IDs to process
     *
     * @var array<int>
     */
    protected array $notificationIds;

    /**
     * Max batch size per API call
     */
    protected int $batchSize = 100;

    /**
     * Max attempts per SMS
     */
    protected int $maxAttempts = 3;

    /**
     * Create a new job instance.
     * Accepts Notification model or array of IDs
     *
     * @param Notification|array<int> $notifications
     */
    public function __construct(Notification|array $notifications)
    {
        if ($notifications instanceof Notification) {
            $this->notificationIds = [$notifications->id];
        } else {
            $this->notificationIds = $notifications;
        }
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $notificationChunks = array_chunk($this->notificationIds, $this->batchSize);

        foreach ($notificationChunks as $chunk) {
            $notifications = Notification::with([
                'witness',
                'schedule.hearing.case.court',
                'schedule.template',
            ])->whereIn('id', $chunk)->get();

            $messages = [];
            foreach ($notifications as $notification) {
                $msg = $this->prepareMessage($notification);
                if ($msg) {
                    $messages[] = $msg;
                }
            }

            if (!empty($messages)) {
                $this->sendBatch($messages);
            }
        }
    }

    /**
     * Prepare a single SMS message
     */
    protected function prepareMessage(Notification $notification): ?array
    {
        $witness  = $notification->witness;
        $schedule = $notification->schedule;
        $hearing  = $schedule?->hearing;
        $case     = $hearing?->case;
        $court    = $case?->court;
        $template = $schedule?->template;

        if (!$witness || !$schedule || !$hearing || !$case || !$court || !$template) {
            Log::error('SMS aborted – missing relation', ['notification_id' => $notification->id]);
            return null;
        }

        $phone = $this->normalizePhone($witness->phone);
        if (!$phone) {
            Log::error('Invalid phone number', ['notification_id' => $notification->id, 'phone' => $witness->phone]);
            $notification->update([
                'status' => 'failed',
                'response' => 'Invalid phone number',
            ]);
            return null;
        }

        try {
            $hearingDate = Carbon::parse($hearing->hearing_date)->format('d-m-Y');
            $hearingDate = $this->toBanglaNumber($hearingDate); // Convert digits to Bangla
        } catch (\Throwable $e) {
            Log::error('Invalid hearing date', ['notification_id' => $notification->id, 'value' => $hearing->hearing_date]);
            return null;
        }

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

        return [
            'notification_id' => $notification->id,
            'to' => $phone,
            'message' => $message,
        ];
    }

    /**
     * Normalize phone number to 8801XXXXXXXXX
     */
    protected function normalizePhone(?string $phone): ?string
    {
        if (!$phone) return null;

        $phone = preg_replace('/\D/', '', $phone); // remove non-digits

        if (str_starts_with($phone, '0') && strlen($phone) === 11) {
            return '88' . $phone;
        } elseif (str_starts_with($phone, '880') && strlen($phone) === 13) {
            return $phone;
        }

        return null; // invalid
    }

    /**
     * Convert digits to Bangla numerals
     */
    protected function toBanglaNumber(string $number): string
    {
        $en = ['0','1','2','3','4','5','6','7','8','9'];
        $bn = ['০','১','২','৩','৪','৫','৬','৭','৮','৯'];
        return str_replace($en, $bn, $number);
    }

    /**
     * Send SMS batch with retry and refresh token handling
     */
    protected function sendBatch(array $messages): void
    {
        $smsService = app(SmsService::class);
        $updateBatch = [];

        foreach ($messages as $msg) {
            $attempt = 0;
            $success = false;

            while ($attempt < $this->maxAttempts && !$success) {
                $attempt++;

                try {
                    $response = $smsService->send([[ 
                        'to' => $msg['to'],
                        'message' => $msg['message'],
                    ]]);

                    $resp = $response['response'][0] ?? [];
                    $success = ($resp['response_code'] ?? null) === 200;

                    if ($success) {
                        $updateBatch[] = [
                            'id' => $msg['notification_id'],
                            'status' => 'sent',
                            'response' => json_encode($resp),
                            'sent_at' => now(),
                        ];
                        break;
                    }

                    // Token expired handling
                    if (($resp['response_code'] ?? null) === 401) {
                        Log::warning('Access token expired, refreshing...', ['notification_id' => $msg['notification_id']]);
                        $smsService->refreshToken();
                        usleep(500000);
                        continue;
                    }

                    Log::warning('SMS failed, retrying...', [
                        'notification_id' => $msg['notification_id'],
                        'attempt' => $attempt,
                        'response' => $resp,
                    ]);
                    usleep(500000 * $attempt);

                } catch (\Throwable $e) {
                    Log::error('SMS send exception', [
                        'notification_id' => $msg['notification_id'],
                        'attempt' => $attempt,
                        'exception' => $e->getMessage(),
                    ]);
                    usleep(500000 * $attempt);
                }
            }

            if (!$success) {
                $updateBatch[] = [
                    'id' => $msg['notification_id'],
                    'status' => 'failed',
                    'response' => isset($resp) ? json_encode($resp) : 'Unknown error',
                    'sent_at' => null,
                ];
            }
        }

        // Safe DB update
        foreach (array_chunk($updateBatch, 50) as $dbChunk) {
            foreach ($dbChunk as $item) {
                try {
                    Notification::find($item['id'])?->update([
                        'status' => $item['status'],
                        'response' => $item['response'],
                        'sent_at' => $item['sent_at'],
                    ]);
                } catch (\Throwable $e) {
                    Log::error('Failed to update notification', ['id' => $item['id'], 'error' => $e->getMessage()]);
                }
            }
        }
    }
}
