<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class SmsService
{
    protected string $tokenUrl;
    protected string $smsUrl;
    protected string $clientId;
    protected string $clientSecret;
    protected string $grantType;

    public function __construct()
    {
        $this->tokenUrl     = env('SMS_API_URL_FOR_TOKEN');
        $this->smsUrl       = env('SMS_API_URL_FOR_SEND');
        $this->clientId     = env('SMS_CLIENT_ID');
        $this->clientSecret = env('SMS_CLIENT_SECRET');
        $this->grantType    = env('SMS_GRANT_TYPE');
    }

    /**
     * Send multiple SMS messages (one by one for new API)
     *
     * Expected format:
     * [
     *   ['to' => '8801XXXXXXXXX', 'message' => 'Text message...'],
     *   ...
     * ]
     */
    public function send(array $messages): array
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return [
                'response_code' => 401,
                'response'      => 'Unable to get access token',
                'messages'      => $messages
            ];
        }

        $responses = [];
        $finalResponseCode = 200;

        foreach ($messages as $msg) {
            $payload = [
                'msg'         => $msg['message'],
                'destination' => $msg['to'],
            ];

            try {
                $response = Http::withoutVerifying()
                    ->withHeaders([
                        'Authorization' => "Bearer {$token}",
                        'Content-Type'  => 'application/json',
                    ])
                    ->post($this->smsUrl, $payload);

                $decoded = $response->json() ?? [];

                // Treat status 200 as success
                $respCode = ($decoded['status'] ?? 0) === 200 ? 200 : ($decoded['responseCode'] ?? 400);

                if ($respCode !== 200) {
                    $finalResponseCode = $respCode;
                }

                $responses[] = [
                    'message'       => $msg['message'],
                    'to'            => $msg['to'],
                    'response_code' => $respCode,
                    'response'      => $decoded,
                ];
            } catch (\Exception $e) {
                $finalResponseCode = 500;
                $responses[] = [
                    'message'       => $msg['message'],
                    'to'            => $msg['to'],
                    'response_code' => 500,
                    'response'      => $e->getMessage(),
                ];
            }
        }

        return [
            'response_code' => $finalResponseCode,
            'response'      => $responses,
            'messages'      => $messages,
        ];
    }

    /**
     * Retrieve balance (not supported in new API)
     */
    public function getBalance(): array
    {
        return [
            'balance'  => null,
            'response' => 'Balance check not supported in new API'
        ];
    }

    /**
     * Get and cache access token for 50 minutes
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
                    return $response->json()['access_token'] ?? null;
                }

                return null;
            } catch (\Exception $e) {
                return null;
            }
        });
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
