<?php

namespace Tests\Feature\Http\Controllers\Api;

use Tests\TestCase;
use App\Models\Video\VideoCategory;
use App\Models\Video\Video;
use Tests\Feature\Http\Controllers\Authenticatable;

/**
 * Class VideoTest
 * @package Tests\Feature\Http\Controllers\Api
 */
class VideoTest extends TestCase
{
    use Authenticatable;

    /**
     * Список опубликованных категорий видео
     */
    public function testGetVideoCategoryList(): void
    {
        $this->createAndLoginUser();

        $publishedVideoCategories = factory(VideoCategory::class, 3)->create();
        factory(VideoCategory::class, 2)->create([
            'published' => false
        ]);

        $response = $this->json('GET', route('api.video.get-category-list'));

        $response->assertStatus(200)
            ->assertJsonCount($publishedVideoCategories->count());
    }

    /**
     * Поиск видео
     */
    public function testSearchVideo(): void
    {
        $this->createAndLoginUser();

        $this->checkAllVideo();
        $this->checkVideoByCategory();
        $this->checkVideoPagination();
    }

    /**
     * Корректная пагинация
     */
    protected function checkVideoPagination(): void
    {
        $total = 20;
        $limit = 7;
        $page = 2;
        $lastPage = round($total/$limit, 0);

        $publishedVideoCategory = factory(VideoCategory::class)->create();
        $publishedVideo = factory(Video::class, $total)->create([
            'video_category_id' => $publishedVideoCategory->id,
        ]);

        $response = $this->json('POST', route('api.video.search-video'), [
            'limit' => $limit,
            'page' => $page,
            'video_category_id' => $publishedVideoCategory->id,
        ]);

        $response->assertJsonFragment([
                'total' => $publishedVideo->count(),
                'lastPage' => $lastPage,
                'currentPage' => $page,
            ])
            ->assertJsonCount($limit, 'videos');
    }

    /**
     * Корректный поиск по категории видео
     */
    protected function checkVideoByCategory(): void
    {
        $publishedVideoCategoryWithProducts = factory(VideoCategory::class)->create();
        $publishedVideoCategoryWithoutProducts = factory(VideoCategory::class)->create();
        $publishedVideo = factory(Video::class, 5)->create([
            'video_category_id' => $publishedVideoCategoryWithProducts->id,
        ]);
        $notPublishedVideoCategoryWithProducts = factory(VideoCategory::class)->create([
            'published' => false
        ]);
        $notPublishedVideo = factory(Video::class, 5)->create([
            'video_category_id' => $notPublishedVideoCategoryWithProducts->id,
        ]);

        $responseWithProducts = $this->json('POST', route('api.video.search-video'), [
            'video_category_id' => $publishedVideoCategoryWithProducts->id,
        ]);
        $responseWithProducts->assertJsonCount($publishedVideo->count(), 'videos');

        $responseWithoutProducts = $this->json('POST', route('api.video.search-video'), [
            'video_category_id' => $publishedVideoCategoryWithoutProducts->id,
        ]);
        $responseWithoutProducts->assertJsonCount(0, 'videos');

        $responseNotPublished = $this->json('POST', route('api.video.search-video'), [
            'video_category_id' => $notPublishedVideoCategoryWithProducts->id,
        ]);
        $responseNotPublished->assertJsonCount(0, 'videos');
    }

    /**
     * Корректная структуру и кол-ство опубликованных видео
     */
    protected function checkAllVideo(): void
    {
        $publishedVideoCategory = factory(VideoCategory::class)->create();
        $publishedVideo = factory(Video::class, 10)->create([
            'video_category_id' => $publishedVideoCategory->id
        ]);
        factory(Video::class, 2)->create(['published' => false]);

        $response = $this->json('POST', route('api.video.search-video'));

        $response->assertStatus(200)
            ->assertJsonFragment([
                'total' => $publishedVideo->count(),
                'lastPage' => 1,
                'currentPage' => 1,
            ])
            ->assertJsonStructure(['total', 'lastPage', 'currentPage', 'videos'])
            ->assertJsonCount($publishedVideo->count(), 'videos');
    }
}
