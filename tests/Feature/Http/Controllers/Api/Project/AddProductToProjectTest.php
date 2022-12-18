<?php

namespace Tests\Feature\Http\Controllers\Api\Project;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Project\Project;

/**
 * Class AddProductToProjectTest
 * @package Tests\Feature\Http\Controllers\Api\Project
 */
class AddProductToProjectTest extends TestCase
{
    /**
     * Проверка на добавление товара в проект
     */
    public function testAddProductToProject(): void
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create([
            'user_id' => $user->id,
        ]);
        $product = factory(Product::class)->create();

        $amount = rand(1, 10);

        $response = $this->actingAs($user)
            ->json('POST', route('api.project.product-add'), [
                    'product' => $product->id,
                    'projects' => [
                        [
                            'amount' => $amount,
                            'project' => $project->id,
                        ],
                    ],
                ]
            );

        $response->assertStatus(200)
            ->assertJson(['result' => true]);

        $this->assertDatabaseHas('project_products', [
            'product_id' => $product->id,
            'project_id' => $project->id,
            'amount' => $amount,
        ]);

        /**
         * Проверям что ранг товара инкрементировался
         */
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'rank' => $product->rank + 1,
        ]);
    }
}
