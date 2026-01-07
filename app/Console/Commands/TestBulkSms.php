<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ScheduledSmsService;

class TestBulkSms extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'sms:test-bulk {count=10}';

    /**
     * The console command description.
     */
    protected $description = 'Dispatch multiple fake SMS to test ScheduledSmsService';

    protected ScheduledSmsService $smsService;

    /**
     * Create a new command instance.
     */
    public function __construct(ScheduledSmsService $smsService)
    {
        parent::__construct();
        $this->smsService = $smsService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $count = (int) $this->argument('count');
        $this->info("Dispatching $count fake SMS jobs...");

        // Static test number
        $testNumber = '01712105580';
        $messageTemplate = 'This is a fake/test SMS to stress-test the queue.';

        $successCount = 0;
        $failCount = 0;

        for ($i = 1; $i <= $count; $i++) {
            // Append counter so you can see unique messages
            $message = $messageTemplate . " (#$i)";

            $response = $this->smsService->sendSms($testNumber, $message);

            if ($response['success']) {
                $successCount++;
                $this->line("✅ SMS #$i sent successfully.");
            } else {
                $failCount++;
                $this->line("❌ SMS #$i failed: " . json_encode($response['response']));
            }

            // Small delay to avoid hitting rate limits
            usleep(200_000); // 0.2 sec
        }

        $this->info("Bulk SMS Test Complete: Success=$successCount, Failed=$failCount");

        return 0;
    }
}
