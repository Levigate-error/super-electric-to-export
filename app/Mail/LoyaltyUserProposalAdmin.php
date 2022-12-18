<?php

namespace App\Mail;

use App\Domain\Dictionaries\Setting\SettingDictionary;
use App\Helpers\SettingAddressHelper;
use App\Models\Loyalty\LoyaltyUserProposal as LoyaltyUserProposalModel;

/**
 * Class LoyaltyUserProposalAdmin
 * @package App\Mail
 */
class LoyaltyUserProposalAdmin extends BaseMail
{
    /**
     * @var array
     */
    public $params;

    /**
     * LoyaltyUserProposalAdmin constructor.
     * @param LoyaltyUserProposalModel $userProposal
     */
    public function __construct(LoyaltyUserProposalModel $userProposal)
    {
        $addressees = $this->getAddresses();

        $this->to($addressees);
        $this->subject(__('loyalty-program.email.user-proposal-admin.subject', ['url' => $this->getSiteHost()]));

        $this->params = $userProposal->toArray();
        $this->title = __('loyalty-program.email.user-proposal-admin.title');
        $this->text = __('loyalty-program.email.user-proposal-admin.text');
        $this->buttonUrl = route('admin.loyalty-program.loyalties.show', ['id' => $userProposal->loyaltyUserPoint->loyaltyUser->loyalty_id]);
        $this->buttonTitle = __('loyalty-program.email.user-proposal-admin.button-title');
    }

    /**
     * {@inheritDoc}
     */
    protected function getExtraAddressees(): array
    {
        return SettingAddressHelper::get(SettingDictionary::LOYALTY_USER_PROPOSAL_EMAILS);
    }
}
