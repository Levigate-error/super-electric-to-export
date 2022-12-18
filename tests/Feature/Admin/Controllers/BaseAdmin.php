<?php

namespace Tests\Feature\Admin\Controllers;

use Tests\TestCase;
use InvalidArgumentException;

/**
 * Class BaseAdmin
 * @package Tests\Feature\Admin\Controllers
 */
class BaseAdmin extends TestCase
{
    use Administratorable;

    /**
     * @var array
     */
    protected $crudUrls = [];

    public function setUp(): void
    {
        parent::setUp();

        $this->createAndLoginAdministrator();
    }

    /**
     * @param array $urls
     */
    protected function setCrudUrls(array $urls): void
    {
        $this->crudUrls = $urls;
    }

    /**
     * @param string $url
     */
    protected function assertOpenPage(string $url): void
    {
        $response = $this->json('get', $url);

        $response->assertStatus(200);
    }

    /**
     * @param string $urlTitle
     */
    protected function checkCrudUrlExist(string $urlTitle): void
    {
        if (isset($this->crudUrls[$urlTitle]) === false) {
            throw new InvalidArgumentException("Set url for $urlTitle page.");
        }
    }

    /**
     * Список
     */
    public function testIndex(): void
    {
        $this->checkCrudUrlExist('index');

        $this->assertOpenPage($this->crudUrls['index']);
    }

    /**
     * Форма создания
     */
    public function testCreate(): void
    {
        $this->checkCrudUrlExist('create');

        $this->assertOpenPage($this->crudUrls['create']);
    }

    /**
     * Форма редактирования
     */
    public function testEdit(): void
    {
        $this->checkCrudUrlExist('edit');

        $this->assertOpenPage($this->crudUrls['edit']);
    }

    /**
     * Детальная страница
     */
    public function testShow(): void
    {
        $this->checkCrudUrlExist('show');

        $this->assertOpenPage($this->crudUrls['show']);
    }
}
