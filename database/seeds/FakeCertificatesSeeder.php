<?php

use App\Models\Certificate;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Class FakeCertificatesSeeder
 */
class FakeCertificatesSeeder extends Seeder
{
    /**
     * @var int
     */
    private $length = 50;

    public function run()
    {
        $this->command->line('<comment>Generate loyalty certificates </comment>');
        $progressBar = new ProgressBar($this->command->getOutput());
        $progressBar->start($this->length);

        for ($i = 0; $i < $this->length; $i++) {
            $this->createCertificate();
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->line('');
    }

    private function createCertificate(): void
    {
        factory(Certificate::class)->create();
    }
}
