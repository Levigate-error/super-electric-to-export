<?php

use App\Models\Project\Project;
use App\Models\User;
use App\Models\UserActivity;
use Faker\Generator as Faker;

$factory->define(UserActivity::class, static function (Faker $faker) {
    $user = User::inRandomOrder()->first();
    if (empty($user) === true) {
        $user = factory(User::class)->create();
    }

    $project = factory(Project::class)->create([
        'user_id' => $user->id,
    ]);

    return [
        'user_id' => $user->id,
        'source_id' => $project->id,
        'source_type' => $project->getMorphClass(),
    ];
});
