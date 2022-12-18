<?php

namespace Tests\Feature\Admin\Controllers\Test;

use Tests\TestCase;
use App\Models\Test\TestResult;
use App\Models\Test\Test;
use Tests\Feature\Admin\Controllers\Administratorable;

/**
 * Class TestResultTest
 * @package Tests\Feature\Admin\Controllers\Test
 */
class TestResultTest extends TestCase
{
    use Administratorable;

    /**
     * @var mixed
     */
    private $testResult;

    public function setUp(): void
    {
        parent::setUp();

        $this->testResult = factory(TestResult::class)->create();

        $this->createAndLoginAdministrator();
    }

    /**
     * Список
     */
    public function testIndex(): void
    {
        $response = $this->json('get', route('admin.test.result.index'));

        $response->assertStatus(200);
    }

    /**
     * Форма создания
     */
    public function testCreate(): void
    {
        $response = $this->json('get', route('admin.test.result.create'));

        $response->assertStatus(200);
    }

    /**
     * Создание
     */
    public function testStore(): void
    {
        $test = factory(Test::class)->create();
        $params = [
            'title' => 'some title',
            'description' => 'some description',
            'percent_from' => 1,
            'percent_to' => 15,
            'points' => 5,
        ];

        $response = $this->json('post', route('admin.test.result.store', ['test_id' => $test->id]), $params);

        $response->assertStatus(302);

        $this->assertDatabaseHas('test_results', [
            'title' => $params['title'],
            'description' => $params['description'],
            'percent_from' => $params['percent_from'],
            'percent_to' => $params['percent_to'],
            'points' => $params['points'],
        ]);
    }

    /**
     * Форма редактирования
     */
    public function testEdit(): void
    {
        $response = $this->json('get', route('admin.test.result.edit', ['result' =>  $this->testResult->id]));

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
            'percent_from' => 20,
            'percent_to' => 25,
            'points' => 10,
            'test_id' => $this->testResult->test_id,
        ];

        $response = $this->json('put', route('admin.test.result.update', ['result' =>  $this->testResult->id]), $params);

        $response->assertStatus(302);

        $this->assertDatabaseHas('test_results', [
            'id' => $this->testResult->id,
            'title' => $params['title'],
            'description' => $params['description'],
            'percent_from' => $params['percent_from'],
            'percent_to' => $params['percent_to'],
            'points' => $params['points'],
            'test_id' => $this->testResult->test_id,
        ]);
    }

    /**
     * Удаление
     */
    public function testDestroy(): void
    {
        $response = $this->json('delete', route('admin.test.result.destroy', ['result' => $this->testResult->id]));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('test_results', [
            'id' => $this->testResult->id,
        ]);
    }

    /**
     * Детальная страница
     */
    public function testShow(): void
    {
        $response = $this->json('get', route('admin.test.result.show', ['result' => $this->testResult->id]));

        $response->assertStatus(200);
    }
}
