<?php

namespace App\Admin\Helpers;

use App\Domain\Dictionaries\Setting\SettingDictionary;
use App\Models\Setting;

/**
 * Class SettingKeySelectorHelper
 *
 * Хелпер позволяет вычислить содержимое селектора для дропдауна.
 *
 * @package App\Admin\Helpers
 */
class SettingKeySelectorHelper
{
    /**
     * Получить данные для селектора.
     *
     * @param array $ignoredIds
     *
     * @return array
     */
    public static function getDataForSelector(array $ignoredIds = []): array
    {
        $existSettingKeys = Setting::query()
            ->whereNotIn('id', $ignoredIds)
            ->select('key')
            ->pluck('key')
            ->toArray();

        return array_diff_key(SettingDictionary::getToHumanResource(), array_flip($existSettingKeys));
    }
}
