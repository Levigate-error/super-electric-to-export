<?php

namespace Tests\Feature\Http\Controllers\Api\News;

use App\Http\Resources\NewsResource;
use Tests\TestCase;
use App\Models\News;
use Tests\Feature\Http\Controllers\Authenticatable;

/**
 * Class NewsTest
 * @package Tests\Feature\Http\Controllers\Api\News
 */
class NewsTest extends TestCase
{
    use Authenticatable;

    /**
     * Корректная выдача списка
     */
    public function testGetNews(): void
    {
        $total = 7;
        $limit = 7;
        $page = 1;
        $lastPage = (int) round($total/$limit, 0);

        News::query()->truncate();
        $news = factory(News::class, $total)->create();

        $response = $this->json('POST', route('api.news.get-news'), [
            'limit' => $limit,
            'page' => $page,
        ]);

        $response
            ->assertStatus(200)
            ->assertJson([
                'total' => $news->count(),
                'lastPage' => $lastPage,
                'currentPage' => $page,
                'news' => NewsResource::collection($news->sortByDesc('id')->untype())->resolve(),
            ]);
    }

    /**
     * Детали новости
     */
    public function testDetails(): void
    {
        $news = factory(News::class)->create();

        $response = $this->json('GET', route('api.news.details', ['id' => $news->id]));

        $response
            ->assertStatus(200)
            ->assertJson(NewsResource::make($news)->resolve());
    }
}
