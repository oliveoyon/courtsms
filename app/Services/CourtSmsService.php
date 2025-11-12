<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CourtSmsService
{
    protected $tokenUrl;
    protected $smsUrl;
    protected $clientId;
    protected $clientSecret;
    protected $grantType;

    public function __construct()
    {
        $this->tokenUrl = env('SMS_API_URL_FOR_TOKEN');
        $this->smsUrl = env('SMS_API_URL_FOR_SEND');
        $this->clientId = env('SMS_CLIENT_ID');
        $this->clientSecret = env('SMS_CLIENT_SECRET');
        $this->grantType = env('SMS_GRANT_TYPE');
    }

    private function getAccessToken()
    {
        $response = Http::withoutVerifying() // 🔹 bypass SSL for localhost only
            ->asForm()
            ->post($this->tokenUrl, [
                'grant_type' => $this->grantType,
                'client_id' => $this->clientId,
                'client_secret' => $this->clientSecret,
            ]);

        return $response->json()['access_token'] ?? null;
    }

    public function sendSms($destination, $message)
    {
        $token = $this->getAccessToken();

        if (!$token) {
            return ['error' => 'Unable to get access token'];
        }

        $response = Http::withoutVerifying() // 🔹 bypass SSL for localhost only
            ->withHeaders([
                'Authorization' => "Bearer {$token}",
                'Content-Type' => 'application/json',
            ])
            ->post($this->smsUrl, [
                'msg' => $message,
                'destination' => $destination,
            ]);

        return $response->json();
    }
}
