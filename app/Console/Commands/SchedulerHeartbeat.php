<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SchedulerHeartbeat extends Command
{
    protected $signature = 'scheduler:heartbeat';
    protected $description = 'Test heartbeat for scheduler';

    public function handle()
    {
        Log::info('HEARTBEAT SCHEDULER RUN '.now());
        $this->info('Heartbeat executed');
    }
}
