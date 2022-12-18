<?php

namespace Tests\Feature\Admin\Controllers\Product;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\ProductCategory;
use Tests\Feature\Admin\Controllers\Administratorable;

/**
 * Class ProductCategoryTest
 * @package Tests\Feature\Admin\Controllers\Product
 */
class ProductCategoryTest extends TestCase
{
    use Administratorable;

    /**
     * Редактирование категории
     */
    public function testEdit(): void
    {
        $user = $this->createAdministrator();

        $category = factory(ProductCategory::class)->create();

        Storage::fake('public');

        $image = UploadedFile::fake()->image('photo.png');

        $params = [
            'published' => false,
            'name' => 'some name',
            'image' => $image,
        ];

        $response = $this->actingAs($user, config('admin.auth.guard'))
            ->json('put', route('admin.catalog.product-categories.update', ['id' => $category->id]), $params);

        $category->refresh();

        $this->assertDatabaseHas('product_categories', [
            'id' => $category->id,
            'published' => $params['published'],
            'name' => setup_field_translate($params['name']),
            'image' => $category->image,
        ]);

        Storage::disk('public')->assertExists($category->image);
    }
}
