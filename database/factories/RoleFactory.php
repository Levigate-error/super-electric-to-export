<?php

use Faker\Generator as Faker;

$factory->define(config('roles.models.role'), static function (Faker $faker) {
    return [
        'name' => $faker->name,
        'slug' => $faker->slug,
        'description' => $faker->name,
        'level' => $faker->randomDigit,
    ];
});
