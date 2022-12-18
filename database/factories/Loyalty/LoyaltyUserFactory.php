<?php

use App\Models\Certificate;
use App\Models\Loyalty\LoyaltyUser;
use App\Models\Loyalty\Loyalty;
use App\Models\Loyalty\LoyaltyUserCategory;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(LoyaltyUser::class, static function (Faker $faker) {
    $user = User::inRandomOrder()->first();
    if (empty($user) === true) {
        $user = factory(User::class)->create();
    }

    $certificate = Certificate::inRandomOrder()->first();
    if (empty($certificate) === true) {
        $certificate = factory(Certificate::class)->create();
    }

    $loyalty = Loyalty::inRandomOrder()->first();
    if (empty($loyalty) === true) {
        $loyalty = factory(Loyalty::class)->create();
    }

    $loyaltyUserCategory = LoyaltyUserCategory::inRandomOrder()->first();

    return [
        'user_id' => $user->id,
        'loyalty_certificate_id' => $certificate->id,
        'loyalty_id' => $loyalty->id,
        'status' => 'new',
        'loyalty_user_category_id' => $loyaltyUserCategory->id,
    ];
});
