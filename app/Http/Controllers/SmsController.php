<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SmsService;

class SmsController extends Controller
{
    protected SmsService $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    public function testSend()
    {
        $destination = '8801712105580'; // Replace with a valid number
        $message = 'This is a test SMS from CourtSMS using new API';

        $response = $this->smsService->send([
            [
                'to'      => $destination,
                'message' => $message
            ]
        ]);

        return response()->json($response);
    }
}
