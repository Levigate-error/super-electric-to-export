<?php

use Illuminate\Database\Seeder;
use App\Models\Loyalty\LoyaltyUserCategory;
use Illuminate\Support\Facades\DB;

/**
 * Class LoyaltyUserCategoriesSeeder
 */
class LoyaltyUserCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $resource = [
            [
                'title' => ['ru' => 'Новичок'],
                'icon' => 'newbie.svg',
                'points' => '1',
            ],
            [
                'title' => ['ru' => 'Мастер'],
                'icon' => 'master.svg',
                'points' => '5',
            ],
            [
                'title' => ['ru' => 'Профессионал'],
                'icon' => 'professional.svg',
                'points' => '10',
            ],
            [
                'title' => ['ru' => 'Эксперт'],
                'icon' => 'expert.svg',
                'points' => '20',
            ],
            [
                'title' => ['ru' => 'Суперэлектрик'],
                'icon' => 'superelectric.svg',
                'points' => '30',
            ],
        ];

        DB::table('loyalty_user_categories')->truncate();

        foreach ($resource as $category) {
            $model = new LoyaltyUserCategory($category);

            $model->selfSetupTranslate();
            $model->trySaveModel();
        }
    }
}
