<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Support\Facades\DB;
use App\Models\Loyalty\Loyalty;

/**
 * Class LoyaltiesSeeder
 */
class LoyaltiesSeeder extends Seeder
{
    /**
     * @var int
     */
    private $length = 1;

    public function run()
    {
        DB::table('loyalties')->truncate();

        $this->command->line('<comment>Generate loyalties </comment>');
        $progressBar = new ProgressBar($this->command->getOutput());
        $progressBar->start($this->length);

        for ($i = 0; $i < $this->length; $i++) {
            $this->createLoyalty();
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->line('');
    }

    private function createLoyalty(): void
    {
        factory(Loyalty::class)->create();
    }
}
