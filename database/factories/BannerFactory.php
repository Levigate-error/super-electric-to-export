<?php

use App\Models\Banner;
use Faker\Generator as Faker;

$factory->define(Banner::class, static function (Faker $faker) {
    return [
        'title' => $faker->word,
        'url' => $faker->url,
    ];
});
