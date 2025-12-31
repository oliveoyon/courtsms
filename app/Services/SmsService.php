<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    protected string $tokenUrl;
    protected string $smsUrl;
    protected string $clientId;
    protected string $clientSecret;
    protected string $grantType;
    protected int $retryCount;

    public function __construct()
    {
        $this->tokenUrl     = env('SMS_API_URL_FOR_TOKEN');
        $this->smsUrl       = env('SMS_API_URL_FOR_SEND');
        $this->clientId     = env('SMS_CLIENT_ID');
        $this->clientSecret = env('SMS_CLIENT_SECRET');
        $this->grantType    = env('SMS_GRANT_TYPE', 'client_credentials');
        $this->retryCount   = env('SMS_RETRY_COUNT', 2); // number of retries for failed SMS
    }

    /**
     * Send multiple SMS messages (one by one)
     *
     * @param array $messages [['to' => '8801XXXXXXXXX', 'message' => 'Text message'], ...]
     * @return array
     */
    public function send(array $messages): array
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return [
                'response_code' => 401,
                'response'      => 'Unable to get access token',
                'messages'      => $messages,
            ];
        }

        $responses = [];
        $finalResponseCode = 200;

        foreach ($messages as $msg) {
            if (empty($msg['message']) || empty($msg['to'])) {
                $responses[] = [
                    'message'       => $msg['message'] ?? null,
                    'to'            => $msg['to'] ?? null,
                    'response_code' => 400,
                    'response'      => 'Missing message or destination',
                ];
                $finalResponseCode = 400;
                continue;
            }

            $payload = [
                'msg'         => $msg['message'],
                'destination' => $msg['to'],
            ];

            $attempt = 0;
            $success = false;
            $responseData = null;

            while ($attempt <= $this->retryCount && !$success) {
                $attempt++;
                try {
                    $response = Http::withoutVerifying()
                        ->withToken($token)
                        ->withHeaders(['Content-Type' => 'application/json'])
                        ->post($this->smsUrl, $payload);

                    if ($response->successful()) {
                        $responseData = $response->json();
                        $success = true;
                        $respCode = 200;
                    } else {
                        $responseData = $response->body();
                        $respCode = $response->status();
                        Log::warning('SMS send failed', [
                            'to'            => $msg['to'],
                            'message'       => $msg['message'],
                            'response_code' => $respCode,
                            'attempt'       => $attempt,
                            'response'      => $responseData,
                        ]);
                        sleep(1); // wait before retry
                    }
                } catch (\Exception $e) {
                    $respCode = 500;
                    $responseData = $e->getMessage();
                    Log::error('SMS send exception', [
                        'to'       => $msg['to'],
                        'message'  => $msg['message'],
                        'attempt'  => $attempt,
                        'exception'=> $e,
                    ]);
                    sleep(1); // wait before retry
                }
            }

            if (!$success) {
                $finalResponseCode = max($finalResponseCode, $respCode);
            }

            $responses[] = [
                'message'       => $msg['message'],
                'to'            => $msg['to'],
                'response_code' => $respCode,
                'response'      => $responseData,
                'attempts'      => $attempt,
            ];
        }

        return [
            'response_code' => $finalResponseCode,
            'response'      => $responses,
            'messages'      => $messages,
        ];
    }

    /**
     * Get SMS access token and cache it using actual expiry from API
     */
    private function getAccessToken(): ?string
    {
        return Cache::remember('court_sms_token', now()->addMinutes(50), function () {
            try {
                $response = Http::withoutVerifying()
                    ->asForm()
                    ->post($this->tokenUrl, [
                        'grant_type'    => $this->grantType,
                        'client_id'     => $this->clientId,
                        'client_secret' => $this->clientSecret,
                    ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $token = $data['access_token'] ?? null;
                    $expiresIn = $data['expires_in'] ?? 3000; // seconds
                    if ($token) {
                        // cache token with its actual expiry minus 1 min buffer
                        Cache::put('court_sms_token', $token, now()->addSeconds($expiresIn - 60));
                    }
                    return $token;
                }

                Log::error('Failed to get SMS access token', ['response' => $response->body()]);
                return null;
            } catch (\Exception $e) {
                Log::error('Exception getting SMS access token', ['exception' => $e]);
                return null;
            }
        });
    }

    /**
     * Retrieve balance (not supported in new API)
     */
    public function getBalance(): array
    {
        return [
            'balance'  => null,
            'response' => 'Balance check not supported in new API',
        ];
    }

    /**
     * Map response codes for legacy usage
     */
    public function mapResponseCode(int $code): string
    {
        $codes = [
            200 => 'SMS Sent Successfully',
            400 => 'Bad Request / Validation Failed',
            401 => 'Unauthorized / Invalid Token',
            403 => 'Forbidden / Access Denied',
            404 => 'Endpoint Not Found',
            429 => 'Rate Limit Exceeded',
            500 => 'Internal Server Error',
        ];

        return $codes[$code] ?? 'Unknown Error';
    }
}
