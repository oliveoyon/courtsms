<?php

namespace App\Services;

class SmsService
{
    protected string $apiUrl = "http://bulksmsbd.net/api/smsapimany";
    protected string $balanceUrl = "http://bulksmsbd.net/api/getBalanceApi";
    protected string $apiKey;
    protected string $senderId;

    public function __construct()
    {
        $this->apiKey   = env('BULKSMS_API_KEY');
        $this->senderId = env('BULKSMS_SENDER_ID');
    }

    public function send(array $messages): array
    {
        $data = [
            'api_key'  => $this->apiKey,
            'senderid' => $this->senderId,
            'messages' => json_encode($messages)
        ];

        $response = $this->post($this->apiUrl, $data);

        $decoded = json_decode($response, true) ?? [];
        $responseCode = $decoded['response_code'] ?? 0;

        return [
            'response_code' => $responseCode,
            'response'      => $response,
            'messages'      => $messages
        ];
    }

    public function getBalance(): array
    {
        $data = ['api_key' => $this->apiKey];
        $response = $this->post($this->balanceUrl, $data);
        return json_decode($response, true) ?? ['balance' => 0, 'response' => $response];
    }

    private function post(string $url, array $data): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public function mapResponseCode(int $code): string
    {
        $codes = [
            202 => 'SMS Submitted Successfully',
            1001 => 'Invalid Number',
            1002 => 'Sender ID not correct/disabled',
            1003 => 'Required fields missing',
            1005 => 'Internal Error',
            1006 => 'Balance Validity Not Available',
            1007 => 'Balance Insufficient',
            1011 => 'User ID not found',
            1012 => 'Masking SMS must be sent in Bengali',
            1013 => 'Sender ID not found by API key',
            1014 => 'Sender Type Name not found using this sender by API key',
            1015 => 'Sender ID has not found Any Valid Gateway by API key',
            1016 => 'Sender Type Name Active Price Info not found by this sender id',
            1017 => 'Sender Type Name Price Info not found by this sender id',
            1018 => 'Account disabled',
            1019 => 'Price of this account is disabled',
            1020 => 'Parent account not found',
            1021 => 'Parent active price info not found',
            1031 => 'Account not verified',
            1032 => 'IP not whitelisted',
        ];

        return $codes[$code] ?? 'Unknown Error';
    }
}
