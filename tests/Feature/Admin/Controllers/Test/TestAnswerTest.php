<?php

namespace Tests\Feature\Admin\Controllers\Test;

use App\Models\Test\TestQuestion;
use App\Models\Test\TestAnswer;
use Tests\Feature\Admin\Controllers\BaseAdmin;

/**
 * Class TestAnswerTest
 * @package Tests\Feature\Admin\Controllers\Test
 */
class TestAnswerTest extends BaseAdmin
{
    /**
     * @var mixed
     */
    private $testAnswer;

    public function setUp(): void
    {
        parent::setUp();

        $this->testAnswer = factory(TestAnswer::class)->create();

        $this->setCrudUrls([
            'index' => route('admin.test.answer.index'),
            'create' => route('admin.test.answer.create'),
            'edit' => route('admin.test.answer.edit', ['question' =>  $this->testAnswer->id]),
            'show' => route('admin.test.answer.show', ['question' => $this->testAnswer->id]),
        ]);
    }

    /**
     * Создание
     */
    public function testStore(): void
    {
        $testQuestion = factory(TestQuestion::class)->create();
        $testAnswer = factory(TestAnswer::class)->make([
            'test_question_id' => $testQuestion->id,
        ])->toArray();

        $response = $this->json(
            'post',
            route('admin.test.answer.store', ['test_question_id' => $testAnswer['test_question_id']]),
            $testAnswer
        );

        $response->assertStatus(302);

        $this->assertDatabaseHas('test_answers', [
            'test_question_id' => $testAnswer['test_question_id'],
            'answer' => $testAnswer['answer'],
            'is_correct' => $testAnswer['is_correct'],
            'description' => $testAnswer['description'],
            'points' => $testAnswer['points'],
        ]);
    }

    /**
     * Редактирование
     */
    public function testUpdate(): void
    {
        $testAnswer = factory(TestAnswer::class)->make()->toArray();

        $response = $this->json('put', route('admin.test.answer.update', ['answer' =>  $this->testAnswer->id]), $testAnswer);

        $response->assertStatus(302);

        $this->assertDatabaseHas('test_answers', [
            'id' => $this->testAnswer->id,
            'test_question_id' => $testAnswer['test_question_id'],
            'answer' => $testAnswer['answer'],
            'is_correct' => $testAnswer['is_correct'],
            'description' => $testAnswer['description'],
            'points' => $testAnswer['points'],
        ]);
    }

    /**
     * Удаление
     */
    public function testDestroy(): void
    {
        $response = $this->json('delete', route('admin.test.answer.destroy', ['answer' => $this->testAnswer->id]));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('test_answers', [
            'id' => $this->testAnswer->id,
        ]);
    }
}
