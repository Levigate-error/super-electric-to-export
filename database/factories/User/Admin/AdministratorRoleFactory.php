<?php

use Faker\Generator as Faker;
use Encore\Admin\Auth\Database\Role;

$factory->define(Role::class, static function (Faker $faker) {
    return [
        'name' => 'Administrator',
        'slug' => 'administrator',
    ];
});
