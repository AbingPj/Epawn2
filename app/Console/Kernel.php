<?php

namespace App\Console;

use App\Events\EpawnEvent;
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
        // $schedule->command('epawn:sample')
        //     ->everyMinute()
        //     ->appendOutputTo('epawn-sample.log');;
        $schedule->command('epawn:send-confiscation')
            ->dailyAt('00:01')
            ->timezone('Asia/Manila')
            ->appendOutputTo('epawn-sendconfiscation.log');
        $schedule->command('epawn:confiscate')
            ->dailyAt('00:01')
            ->timezone('Asia/Manila')
            ->appendOutputTo('epawn-confiscate.log');
        $schedule->command('epawn:send-penalty')
            ->dailyAt('00:01')
            ->timezone('Asia/Manila')
            ->appendOutputTo('epawn-warning.log');
        $schedule->command('epawn:update-expiration')
            ->dailyAt('00:01')
            ->timezone('Asia/Manila')
            ->appendOutputTo('epawn-pawnshop-expiration.log');
        ///for testing here
        // $schedule->command('epawn:send-confiscation')->everyMinute()->timezone('Asia/Manila')->appendOutputTo('epawn-sendconfiscation.log');
        // $schedule->command('epawn:confiscate')->everyMinute()->timezone('Asia/Manila')->appendOutputTo('epawn-confiscate.log');
        // go daddy cronjob call
        // /usr/local/bin/php /home/dwk82pa7p1tk/public_html/epawn/artisan schedule:run >> /dev/null 2>&1
        // /usr/local/bin/php /home/eg04676dv2fd/master/Epawn2/artisan schedule:run >> /dev/null 2>&1
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
