<?php

namespace App\Console\Commands\Db;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Refresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:refresh {--database= : The database connection to use}
                {--force : Force the operation to run when in production}
                {--path= : The path to the migrations files to be executed}
                {--realpath : Indicate any provided migration file paths are pre-resolved absolute paths}
                {--pretend : Dump the SQL queries that would be run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаляет все таблицы в схеме базы данных, применяет заново миграции и сидеры';

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
        $this->call('db:clear', [
            '--force' => $this->option('force')
        ]);

        $this->info('Start DB migrate');

        $process = new Process(['composer', 'dump-autoload'], null, null, null, null);
        $process->run(function ($type, $buffer) {
            $this->line($buffer);

        });

        $this->call('cache:clear');

        $this->call(
            'migrate',
            collect($this->options())
                ->merge([
                    'seed' => true,
                    'force' => true
                ])
                ->mapWithKeys(function($value, $key){
                    return ["--$key" => $value];
                })
                ->toArray()
        );
        $this->info('DB migrate completed');
    }
}
