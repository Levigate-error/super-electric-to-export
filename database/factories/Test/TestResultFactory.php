<?php

use App\Models\Test\TestResult;
use App\Models\Test\Test;
use Faker\Generator as Faker;

$factory->define(TestResult::class, static function (Faker $faker) {
    $test = Test::inRandomOrder()->first();
    if (empty($test) === true) {
        $test = factory(Test::class)->create();
    }

    return [
        'test_id' => $test->id,
        'title' => $faker->word,
        'description' => $faker->text(200),
        'percent_from' => $faker->numberBetween(1, 50),
        'percent_to' => $faker->numberBetween(51, 100),
        'points' => $faker->numberBetween(1, 50),
    ];
});
