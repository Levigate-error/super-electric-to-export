<?php

use App\Models\ProductCategory;
use Faker\Generator as Faker;

$factory->define(ProductCategory::class, static function (Faker $faker) {
    return [
        'name' => setup_field_translate($faker->word),
    ];
});
