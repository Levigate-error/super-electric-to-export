<?php

use App\Models\Loyalty\LoyaltyProductCode;
use Faker\Generator as Faker;

$factory->define(LoyaltyProductCode::class, static function (Faker $faker) {
    return [
        'code' => $faker->isbn10,
    ];
});
