<?php

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Seeder;
use Database\Seeds\Helpers\LoyaltyProductCodeResources;
use App\Domain\ServiceContracts\Loyalty\LoyaltyProductCodeServiceContract;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * Class LoyaltyProductCodesSeeder
 */
class LoyaltyProductCodesSeeder extends Seeder
{
    /**
     * @throws BindingResolutionException
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function run(): void
    {
        $resourcesHelper = new LoyaltyProductCodeResources();
        $loyaltyProductCodes = $resourcesHelper->getData();

        $this->saveLoyaltyProductCodes($loyaltyProductCodes);
    }

    /**
     * @param  array  $loyaltyProductCodes
     * @throws BindingResolutionException
     */
    protected function saveLoyaltyProductCodes(array $loyaltyProductCodes): void
    {
        $service = app()->make(LoyaltyProductCodeServiceContract::class);

        $this->command->line('<comment>Parse product codes</comment>');
        $progressBar = new ProgressBar($this->command->getOutput());
        $progressBar->start(count($loyaltyProductCodes));

        foreach ($loyaltyProductCodes as $loyaltyProductCode) {
            $productCode = $service->getProductCodeByCode($loyaltyProductCode);

            if ($productCode->resource !== null) {
                continue;
            }

            $service->createProductCode([
                'code' => $loyaltyProductCode,
            ]);

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->line('');
    }
}
