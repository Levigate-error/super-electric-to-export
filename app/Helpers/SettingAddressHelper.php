<?php

namespace App\Helpers;

use App\Domain\Dictionaries\Setting\SettingDictionary;
use InvalidArgumentException;

/**
 * Class SettingAddressHelper
 *
 * Хелпер получения адресов получателей рассылки из настроек.
 *
 * @package App\Helpers
 */
class SettingAddressHelper
{
    /**
     * Ключи настроек хранящик почты получателей.
     *
     * @var array
     */
    protected static $availableKeys = [
        SettingDictionary::FEEDBACK_EMAILS,
        SettingDictionary::ANALOG_NOT_FOUND_EMAILS,
        SettingDictionary::LOYALTY_USER_EMAILS,
        SettingDictionary::LOYALTY_USER_PROPOSAL_EMAILS,
        SettingDictionary::IMPORT_NEWS_EMAILS,
        SettingDictionary::LOYALTY_RECEPEIT_EMAILS,
    ];

    /**
     * Получить почты аддресатов рассылки из настроек.
     *
     * @param string $key
     *
     * @return array
     */
    public static function get(string $key): array
    {
        if (in_array($key, self::$availableKeys, true) === false) {
            throw new InvalidArgumentException('Invalid key');
        }

        $settingValue = \Setting::getValueByKey($key);

        return array_filter(explode(',', $settingValue));
    }
}
