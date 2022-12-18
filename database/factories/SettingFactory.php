<?php

use App\Models\Setting;
use Faker\Generator as Faker;

$factory->define(Setting::class, static function (Faker $faker) {
    return [
        'key' => $faker->unique()->word,
        'value' => $faker->word,
    ];
});
