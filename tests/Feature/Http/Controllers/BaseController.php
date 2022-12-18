<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

/**
 * Class BaseController
 * @package Tests\Feature\Http\Controllers
 */
class BaseController extends TestCase
{
    /**
     * @param string $url
     */
    protected function assertOpenPage(string $url): void
    {
        $response = $this->json('get', $url);

        $response->assertStatus(200);
    }
}
