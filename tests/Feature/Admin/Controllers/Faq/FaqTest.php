<?php

namespace Tests\Feature\Admin\Controllers\Faq;

use App\Models\Faq;
use Tests\TestCase;
use Tests\Feature\Admin\Controllers\Administratorable;

/**
 * Class FaqTest
 * @package Tests\Feature\Admin\Controllers\Faq
 */
class FaqTest extends TestCase
{
    use Administratorable;

    /**
     * @var mixed
     */
    protected $faq;

    public function setUp(): void
    {
        parent::setUp();

        $this->faq = factory(Faq::class)->create();

        $this->createAndLoginAdministrator();
    }

    /**
     * Список
     */
    public function testIndex(): void
    {
        $response = $this->get(route('admin.faq.index'));

        $response->assertStatus(200);
    }

    /**
     * Форма создания
     */
    public function testCreate(): void
    {
        $response = $this->json('get', route('admin.faq.create'));

        $response->assertStatus(200);
    }

    /**
     * Создание
     */
    public function testStore(): void
    {
        $params = [
            'published' => true,
            'question' => 'some question',
            'answer' => 'some answer',
        ];

        $this->json('post', route('admin.faq.store'), $params);

        $this->assertDatabaseHas('faqs', [
            'published' => $params['published'],
            'question' => $params['question'],
            'answer' => $params['answer'],
        ]);
    }

    /**
     * Форма редактирования
     */
    public function testEdit(): void
    {
        $response = $this->json('get', route('admin.faq.edit', ['faq' =>  $this->faq->id]));

        $response->assertStatus(200);
    }

    /**
     * Редактирование
     */
    public function testUpdate(): void
    {
        $params = [
            'published' => false,
            'question' => 'another question',
            'answer' => 'another answer',
        ];

        $this->json('put', route('admin.faq.update', ['faq' =>  $this->faq->id]), $params);

        $this->assertDatabaseHas('faqs', [
            'id' => $this->faq->id,
            'published' => $params['published'],
            'question' => $params['question'],
            'answer' => $params['answer'],
        ]);
    }

    /**
     * Удаление
     */
    public function testDestroy(): void
    {
        $this->json('delete', route('admin.faq.destroy', ['faq' => $this->faq->id]));

        $this->assertDatabaseMissing('faqs', [
            'id' => $this->faq->id,
        ]);
    }

    /**
     * Детальная страница
     */
    public function testShow(): void
    {
        $response = $this->json('get', route('admin.faq.show', ['faq' => $this->faq->id]));

        $response->assertStatus(200);
    }
}
