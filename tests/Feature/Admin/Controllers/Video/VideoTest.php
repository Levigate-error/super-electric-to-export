<?php

namespace Tests\Feature\Admin\Controllers\Video;

use App\Models\Video\VideoCategory;
use Tests\TestCase;
use App\Models\Video\Video;
use Tests\Feature\Admin\Controllers\Administratorable;

/**
 * Class VideoTest
 * @package Tests\Feature\Admin\Controllers\Video
 */
class VideoTest extends TestCase
{
    use Administratorable;

    /**
     * @var mixed
     */
    private $video;

    public function setUp(): void
    {
        parent::setUp();

        $this->video = factory(Video::class)->create();

        $this->createAndLoginAdministrator();
    }

    /**
     * Список
     */
    public function testIndex(): void
    {
        $response = $this->json('get', route('admin.video.videos.index'));

        $response->assertStatus(200);
    }

    /**
     * Форма создания
     */
    public function testCreate(): void
    {
        $response = $this->json('get', route('admin.video.videos.create'));

        $response->assertStatus(200);
    }

    /**
     * Создание
     */
    public function testStore(): void
    {
        $videoCategory = factory(VideoCategory::class)->create();

        $params = [
            'published' => true,
            'title' => 'some title',
            'video' => 'https://www.youtube.com/embed/2aF53cNEynM',
            'video_category_id' => $videoCategory->id,
        ];

        $this->json('post', route('admin.video.videos.store'), $params);

        $this->assertDatabaseHas('videos', [
            'published' => $params['published'],
            'title' => setup_field_translate($params['title']),
            'video' => $params['video'],
            'video_category_id' => $videoCategory->id,
        ]);
    }

    /**
     * Форма редактирования
     */
    public function testEdit(): void
    {
        $response = $this->json('get', route('admin.video.videos.edit', ['video' =>  $this->video->id]));

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
            'video' => 'https://www.youtube.com/embed/23fg4gg',
        ];

        $this->json('put', route('admin.video.videos.update', ['video' =>  $this->video->id]), $params);

        $this->assertDatabaseHas('videos', [
            'id' => $this->video->id,
            'published' => $params['published'],
            'title' => setup_field_translate($params['title']),
            'video' => $params['video'],
        ]);
    }

    /**
     * Удаление
     */
    public function testDestroy(): void
    {
        $this->json('delete', route('admin.video.videos.destroy', ['video' => $this->video->id]));

        $this->assertDatabaseMissing('videos', [
            'id' => $this->video->id,
        ]);
    }

    /**
     * Детальная страница
     */
    public function testShow(): void
    {
        $response = $this->json('get', route('admin.video.videos.show', ['video' => $this->video->id]));

        $response->assertStatus(200);
    }
}
