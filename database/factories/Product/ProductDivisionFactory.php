<?php

use App\Models\ProductDivision;
use App\Models\ProductCategory;
use Faker\Generator as Faker;

$factory->define(ProductDivision::class, static function (Faker $faker) {
    $category = ProductCategory::inRandomOrder()->first();
    if (empty($category) === true) {
        $category = factory(ProductCategory::class)->create();
    }

    return [
        'name' => setup_field_translate($faker->word),
        'category_id' => $category->id,
    ];
});
