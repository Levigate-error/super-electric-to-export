<?php

use App\Models\Test\Test;
use Faker\Generator as Faker;

$factory->define(Test::class, static function (Faker $faker) {
    return [
        'title' => $faker->word,
        'image' => $faker->imageUrl(),
        'description' => $faker->text(200),
        'published' => $faker->boolean,
    ];
});
