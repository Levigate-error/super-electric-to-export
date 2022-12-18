<?php

namespace Tests\Feature\Admin\Controllers\Product;

use App\Models\Product;
use Tests\TestCase;
use Tests\Feature\Admin\Controllers\Administratorable;

/**
 * Class ProductTest
 * @package Tests\Feature\Admin\Controllers\Product
 */
class ProductTest extends TestCase
{
    use Administratorable;

    /**
     * @var Product
     */
    private $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->product = factory(Product::class)->create();

        $this->createAndLoginAdministrator();
    }

    /**
     * Список
     */
    public function testIndex(): void
    {
        $response = $this->json('get', route('admin.catalog.products.list'));

        $response->assertStatus(200);
    }

    public function testEdit(): void
    {
        $params = [
            'is_recommended' => false,
            'rank' => 5,
        ];

        $response = $this->json('put', route('admin.catalog.products.update', ['id' => $this->product->id]), $params);

        $response->assertStatus(302);

        $this->assertDatabaseHas('products', [
            'id' => $this->product->id,
            'is_recommended' => $params['is_recommended'],
            'rank' => $params['rank'],
        ]);
    }
}
