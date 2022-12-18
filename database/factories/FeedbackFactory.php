<?php

use App\Models\Feedback;
use App\Domain\Dictionaries\Feedback\FeedbackStatuses;
use App\Domain\Dictionaries\Feedback\FeedbackTypes;
use Faker\Generator as Faker;

$factory->define(Feedback::class, static function (Faker $faker) {
    return [
        'email' => $faker->email,
        'name' => $faker->name,
        'text' => $faker->text(200),
        'status' => $faker->randomElement([
            FeedbackStatuses::NEW,
            FeedbackStatuses::VIEWED,
            FeedbackStatuses::PROCESSED,
        ]),
        'type' => $faker->randomElement([
            FeedbackTypes::COMMON,
            FeedbackTypes::HELP,
        ]),
    ];
});
