<?php

namespace Tests\Feature\Http\Controllers\Api\Banner;

use Tests\TestCase;
use App\Models\User;
use App\Models\Banner;

/**
 * Class GetBannersTest
 * @package Tests\Feature\Http\Controllers\Api\Banner
 */
class GetBannersTest extends TestCase
{
    /**
     * Получение баннеров для зарегистрированого юзера
     */
    public function testGetBannersForRegisteredUser(): void
    {
        $banners = factory(Banner::class, 5)->create();
        factory(Banner::class, 3)->create(['for_registered' => false]);
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->json('GET', route('api.banner.list'));

        $response
            ->assertStatus(200)
            ->assertJsonCount($banners->count());
    }

    /**
     * Получение баннеров для не зарегистрированого юзера
     */
    public function testGetBannersForNotRegisteredUser(): void
    {
        factory(Banner::class, 5)->create();
        $banners = factory(Banner::class, 3)->create(['for_registered' => false]);

        $response = $this->json('GET', route('api.banner.list'));

        $response
            ->assertStatus(200)
            ->assertJsonCount($banners->count());
    }
}
