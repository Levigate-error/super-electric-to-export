<?php

namespace Tests\Feature\Admin\Controllers\Feedback;

use App\Models\Feedback;
use Tests\TestCase;
use Tests\Feature\Admin\Controllers\Administratorable;

/**
 * Class FeedbackTest
 * @package Tests\Feature\Admin\Controllers\Feedback
 */
class FeedbackTest extends TestCase
{
    use Administratorable;

    /**
     * @var mixed
     */
    protected $faq;

    public function setUp(): void
    {
        parent::setUp();

        $this->faq = factory(Feedback::class)->create();

        $this->createAndLoginAdministrator();
    }

    /**
     * Список
     */
    public function testIndex(): void
    {
        $response = $this->json('get', route('admin.feedback.index'));

        $response->assertStatus(200);
    }

    /**
     * Форма создания
     */
    public function testCreate(): void
    {
        $response = $this->json('get', route('admin.feedback.create'));

        $response->assertStatus(200);
    }

    /**
     * Создание
     */
    public function testStore(): void
    {
        $feedback = factory(Feedback::class)->make()->toArray();

        $this->json('post', route('admin.feedback.store'), $feedback);

        $this->assertDatabaseHas('feedback', [
            'email' => $feedback['email'],
            'name' => $feedback['name'],
            'text' => $feedback['text'],
        ]);
    }

    /**
     * Форма редактирования
     */
    public function testEdit(): void
    {
        $response = $this->json('get', route('admin.feedback.edit', ['faq' =>  $this->faq->id]));

        $response->assertStatus(200);
    }

    /**
     * Редактирование
     */
    public function testUpdate(): void
    {
        $params = [
            'name' => 'another name',
            'text' => 'another text',
        ];

        $this->json('put', route('admin.feedback.update', ['feedback' =>  $this->faq->id]), $params);

        $this->assertDatabaseHas('feedback', [
            'id' => $this->faq->id,
            'name' => $params['name'],
            'text' => $params['text'],
        ]);
    }

    /**
     * Удаление
     */
    public function testDestroy(): void
    {
        $this->json('delete', route('admin.feedback.destroy', ['feedback' => $this->faq->id]));

        $this->assertDatabaseMissing('feedback', [
            'id' => $this->faq->id,
        ]);
    }

    /**
     * Детальная страница
     */
    public function testShow(): void
    {
        $response = $this->json('get', route('admin.feedback.show', ['feedback' => $this->faq->id]));

        $response->assertStatus(200);
    }
}
