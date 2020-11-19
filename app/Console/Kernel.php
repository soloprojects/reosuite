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
        //
        'App\Console\Commands\InventoryReorderLevel',
        'App\Console\Commands\Birthday',
        'App\Console\Commands\BirthdayForTempUsers',
        'App\Console\Commands\InventoryContractNotify',
        'App\Console\Commands\LoanDeduction',
        'App\Console\Commands\OdometerLogReminder',
        'App\Console\Commands\VehicleMaintenanceScheduling',
        'App\Console\Commands\EventReminder',

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->command('command:InventoryReorder')
            ->everyMinute();

        $schedule->command('command:VehicleMaintenanceScheduling')
            ->everyMinute();

        $schedule->command('command:Birthday')
            ->everyMinute();

        $schedule->command('command:BirthdayForTempUsers')
            ->everyMinute();

        $schedule->command('command:OdometerLogReminder')
            ->everyMinute();

        $schedule->command('command:EventReminder')
            ->everyMinute();

        $schedule->command('command:LoanDeduction')
            ->everyMinute();


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
