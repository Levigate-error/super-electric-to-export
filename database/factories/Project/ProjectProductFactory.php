<?php

use App\Models\Project\Project;
use App\Models\Project\ProjectProduct;
use App\Models\Product;
use Faker\Generator as Faker;

$factory->define(ProjectProduct::class, static function (Faker $faker) {
    $project = Project::inRandomOrder()->first();
    if (empty($project) === true) {
        $project = factory(Project::class)->create();
    }

    $product = factory(Product::class)->create();

    return [
        'project_id' => $project->id,
        'product_id' => $product->id,
        'amount' => $faker->numberBetween(1, 10),
        'real_price' => $product->recommended_retail_price,
        'discount' => 0,
        'price_with_discount' => $product->recommended_retail_price,
    ];
});
