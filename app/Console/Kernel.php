<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	protected function schedule(\Illuminate\Console\Scheduling\Schedule $schedule): void
	{
    		$schedule->command('sms:send-scheduled')
        	->everyMinute()
        	->between('08:00', '22:00')
        	->timezone('Asia/Dhaka')
       	 	->withoutOverlapping();
	}


    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
