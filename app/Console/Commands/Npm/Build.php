<?php

namespace App\Console\Commands\Npm;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Build extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'npm:build';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Собирает фронт';

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
        $this->info('Start NPM build');

        $process = new Process(['npm', 'install'], null, null, null, null);
        $process->run(function ($type, $buffer) {
            $this->line($buffer);

        });

        $process = new Process(['npm', 'run', 'dev'], null, null, null, null);
        $process->run(function ($type, $buffer) {
            $this->line($buffer);
        });

        $this->info('NPM build completed');
    }
}
