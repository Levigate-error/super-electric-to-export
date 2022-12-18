<?php

namespace App\Mail;

use App\Domain\Dictionaries\Setting\SettingDictionary;
use App\Helpers\SettingAddressHelper;

/**
 * Class AnalogueNotFound
 *
 * @package App\Mail
 */
class AnalogueNotFound extends BaseMail
{
    /**
     * @var array
     */
    public $params;

    /**
     * AnalogueNotFound constructor.
     *
     * @param array $params
     */
    public function __construct(array $params)
    {
        $addressees = $this->getAddresses();

        $this->to($addressees);
        $this->subject(__('analog.not-found.email-subject', ['url' => $this->getSiteHost()]));

        $this->params = $params;
        $this->title = __('analog.not-found.email-title');
        $this->text = __('analog.not-found.vendor-code', ['vendor_code' => $params['vendor_code']]);
    }

    /**
     * {@inheritDoc}
     */
    protected function getExtraAddressees(): array
    {
        return SettingAddressHelper::get(SettingDictionary::ANALOG_NOT_FOUND_EMAILS);
    }
}
