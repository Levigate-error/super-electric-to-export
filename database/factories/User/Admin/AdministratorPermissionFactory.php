<?php

use Faker\Generator as Faker;
use Encore\Admin\Auth\Database\Permission;

$factory->define(Permission::class, static function (Faker $faker) {
    return [
        'name'        => 'All permission',
        'slug'        => '*',
        'http_method' => '',
        'http_path'   => '*',
    ];
});
