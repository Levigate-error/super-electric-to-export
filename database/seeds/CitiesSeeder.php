<?php

use Illuminate\Database\Seeder;
use Database\Seeds\Helpers\CityResources as ResourcesHelper;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;

class CitiesSeeder extends Seeder
{
    public const LANG = [
        'ru' => 'B',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function run(): void
    {
        $resourcesHelper = new ResourcesHelper();
        $cities = $resourcesHelper->getData(self::LANG);

        $this->saveCities($cities);
    }

    /**
     * @param array $cities
     */
    protected function saveCities(array $cities): void
    {
        $this->command->line('<comment>Parse cities</comment>');
        $progressBar = new ProgressBar($this->command->getOutput());
        $progressBar->start(count($cities));

        foreach ($cities as $city) {
            $model = new City([
                'title' => $city
            ]);

            $model->selfSetupTranslate();
            $model->trySaveModel();

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->command->line('');
    }
}
