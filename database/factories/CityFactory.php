<?php

use App\Models\City;
use Faker\Generator as Faker;

$factory->define(City::class, static function (Faker $faker) {
    return [
        'title' => setup_field_translate($faker->city),
    ];
});
