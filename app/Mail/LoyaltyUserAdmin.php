<?php

namespace App\Mail;

use App\Domain\Dictionaries\Setting\SettingDictionary;
use App\Helpers\SettingAddressHelper;
use App\Models\Loyalty\LoyaltyUser as LoyaltyUserModel;

/**
 * Class LoyaltyUserAdmin
 * @package App\Mail
 */
class LoyaltyUserAdmin extends BaseMail
{
    /**
     * @var array
     */
    public $params;

    /**
     * LoyaltyUser constructor.
     * @param LoyaltyUserModel $loyaltyUser
     */
    public function __construct(LoyaltyUserModel $loyaltyUser)
    {
        $addressees = $this->getAddresses();

        $this->to($addressees);
        $this->subject(__('loyalty-program.email.user-loyalty-admin.subject'));

        $this->params = $loyaltyUser->toArray();
        $this->title = __('loyalty-program.email.user-loyalty-admin.title');

        $user = $loyaltyUser->user;
        $fullName = $user->first_name . ' ' . $user->last_name;
        $this->text = __('loyalty-program.email.user-loyalty-admin.text', ['fullName' => $fullName]);

        $this->buttonUrl = route('admin.loyalty-program.loyalties.show', ['id' => $loyaltyUser->loyalty_id]);
        $this->buttonTitle = __('loyalty-program.email.user-loyalty-admin.button-title');
    }

    /**
     * {@inheritDoc}
     */
    protected function getExtraAddressees(): array
    {
        return SettingAddressHelper::get(SettingDictionary::LOYALTY_USER_EMAILS);
    }
}
