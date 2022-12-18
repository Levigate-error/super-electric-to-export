<?php

namespace App\Mail;

use App\Domain\Dictionaries\Setting\SettingDictionary;
use App\Helpers\SettingAddressHelper;

/**
 * Class ImportNews
 *
 * @package App\Mail
 */
class ImportNews extends BaseMail
{
    /**
     * @var array
     */
    public $params;

    /**
     * ImportNews constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $addressees = $this->getAddresses();

        $this->to($addressees);
        $this->subject(__('news.import.email-subject', ['url' => 'https://legrand.ru']));

        $this->params = $params;
        $this->title = __('news.import.email-title', ['id' => 'ID', 'title' => 'Название', 'source' => 'Источник']);
        $text = '';
        foreach ($params as $param) {
            $text .= $param . PHP_EOL;
        }
        $this->text = __('news.import.email-text', ['text' => $text]);
    }

    /**
     * {@inheritDoc}
     */
    protected function getExtraAddressees(): array
    {
        return SettingAddressHelper::get(SettingDictionary::IMPORT_NEWS_EMAILS);
    }
}
