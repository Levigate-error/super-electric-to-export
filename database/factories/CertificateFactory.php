<?php

use App\Models\Certificate;
use Faker\Generator as Faker;

$factory->define(Certificate::class, static function (Faker $faker) {
    return [
        'code' => $faker->isbn10,
    ];
});
