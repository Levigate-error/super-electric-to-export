<?php

namespace Tests\Feature\Http\Controllers\Api\City;

use Tests\TestCase;
use App\Models\City;

/**
 * Class SearchCityTest
 * @package Tests\Feature\Http\Controllers\Api\City
 */
class SearchCityTest extends TestCase
{
    public function testApiReturnsCorrectCity(): void
    {
        $city = factory(City::class)->create();

        $locale = get_current_local();
        $cityTitle = json_decode($city->title, true)[$locale];

        $response = $this->json('POST', route('api.city.search'), [
                'title' => $cityTitle,
            ]
        );

        $response
            ->assertStatus(200)
            ->assertJson([
                [
                    'id' => $city->id,
                    'title' => $cityTitle,
                ]
        ]);
    }

    public function testApiReturnsEmptyCity(): void
    {
        $response = $this->json('POST', route('api.city.search'), ['title' => 'non-existent city name']);

        $response->assertStatus(200)->assertJson([]);
    }
}
