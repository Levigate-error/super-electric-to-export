<?php

use App\Models\Test\TestQuestion;
use App\Models\Test\Test;
use Faker\Generator as Faker;

$factory->define(TestQuestion::class, static function (Faker $faker) {
    $test = Test::inRandomOrder()->first();
    if (empty($test) === true) {
        $test = factory(Test::class)->create();
    }

    return [
        'test_id' => $test->id,
        'question' => $faker->text(200),
        'image' => $faker->imageUrl(),
        'video' => 'https://www.youtube.com/embed/2aF53cNEynM',
        'published' => $faker->boolean,
    ];
});
