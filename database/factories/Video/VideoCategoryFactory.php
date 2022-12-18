<?php

use App\Models\Video\VideoCategory;
use Faker\Generator as Faker;

$factory->define(VideoCategory::class, static function (Faker $faker) {
    $locale = get_current_local();

    return [
        'title' => setup_field_translate($faker->word),
    ];
});
