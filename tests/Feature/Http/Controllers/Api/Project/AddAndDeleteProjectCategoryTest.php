<?php

namespace Tests\Feature\Http\Controllers\Api\Project;

use Tests\TestCase;
use App\Models\User;
use App\Models\ProductCategory;
use App\Models\Project\Project;

/**
 * Class AddAndDeleteProjectCategoryTest
 * @package Tests\Feature\Http\Controllers\Api\Project
 */
class AddAndDeleteProjectCategoryTest extends TestCase
{
    /**
     * Проверка на добавление категории в проект
     */
    public function testAddCategoryToProject(): void
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create([
            'user_id' => $user->id,
        ]);

        $category = ProductCategory::inRandomOrder()->first();
        if (empty($category) === true) {
            $category = factory(ProductCategory::class)->create();
        }

        $this->addCategoryToProject($user, $project, $category);
    }

    /**
     * Проверка на удаление категории из проекта
     */
    public function testDeleteCategoryFromProject(): void
    {
        $user = factory(User::class)->create();
        $project = factory(Project::class)->create([
            'user_id' => $user->id,
        ]);

        $category = ProductCategory::inRandomOrder()->first();
        if (empty($category) === true) {
            $category = factory(ProductCategory::class)->create();
        }

        $this->addCategoryToProject($user, $project, $category);

        $this->deleteCategoryFromProject($user, $project, $category);
    }

    /**
     * Добавление категории в проект и проверка корректности добавления
     *
     * @param User $user
     * @param Project $project
     * @param ProductCategory $category
     */
    private function addCategoryToProject(User $user, Project $project, ProductCategory $category): void
    {
        $response = $this->actingAs($user)
            ->json('POST', route('api.project.category.add', ['id' => $project->id]), [
                    'product_category' => $category->id,
                ]
            );

        $response->assertStatus(200)
            ->assertJson([
                [
                    'id' => $category->id,
                    'name' => translate_field($category->name),
                ],
            ]);

        $this->assertDatabaseHas('project_product_categories', [
            'project_id' => $project->id,
            'product_category_id' => $category->id,
        ]);
    }

    /**
     * Удаление категории из проекта и проверка корректности удаления
     *
     * @param User $user
     * @param Project $project
     * @param ProductCategory $category
     */
    private function deleteCategoryFromProject(User $user, Project $project, ProductCategory $category): void
    {
        $response = $this->actingAs($user)
            ->json('DELETE', route('api.project.project-category.delete', [
                'project_id' => $project->id,
                'category_id' => $category->id,
            ]));

        $response->assertStatus(200)
            ->assertJson([]);

        $this->assertDatabaseMissing('project_product_categories', [
            'project_id' => $project->id,
            'product_category_id' => $category->id,
        ]);
    }
}
