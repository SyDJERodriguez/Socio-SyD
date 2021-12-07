<?php

namespace App\Console;

use Aws\Command;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ResetFlagSmsInsurance::class,
        Commands\EmailsMonthly20::class,
        Commands\EmailsEndMonthly::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //For check daily if customer has minimum amount for insurance benefit
        $schedule->command('schedule:daily_check_insurance')->dailyAt('10:00');

        //For dispatch emails and sms on 20 every month
        $schedule->command('schedule:monthly_20')->monthlyOn(20, '10:00');

        //For dispatch emails and sms end of the month
        $schedule->command('schedule:end_monthly')->monthly();

        //Reset flag on 1th every month
        $schedule->command('schedule:reset_flag_sms_insurance')->monthlyOn(1,'00:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
