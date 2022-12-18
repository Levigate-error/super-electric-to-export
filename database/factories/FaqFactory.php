<?php

use App\Models\Faq;
use Faker\Generator as Faker;

$factory->define(Faq::class, static function (Faker $faker) {
    return [
        'question' => $faker->text(150),
        'answer' => $faker->text(200),
    ];
});
