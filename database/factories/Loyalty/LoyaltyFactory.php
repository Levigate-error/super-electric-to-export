<?php

use App\Models\Loyalty\Loyalty;
use Faker\Generator as Faker;

$factory->define(Loyalty::class, static function (Faker $faker) {
    $now = now();

    return [
        'title' => 'Акция',
        'started_at' => $now,
        'ended_at' => $now->addYear(),
    ];
});
