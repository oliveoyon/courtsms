<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScheduledSmsService
{
    protected string $apiUrl;
    protected bool $devMode;
    protected int $maxRetries;
    protected int $retryDelay;

    public function __construct()
    {
        $this->apiUrl = config('sms.api_url_send');

        if (!$this->apiUrl) {
            throw new \Exception('SMS API URL not configured');
        }

        $this->devMode = config('sms.dev_mode', true);
        $this->maxRetries = config('sms.max_retries', 3);
        $this->retryDelay = config('sms.retry_delay', 2);
    }

    public function sendSms(string $to, string $message): array
    {
        $attempt = 0;

        while ($attempt < $this->maxRetries) {
            $attempt++;

            try {
                if ($this->devMode) {
                    return [
                        'success' => true,
                        'response' => [
                            'dev_mode' => true,
                            'to' => $to,
                            'message' => $message,
                        ],
                        'attempts' => $attempt,
                    ];
                }

                $response = Http::post($this->apiUrl, [
                    'msg' => $message,
                    'destination' => $to,
                ]);

                if ($response->successful()) {
                    return [
                        'success' => true,
                        'response' => $response->json(),
                        'attempts' => $attempt,
                    ];
                }

            } catch (\Throwable $e) {
                Log::error('SMS send error', [
                    'attempt' => $attempt,
                    'error' => $e->getMessage(),
                ]);
            }

            sleep($this->retryDelay);
        }

        return [
            'success' => false,
            'response' => 'SMS failed after retries',
            'attempts' => $attempt,
        ];
    }
}
