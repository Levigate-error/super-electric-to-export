<?php

use Faker\Generator as Faker;
use Encore\Admin\Auth\Database\Administrator;

$factory->define(Administrator::class, static function (Faker $faker) {
    return [
        'username' => 'admin',
        'password' => bcrypt('admin'),
        'name'     => 'Administrator',
    ];
});
