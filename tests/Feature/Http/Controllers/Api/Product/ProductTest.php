<?php

namespace Tests\Feature\Http\Controllers\Api\Product;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Project\ProjectProduct;
use App\Models\Project\Project;
use Tests\Feature\Http\Controllers\Authenticatable;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ProductTest
 * @package Tests\Feature\Http\Controllers\Api\Product
 */
class ProductTest extends TestCase
{
    use Authenticatable;

    public function testGetRecommended(): void
    {
        Product::query()->truncate();

        $recommendedProduct = factory(Product::class, 5)->create(
            [
                'is_recommended' => true,
            ]
        );

        $notRecommendedProduct = factory(Product::class, 5)->create(
            [
                'is_recommended' => false,
            ]
        );

        $response = $this->json('GET', route('api.catalog.recommended'));

        $expectRecommendedProducts = ProductResource::collection(collect($recommendedProduct))->resolve();

        $response->assertStatus(200)
            ->assertJson($expectRecommendedProducts);
    }

    /**
     * В ответе должны быть товары, которые добавлялись в проект вместе с товаром по которому происходит поиск
     */
    public function testGetBuyWithIt(): void
    {
        ProjectProduct::query()->truncate();

        $project = factory(Project::class)->create();
        $products = factory(Product::class, 5)->create();
        $productsCollection = new Collection();

        foreach ($products as $product) {
            $projectProduct = factory(ProjectProduct::class)->create(
                [
                    'project_id' => $project->id,
                    'product_id' => $product->id,
                ]
            );

            $productsCollection->push($projectProduct->product);
        }

        $anotherProject = factory(Project::class)->create();
        $anotherProducts = factory(Product::class, 3)->create();

        foreach ($anotherProducts as $anotherProduct) {
            factory(ProjectProduct::class)->create(
                [
                    'project_id' => $anotherProject->id,
                    'product_id' => $anotherProduct->id,
                ]
            );
        }

        $productForSearch = factory(Product::class)->create();
        factory(ProjectProduct::class)->create(
            [
                'project_id' => $project->id,
                'product_id' => $productForSearch->id,
            ]
        );

        $response = $this->json('GET', route('api.catalog.buy-with-it', ['id' => $productForSearch->id]));

        $expectProducts = ProductResource::collection($productsCollection)->resolve();

        $response->assertStatus(200)
            ->assertJson($expectProducts);
    }
}
