<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Support\Facades\DB;

/**
 * Class BaseFakeSeeder
 */
abstract class BaseFakeSeeder extends Seeder
{
    /**
     * @var int
     */
    protected $entityCount = 10;

    /**
     * @var string
     */
    protected $entityTitle = 'Generate';

    /**
     * @var string|null
     */
    protected $truncateTable;

    /**
     * @return mixed
     */
    abstract protected function createEntity();

    /**
     * @return int
     */
    protected function getEntityCount() :int
    {
        return $this->entityCount;
    }

    /**
     * @return string
     */
    protected function getEntityTitle() :string
    {
        return $this->entityTitle;
    }

    /**
     * @return string|null
     */
    protected function getTruncateTable() :?string
    {
        return $this->truncateTable;
    }

    public function run()
    {
        $title = $this->getEntityTitle();
        $count = $this->getEntityCount();
        $truncateTable = $this->getTruncateTable();

        if ($truncateTable !== null) {
            DB::table($truncateTable)->truncate();
        }

        $this->command->line("<comment>$title</comment>");
        $progressBar = new ProgressBar($this->command->getOutput());
        $progressBar->start($count);

        for ($i = 0; $i < $count; $i++) {
            $this->createEntity();
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->line('');
    }
}
