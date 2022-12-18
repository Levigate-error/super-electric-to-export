<?php

use App\Models\Project\Project;
use App\Models\Project\ProjectStatus;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Project::class, static function (Faker $faker) {
    $status = ProjectStatus::inRandomOrder()->first();
    if (empty($status) === true) {
        $status = factory(ProjectStatus::class)->create();
    }

    $user = User::inRandomOrder()->first();
    if (empty($user) === true) {
        $user = factory(User::class)->create();
    }

    return [
        'title' => $faker->word,
        'address' => $faker->address,
        'project_status_id' => $status->id,
        'user_id' => $user->id,
    ];
});
