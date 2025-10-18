<?php

namespace Seara\Console;

use Seara\Console\Commands\DropTables;
use Seara\Console\Commands\ImportCustomer;
use Seara\Console\Commands\MigrateOldEntries;
use Seara\Console\Commands\MigrateViews;
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
        ImportCustomer::class,
        MigrateViews::class,
        DropTables::class,
        MigrateOldEntries::class
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
    }
}
