<?php

use App\Models\Project\ProjectStatus;
use Faker\Generator as Faker;

$factory->define(ProjectStatus::class, static function (Faker $faker) {
    return [
        'title' => setup_field_translate($faker->word),
        'slug' => $faker->slug,
        'color' => $faker->colorName,
    ];
});
