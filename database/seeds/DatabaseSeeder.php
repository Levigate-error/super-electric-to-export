<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminUserRolePermissionSeeder::class,
            AdminMenuSeeder::class,
            ProductsSeeder::class,
            ProductsNewSeeder::class,
            ProjectStatusSeeder::class,
            ProjectAttributesSeeder::class,
            AnaloguesSeeder::class,
            LoyaltyUserCategoriesSeeder::class,
            CitiesSeeder::class,
            CustomRolesTableSeeder::class,
            CustomPermissionsTableSeeder::class,
            CustomConnectRelationshipsSeeder::class,
            LoyaltiesSeeder::class,
            LoyaltyProposalCancelReasonsSeeder::class,
        ]);

        if (app()->environment('production') === false) {
            $this->call([
                FakeUsersSeeder::class,
                FakeProjectsSeeder::class,
                FakeCertificatesSeeder::class,
                FakeLoyaltyProductCodesSeeder::class,
                VideoCategoriesFakeSeeder::class,
                VideosFakeSeeder::class,
                FaqFakeSeeder::class,
                NewsFakeSeeder::class,
                FeedbackFakeSeeder::class,
                FullTestsFakeSeeder::class,
            ]);
        }
    }
}
