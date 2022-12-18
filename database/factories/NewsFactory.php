<?php

use App\Models\News;
use Faker\Generator as Faker;

$factory->define(News::class, static function (Faker $faker) {
    return [
        'title' => $faker->text(5),
        'description' => $faker->text(400),
        'short_description' => $faker->text(200),
    ];
});
