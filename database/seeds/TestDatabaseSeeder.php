<?php

use Illuminate\Database\Seeder;

/**
 * Class TestDatabaseSeeder
 *
 * Сидеры необходимые для тестирования
 */
class TestDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CustomRolesTableSeeder::class,
            CustomPermissionsTableSeeder::class,
            CustomConnectRelationshipsSeeder::class,
            ProjectStatusSeeder::class,
            LoyaltyUserCategoriesSeeder::class,
        ]);
    }
}
