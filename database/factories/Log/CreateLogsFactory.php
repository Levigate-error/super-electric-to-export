<?php

use App\Models\Log\CreateLog;
use Faker\Generator as Faker;

$factory->define(CreateLog::class, static function (Faker $faker) {
    return [
        'logable_id' => $faker->unique()->randomDigit,
        'logable_type' => $faker->word,
        'ip' => $faker->ipv4,
        'client' => $faker->userAgent,
    ];
});
