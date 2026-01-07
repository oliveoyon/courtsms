<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ScheduledSmsService
{
    // ======= CONFIGURABLE STATIC VARIABLES =======
    protected string $apiUrl = 'https://api-k8s.oss.net.bd/api/broker-service/sms/send_sms';
    protected string $clientId = 'Court SMS';
    protected string $clientSecret = '1QYOAC0OKqbcNrM1e2e6b1w0Lo8MOjUb';
    protected int $maxRetries = 5; // more retries for production
    protected int $retryDelaySeconds = 2; // exponential backoff can be added
    protected bool $devMode = true; // true = fake SMS, false = real
    // ============================================

    /**
     * Send a single SMS
     */
    public function sendSms(string $to, string $message): array
    {
        $attempt = 0;
        $success = false;
        $responseData = null;

        while ($attempt < $this->maxRetries && !$success) {
            $attempt++;

            try {
                if ($this->devMode) {
                    // FAKE SMS SUCCESS
                    $responseData = [
                        'response_code' => 200,
                        'response' => [
                            'response_code' => 200,
                            'success' => true,
                            'message' => $message,
                            'to' => $to,
                            'attempts' => $attempt,
                            'provider' => 'mnet',
                            'masking' => 'Court SMS',
                        ]
                    ];
                    $success = true;
                    break;
                }

                // REAL SMS
                $payload = [
                    'msg' => $message,
                    'destination' => $to,
                ];

                $response = Http::withoutVerifying()
                    ->withHeaders(['Content-Type' => 'application/json'])
                    ->post($this->apiUrl, $payload);

                $responseData = $response->json();

                if (
                    $response->successful() &&
                    isset($responseData['response'][0]['success']) &&
                    $responseData['response'][0]['success'] === true
                ) {
                    $success = true;
                    break;
                }

                $responseData['success'] = false;
                sleep($this->retryDelaySeconds);

            } catch (\Exception $e) {
                $responseData = [
                    'success' => false,
                    'error' => $e->getMessage()
                ];
                sleep($this->retryDelaySeconds);
                Log::error('SMS Send Exception', [
                    'to' => $to,
                    'message' => $message,
                    'attempt' => $attempt,
                    'exception' => $e->getMessage()
                ]);
            }
        }

        return [
            'success' => $success,
            'response' => $responseData,
            'attempts' => $attempt,
        ];
    }
}
