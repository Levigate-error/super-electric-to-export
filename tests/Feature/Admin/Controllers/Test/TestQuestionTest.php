<?php

namespace Tests\Feature\Admin\Controllers\Test;

use App\Models\Test\TestQuestion;
use App\Models\Test\Test;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\Feature\Admin\Controllers\BaseAdmin;

/**
 * Class TestQuestionTest
 * @package Tests\Feature\Admin\Controllers\Test
 */
class TestQuestionTest extends BaseAdmin
{
    /**
     * @var mixed
     */
    private $testQuestion;

    public function setUp(): void
    {
        parent::setUp();

        $this->testQuestion = factory(TestQuestion::class)->create();

        $this->setCrudUrls([
            'index' => route('admin.test.question.index'),
            'create' => route('admin.test.question.create'),
            'edit' => route('admin.test.question.edit', ['question' =>  $this->testQuestion->id]),
            'show' => route('admin.test.question.show', ['question' => $this->testQuestion->id]),
        ]);

        Storage::fake('public');
    }

    /**
     * Создание
     */
    public function testStore(): void
    {
        $test = factory(Test::class)->create();
        $testQuestion = factory(TestQuestion::class)->make([
            'test_id' => $test->id,
            'image' => UploadedFile::fake()->image('photo.png'),
        ])->toArray();

        $response = $this->json('post', route('admin.test.question.store', ['test_id' => $testQuestion['test_id']]), $testQuestion);

        $response->assertStatus(302);

        $this->assertDatabaseHas('test_questions', [
            'question' => $testQuestion['question'],
            'video' => $testQuestion['video'],
            'test_id' => $testQuestion['test_id'],
        ]);

        $createdTestQuestion = TestQuestion::query()->where([
            'question' => $testQuestion['question'],
            'video' => $testQuestion['video'],
            'test_id' => $testQuestion['test_id'],
        ])->first();

        Storage::disk('public')->assertExists($createdTestQuestion->image);
    }

    /**
     * Редактирование
     */
    public function testUpdate(): void
    {
        $testQuestion = factory(TestQuestion::class)->make([
            'image' => UploadedFile::fake()->image('photo.png'),
        ])->toArray();

        $response = $this->json('put', route('admin.test.question.update', ['question' =>  $this->testQuestion->id]), $testQuestion);

        $response->assertStatus(302);

        $this->assertDatabaseHas('test_questions', [
            'id' => $this->testQuestion->id,
            'question' => $testQuestion['question'],
            'video' => $testQuestion['video'],
            'test_id' => $testQuestion['test_id'],
        ]);

        $this->testQuestion->refresh();

        Storage::disk('public')->assertExists($this->testQuestion->image);
    }

    /**
     * Удаление
     */
    public function testDestroy(): void
    {
        $response = $this->json('delete', route('admin.test.question.destroy', ['question' => $this->testQuestion->id]));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('test_questions', [
            'id' => $this->testQuestion->id,
        ]);
    }
}
