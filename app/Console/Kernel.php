<?php

namespace App\Console;

use App\Jobs\Sys\DeleteOlderZip;
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
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        // $schedule->command('telescope:prune --hours=96')->daily();
        // if(env("APP_URL", "https://pnet.ferramentaparide.it")){
        //     $schedule->exec('/home/forge/script.js')->everyMinute();
        // }
        $schedule->job(new DeleteOlderZip, 'dbSeed')->daily();
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
