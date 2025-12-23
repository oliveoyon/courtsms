<?php

namespace App\Http\Controllers;

use App\Services\TestSmsService;

class TestSmsDebugController extends Controller
{
    public function send(TestSmsService $smsService)
    {
        $result = $smsService->sendTestSms();

        // Print full API response in browser
        dd($result);
    }
}
