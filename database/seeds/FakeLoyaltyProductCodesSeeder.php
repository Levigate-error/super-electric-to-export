<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Illuminate\Support\Facades\DB;
use Faker\Factory;
use Faker\Generator;
use App\Domain\ServiceContracts\Loyalty\LoyaltyProductCodeServiceContract;

/**
 * Class FakeLoyaltyProductCodesSeeder
 */
class FakeLoyaltyProductCodesSeeder extends Seeder
{
    /**
     * @var int
     */
    private $length = 50;

    /**
     * @var Generator
     */
    private $fakerGenerator;

    /**
     * @var LoyaltyProductCodeServiceContract
     */
    private $service;

    /**
     * FakeLoyaltyProductCodesSeeder constructor.
     * @param LoyaltyProductCodeServiceContract $service
     */
    public function __construct(LoyaltyProductCodeServiceContract $service)
    {
        $this->fakerGenerator = Factory::create('ru_RU');
        $this->service = $service;
    }

    public function run()
    {
        DB::table('loyalty_product_codes')->truncate();

        $this->command->line('<comment>Generate loyalty product codes </comment>');
        $progressBar = new ProgressBar($this->command->getOutput());
        $progressBar->start($this->length);

        for ($i = 0; $i < $this->length; $i++) {
            $this->createLoyaltyProductCode();
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->line('');
    }

    /**
     * @return array
     */
    private function createLoyaltyProductCode(): array
    {
        $data = [
            'code' => $this->fakerGenerator->isbn10,
        ];

        return $this->service->createProductCode($data)->resolve();
    }
}
