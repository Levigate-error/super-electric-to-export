<?php

use App\Models\Test\TestQuestion;
use App\Models\Test\TestAnswer;
use Faker\Generator as Faker;

$factory->define(TestAnswer::class, static function (Faker $faker) {
    $testQuestion = TestQuestion::inRandomOrder()->first();
    if (empty($testQuestion) === true) {
        $testQuestion = factory(TestQuestion::class)->create();
    }

    return [
        'test_question_id' => $testQuestion->id,
        'answer' => $faker->text(100),
        'is_correct' => $faker->boolean,
        'description' => $faker->text(200),
        'points' => $faker->numberBetween(1, 10),
        'published' => $faker->boolean,
    ];
});
