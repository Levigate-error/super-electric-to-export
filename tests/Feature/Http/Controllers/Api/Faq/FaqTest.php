<?php

namespace Tests\Feature\Http\Controllers\Api\Faq;

use App\Http\Resources\FaqResource;
use Tests\TestCase;
use App\Models\Faq;
use Tests\Feature\Http\Controllers\Authenticatable;

/**
 * Class FaqTest
 * @package Tests\Feature\Http\Controllers\Api\Faq
 */
class FaqTest extends TestCase
{
    use Authenticatable;

    /**
     * Корректная выдача
     */
    public function testGetFaqsList(): void
    {
        $total = 7;
        $limit = 7;
        $page = 1;
        $lastPage = round($total/$limit, 0);

        Faq::query()->truncate();
        $faqs = factory(Faq::class, $total)->create();

        $response = $this->json('POST', route('api.faq.get-faqs'), [
            'limit' => $limit,
            'page' => $page,
        ]);

        $response->assertJson([
                'total' => $faqs->count(),
                'lastPage' => $lastPage,
                'currentPage' => $page,
                'faqs' => FaqResource::collection($faqs->sortByDesc('id')->untype())->resolve(),
            ]);
    }
}
