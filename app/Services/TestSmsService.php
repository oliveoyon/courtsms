<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Exception;

class TestSmsService
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
        $this->grantType    = env('SMS_GRANT_TYPE', 'client_credentials');
    }

    /**
     * Get access token (cached for ~1 hour)
     */
    protected function getAccessToken(): string
    {
        return Cache::remember('test_sms_token', 3500, function () {
            $response = Http::asForm()
                ->withoutVerifying() // ignore SSL temporarily
                ->post($this->tokenUrl, [
                    'grant_type'    => $this->grantType,
                    'client_id'     => $this->clientId,
                    'client_secret' => $this->clientSecret,
                ]);

            if (!$response->successful()) {
                throw new Exception('Token request failed: ' . $response->body());
            }

            return $response->json()['access_token'];
        });
    }

    /**
     * Send a test SMS and return full API response
     */
    public function sendTestSms(): array
    {
        $token = $this->getAccessToken();

        $response = Http::withToken($token)
            ->withoutVerifying() // ignore SSL temporarily
            ->post($this->smsUrl, [
                'msg' => 'My name is Arif',
                'destination' => '8801712105580',
            ]);

        return [
            'status' => $response->status(),
            'body'   => $response->body(),
            'json'   => $response->json(),
        ];
    }
}
