<?php

use App\Models\Loyalty\LoyaltyUser;
use App\Models\Loyalty\LoyaltyUserPoint;
use Faker\Generator as Faker;

$factory->define(LoyaltyUserPoint::class, static function (Faker $faker) {
    $loyaltyUser = LoyaltyUser::inRandomOrder()->first();
    if (empty($loyaltyUser) === true) {
        $loyaltyUser = factory(LoyaltyUser::class)->create();
    }

    return [
        'points' => $faker->numberBetween(1, 15),
        'loyalty_user_id' => $loyaltyUser->id,
    ];
});
