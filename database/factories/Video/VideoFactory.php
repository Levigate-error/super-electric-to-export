<?php

use App\Models\Video\Video;
use App\Models\Video\VideoCategory;
use Faker\Generator as Faker;

$factory->define(Video::class, static function (Faker $faker) {
    $locale = get_current_local();

    $videoCategory = VideoCategory::inRandomOrder()->first();
    if (empty($videoCategory) === true) {
        $videoCategory = factory(VideoCategory::class)->create();
    }

    return [
        'title' => setup_field_translate($faker->word),
        'video' => 'https://www.youtube.com/embed/2aF53cNEynM',
        'video_category_id' => $videoCategory->id,
    ];
});
