<?php

namespace Tests\Feature\Service\Setting;

use App\Models\Setting;
use Tests\TestCase;

/**
 * Class SettingTest
 * @package Tests\Feature\Service\Setting
 */
class SettingTest extends TestCase
{
    /**
     * Получить настройку по ключу
     */
    public function testGetByKey(): void
    {
        $setting = factory(Setting::class)->create([
            'key' => 'someKey',
            'value' => 'some value',
        ]);

        $value = \Setting::getValueByKey($setting['key']);

        $this->assertEquals($value, $setting['value']);
    }
}
