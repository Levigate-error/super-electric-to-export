<?php

namespace App\Domain\Dictionaries\Setting;

use App\Domain\Dictionaries\BaseDictionary;

/**
 * Class SettingDictionary
 *
 * Словарь описывает "Уникальные ключи" для раздела "Настройки".
 *
 * @package App\Domain\Dictionaries\Setting
 */
class SettingDictionary extends BaseDictionary
{
    public const FEEDBACK_EMAILS              = 'feedback_emails';
    public const ANALOG_NOT_FOUND_EMAILS      = 'analog_not_found_emails';
    public const LOYALTY_USER_EMAILS          = 'loyalty_user_emails';
    public const LOYALTY_USER_PROPOSAL_EMAILS = 'loyalty_user_proposal_emails';
    public const IMPORT_NEWS_EMAILS           = 'import_news_emails';
    public const LOYALTY_RECEPEIT_EMAILS      = 'loyalty_recepeit_emails';

    /**
     * @inheritDoc
     */
    public static function getToHumanResource(): array
    {
        return [
            self::FEEDBACK_EMAILS              => __('settings.feedback_emails'),
            self::ANALOG_NOT_FOUND_EMAILS      => __('settings.analog_not_found_emails'),
            self::LOYALTY_USER_EMAILS          => __('settings.loyalty_user_emails'),
            self::LOYALTY_USER_PROPOSAL_EMAILS => __('settings.loyalty_user_proposal_emails'),
            self::IMPORT_NEWS_EMAILS           => __('settings.import_news_emails'),
            self::LOYALTY_RECEPEIT_EMAILS      => __('settings.loyalty_recepeit_emails'),
        ];
    }
}
