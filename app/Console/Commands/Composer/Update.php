<?php

namespace App\Console\Commands\Composer;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'composer:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновляет composer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Start composer update');

        $process = new Process(['composer', 'update'], null, null, null, null);
        $process->run(function ($type, $buffer) {
            $this->line($buffer);

        });

        $this->info('Composer update completed');
    }
}
