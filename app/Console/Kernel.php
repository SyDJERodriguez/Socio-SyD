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
        Commands\InvitationInsuranceNegocio::class,
        Commands\InvitationInsuranceIndividual::class,
        Commands\InvitationInsurance30Individual::class,
        Commands\InvitationInsurance30Negocio::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('schedule:seguroNegocio')       ->monthlyOn(15, '10:00'); //15/mes
        $schedule->command('schedule:seguroIndividual')    ->monthlyOn(15, '10:00'); //15/mes
        $schedule->command('schedule:seguroIndividual30')  ->monthlyOn(30, '10:00'); //30/mes
        $schedule->command('schedule:seguroNegocio30')     ->monthlyOn(30, '10:00'); //30/mes
        
        //testing
        //$schedule->command('schedule:seguroIndividual')->everyMinute();
        //$schedule->command('schedule:seguroNegocio')->everyMinute();
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
