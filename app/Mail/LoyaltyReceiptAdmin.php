<?php

namespace App\Mail;

use App\Domain\Dictionaries\Setting\SettingDictionary;
use App\Helpers\SettingAddressHelper;
use App\Models\Loyalty\LoyaltyReceipt;

/**
 * Class LoyaltyReceiptAdmin
 * @package App\Mail
 */
class LoyaltyReceiptAdmin extends BaseMail
{
    /**
     * @var array
     */
    public $params;

    /**
     * @param LoyaltyReceipt $loyalityReceipt
     */
    public function __construct(LoyaltyReceipt $loyalityReceipt)
    {
        $addressees = $this->getAddresses();

        $this->to($addressees);
        $this->subject(__('loyalty-program.email.user-loyalty-receipt.subject', ['url' => $this->getSiteHost()]));

        $this->title = __('loyalty-program.email.user-loyalty-receipt.title');
        $this->text = __('loyalty-program.email.user-loyalty-receipt.text');
        $this->buttonUrl = route('admin.loyalty-program.receipts.edit', ['id' => $loyalityReceipt->id]);
        $this->buttonTitle = __('loyalty-program.email.user-loyalty-receipt.button-title');
    }

    /**
     * {@inheritDoc}
     */
    protected function getExtraAddressees(): array
    {
        return SettingAddressHelper::get(SettingDictionary::LOYALTY_RECEPEIT_EMAILS);
    }
}
