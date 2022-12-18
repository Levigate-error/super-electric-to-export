<?php

namespace App\Console\Commands\Db;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class Clear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:clear {--force : Force the operation to run when in production}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаляет все таблицы в схеме базы данных';

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
        $this->info('Start DB clear');
        Schema::dropAllTables();
        $this->info('DB clear completed');
    }
}
