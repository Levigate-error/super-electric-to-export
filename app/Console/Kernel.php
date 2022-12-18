<?php

namespace App\Console;

use App\Console\Commands\Import\NewsImport;
use App\Console\Commands\Import\ProductsImport;
use App\Console\Commands\News\LinkConverter;
use App\Console\Commands\Video\UrlConverter;
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
        ProductsImport::class,
        NewsImport::class,
        LinkConverter::class,
        UrlConverter::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('import:products')->cron('0 */1 * * *');
        $schedule->command('import:news')->cron('30 10 * * *');
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
