<?php

namespace Tests\Feature\Admin\Controllers\News;

use App\Models\News;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Feature\Admin\Controllers\Administratorable;

/**
 * Class NewsTest
 * @package Tests\Feature\Admin\Controllers\News
 */
class NewsTest extends TestCase
{
    use Administratorable;

    /**
     * @var News
     */
    protected $news;

    public function setUp(): void
    {
        parent::setUp();

        $this->news = factory(News::class)->create();

        Storage::fake('public');

        $this->createAndLoginAdministrator();
    }

    /**
     * Список
     */
    public function testIndex(): void
    {
        $response = $this->json('get', route('admin.news.index'));

        $response->assertStatus(200);
    }

    /**
     * Форма создания
     */
    public function testCreate(): void
    {
        $response = $this->json('get', route('admin.news.create'));

        $response->assertStatus(200);
    }

    /**
     * Создание
     */
    public function testStore(): void
    {
        $params = factory(News::class)->make()->toArray();

        $this->json('post', route('admin.news.store'), $params);

        $this->assertDatabaseHas('news', [
            'title' => $params['title'],
            'description' => $params['description'],
            'short_description' => $params['short_description'],
        ]);
    }

    /**
     * Форма редактирования
     */
    public function testEdit(): void
    {
        $response = $this->json('get', route('admin.news.edit', ['news' =>  $this->news->id]));

        $response->assertStatus(200);
    }

    /**
     * Редактирование
     */
    public function testUpdate(): void
    {
        $image = UploadedFile::fake()->image('photo.png');

        $params = factory(News::class)->make()->toArray();
        $params['image'] = $image;

        $this->json('put', route('admin.news.update', ['news' =>  $this->news->id]), $params);

        $this->news->refresh();

        $this->assertDatabaseHas('news', [
            'id' => $this->news->id,
            'title' => $params['title'],
            'description' => $params['description'],
            'short_description' => $params['short_description'],
        ]);

        Storage::disk('public')->assertExists($this->news->image);
    }

    /**
     * Удаление
     */
    public function testDestroy(): void
    {
        $this->json('delete', route('admin.news.destroy', ['news' => $this->news->id]));

        $this->assertDatabaseMissing('news', [
            'id' => $this->news->id,
        ]);
    }

    /**
     * Детальная страница
     */
    public function testShow(): void
    {
        $response = $this->json('get', route('admin.news.show', ['news' => $this->news->id]));

        $response->assertStatus(200);
    }
}
