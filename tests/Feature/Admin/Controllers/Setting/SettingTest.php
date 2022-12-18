<?php

namespace Tests\Feature\Admin\Controllers\Setting;

use App\Domain\Dictionaries\Setting\SettingDictionary;
use App\Models\Setting;
use Tests\TestCase;
use Tests\Feature\Admin\Controllers\Administratorable;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SettingTest
 * @package Tests\Feature\Admin\Controllers\Setting
 */
class SettingTest extends TestCase
{
    use Administratorable;

    /**
     * @var Setting
     */
    protected $setting;

    public function setUp(): void
    {
        parent::setUp();

        $this->setting = factory(Setting::class)->create([
            'key' => SettingDictionary::FEEDBACK_EMAILS
        ]);

        $this->createAndLoginAdministrator();
    }

    /**
     * Список
     */
    public function testIndex(): void
    {
        $response = $this->json('get', route('admin.setting.index'));

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Форма создания
     */
    public function testCreate(): void
    {
        $response = $this->json('get', route('admin.setting.create'));

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Создание
     */
    public function testStore(): void
    {
        $setting = factory(Setting::class)->make()->toArray();

        $this->json('post', route('admin.setting.store'), $setting);

        $this->assertDatabaseHas('settings', [
            'key' => $setting['key'],
            'value' => $setting['value'],
        ]);
    }

    /**
     * Форма редактирования
     */
    public function testEdit(): void
    {
        $response = $this->json('get', route('admin.setting.edit', ['setting' =>  $this->setting->id]));

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Редактирование
     */
    public function testUpdate(): void
    {
        $params = [
            'key' => 'another key',
            'value' => 'another value',
        ];

        $this->json('put', route('admin.setting.update', ['setting' =>  $this->setting->id]), $params);

        $this->assertDatabaseHas('settings', [
            'id' => $this->setting->id,
            'key' => $params['key'],
            'value' => $params['value'],
        ]);
    }

    /**
     * Удаление
     */
    public function testDestroy(): void
    {
        $this->json('delete', route('admin.setting.destroy', ['setting' => $this->setting->id]));

        $this->assertDatabaseMissing('settings', [
            'id' => $this->setting->id,
        ]);
    }

    /**
     * Детальная страница
     */
    public function testShow(): void
    {
        $response = $this->get(route('admin.setting.show', ['setting' => $this->setting->id]));

        $response->assertStatus(Response::HTTP_OK);
    }
}
