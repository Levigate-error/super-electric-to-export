<?php

use App\Models\Product;
use App\Models\ProductDivision;
use App\Models\ProductFamily;
use Faker\Generator as Faker;

$factory->define(Product::class, static function (Faker $faker) {
    $division = ProductDivision::inRandomOrder()->first();
    if (empty($division) === true) {
        $division = factory(ProductDivision::class)->create();
    }

    $family = ProductFamily::inRandomOrder()->first();
    if (empty($family) === true) {
        $family = factory(ProductFamily::class)->create();
    }

    return [
        'vendor_code' => $faker->isbn10,
        'name' => setup_field_translate($faker->word),
        'recommended_retail_price' => $faker->randomFloat(2, 0, 10000),
        'min_amount' => 1,
        'unit' => setup_field_translate('ШТ'),
        'category_id' => $division->category_id,
        'division_id' => $division->id,
        'family_id' => $family->id,
    ];
});
