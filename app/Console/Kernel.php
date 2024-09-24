<?php

namespace App\Console;

use App\Jobs\ProcessForgottenCart;
use App\Jobs\ProcessForgottenCartHubspot;
use App\Jobs\ProcessForgottenCartReset;
use Illuminate\Console\Scheduling\Schedule;
use Themosis\Core\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Console commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('publish:future-posts')->twiceDaily();
        $schedule->job(new ProcessForgottenCartHubspot)->daily();
        $schedule->job(new ProcessForgottenCart)->hourly();
        // $schedule->job(new ProcessForgottenCartReset)->cron('0 0 15 * *');

    }

    /**
     * Register the commands for the application.
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
