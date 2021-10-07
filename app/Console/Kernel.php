<?php

namespace App\Console;

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
        Commands\EmailInvitationInsurance::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('email:seguroNegocio')->monthlyOn(15, '10:00'); //15/mes
        $schedule->command('email:seguroIndividual')->monthlyOn(15, '10:00'); //15/mes
        $schedule->command('email:seguroIndividual30')->monthlyOn(30, '19:00'); //30/mes
        $schedule->command('email:seguroNegocio30')->monthlyOn(30, '19:00'); //30/mes
        
        //testing
        //$schedule->command('email:seguroNegocio')->everyFiveMinutes(); //20/mes
        //$schedule->command('email:seguroIndividual')->everyMinute(); 
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
