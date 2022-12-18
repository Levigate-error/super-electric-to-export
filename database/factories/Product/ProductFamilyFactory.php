<?php

use App\Models\ProductFamily;
use Faker\Generator as Faker;

$factory->define(ProductFamily::class, static function (Faker $faker) {
    return [
        'name' => setup_field_translate($faker->word),
        'number' => $faker->numberBetween(1, 200),
        'code' => $faker->isbn10,
    ];
});
