<?php

namespace Tests\Feature\Admin\Controllers\Test;

use Tests\TestCase;
use App\Models\Test\Test;
use Tests\Feature\Admin\Controllers\Administratorable;

/**
 * Class TestTest
 * @package Tests\Feature\Admin\Controllers\Test
 */
class TestTest extends TestCase
{
    use Administratorable;

    /**
     * @var mixed
     */
    private $test;

    public function setUp(): void
    {
        parent::setUp();

        $this->test = factory(Test::class)->create();

        $this->createAndLoginAdministrator();
    }

    /**
     * Список
     */
    public function testIndex(): void
    {
        $response = $this->json('get', route('admin.test.main.index'));

        $response->assertStatus(200);
    }

    /**
     * Форма создания
     */
    public function testCreate(): void
    {
        $response = $this->json('get', route('admin.test.main.create'));

        $response->assertStatus(200);
    }

    /**
     * Создание
     */
    public function testStore(): void
    {
        $params = [
            'title' => 'some title',
            'description' => 'some description',
        ];

        $response = $this->json('post', route('admin.test.main.store'), $params);

        $response->assertStatus(302);

        $this->assertDatabaseHas('tests', [
            'title' => $params['title'],
            'description' => $params['description'],
        ]);
    }

    /**
     * Форма редактирования
     */
    public function testEdit(): void
    {
        $response = $this->json('get', route('admin.test.main.edit', ['main' =>  $this->test->id]));

        $response->assertStatus(200);
    }

    /**
     * Редактирование
     */
    public function testUpdate(): void
    {
        $params = [
            'title' => 'another title',
            'description' => 'another description',
        ];

        $response = $this->json('put', route('admin.test.main.update', ['main' =>  $this->test->id]), $params);

        $response->assertStatus(302);

        $this->assertDatabaseHas('tests', [
            'id' => $this->test->id,
            'title' => $params['title'],
            'description' => $params['description'],
        ]);
    }

    /**
     * Удаление
     */
    public function testDestroy(): void
    {
        $response = $this->json('delete', route('admin.test.main.destroy', ['main' => $this->test->id]));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('tests', [
            'id' => $this->test->id,
        ]);
    }

    /**
     * Детальная страница
     */
    public function testShow(): void
    {
        $response = $this->json('get', route('admin.test.main.show', ['main' => $this->test->id]));

        $response->assertStatus(200);
    }
}
