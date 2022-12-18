<?php

namespace Tests\Feature\Admin\Controllers\Video;

use Tests\TestCase;
use App\Models\Video\VideoCategory;
use Tests\Feature\Admin\Controllers\Administratorable;

/**
 * Class VideoCategoryTest
 * @package Tests\Feature\Admin\Controllers\Video
 */
class VideoCategoryTest extends TestCase
{
    use Administratorable;

    /**
     * @var  VideoCategory
     */
    private $videoCategory;

    public function setUp(): void
    {
        parent::setUp();

        $this->videoCategory = factory(VideoCategory::class)->create();

        $this->createAndLoginAdministrator();
    }

    /**
     * Список
     */
    public function testIndex(): void
    {
        $response = $this->json('get', route('admin.video.categories.index'));

        $response->assertStatus(200);
    }

    /**
     * Форма создания
     */
    public function testCreate(): void
    {
        $response = $this->json('get', route('admin.video.categories.create'));

        $response->assertStatus(200);
    }

    /**
     * Создание
     */
    public function testStore(): void
    {
        $params = [
            'published' => true,
            'title' => 'some title',
        ];

        $this->json('post', route('admin.video.categories.store'), $params);

        $this->assertDatabaseHas('video_categories', [
            'published' => $params['published'],
            'title' => setup_field_translate($params['title']),
        ]);
    }

    /**
     * Форма редактирования
     */
    public function testEdit(): void
    {
        $response = $this->json('get', route('admin.video.categories.edit', ['category' =>  $this->videoCategory->id]));

        $response->assertStatus(200);
    }

    /**
     * Редактирование
     */
    public function testUpdate(): void
    {
        $params = [
            'published' => false,
            'title' => 'some title',
        ];

        $this->json('put', route('admin.video.categories.update', ['category' =>  $this->videoCategory->id]), $params);

        $this->assertDatabaseHas('video_categories', [
            'id' => $this->videoCategory->id,
            'published' => $params['published'],
            'title' => setup_field_translate($params['title']),
        ]);
    }

    /**
     * Удаление
     */
    public function testDestroy(): void
    {
        $this->json('delete', route('admin.video.categories.destroy', ['category' => $this->videoCategory->id]));

        $this->assertDatabaseMissing('video_categories', [
            'id' => $this->videoCategory->id,
        ]);
    }

    /**
     * Детальная страница
     */
    public function testShow(): void
    {
        $response = $this->json('get', route('admin.video.categories.show', ['category' => $this->videoCategory->id]));

        $response->assertStatus(200);
    }
}
