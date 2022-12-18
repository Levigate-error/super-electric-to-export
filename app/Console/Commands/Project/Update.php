<?php

namespace App\Console\Commands\Project;

use Illuminate\Console\Command;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:update {--force : Force the operation to run when in production}
               {--db : пересобрать БД}
               {--npm : пересобрать фронт}
               {--composer : обновление composer}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Обновляет проект. Пересборка БД. Сборка фронта. Composer.';

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
        if (!$this->confirm('Do you wish to continue?')) {
            return;
        }

        if ($this->option('npm')) {
            $this->call('npm:build');
        }

        if ($this->option('composer')) {
            $this->call('composer:update');
        }

        if ($this->option('db')) {
            $this->call('db:refresh', ['--force' => $this->option('force')]);
        }
    }
}
