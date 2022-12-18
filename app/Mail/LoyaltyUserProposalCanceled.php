<?php

namespace App\Mail;

use App\Models\Loyalty\LoyaltyUserProposal;
use App\Models\User;

/**
 * Class LoyaltyUserProposalCanceled
 * @package App\Mail
 */
class LoyaltyUserProposalCanceled extends BaseMail
{
    /**
     * @var array
     */
    public $params;

    /**
     * LoyaltyUserProposalCanceled constructor.
     * @param User $user
     * @param LoyaltyUserProposal $proposal
     */
    public function __construct(User $user, LoyaltyUserProposal $proposal)
    {
        $reason = ($proposal->loyaltyCancelReason !== null) ? $proposal->loyaltyCancelReason->value : '';

        $this->to($user->email);
        $this->subject(__('loyalty-program.email.user-proposal-canceled.subject', ['url' => $this->getSiteHost()]));

        $this->params = $user->toArray();
        $this->title = __('loyalty-program.email.user-proposal-canceled.title');
        $this->text = __('loyalty-program.email.user-proposal-canceled.text', ['reason' => $reason]);
        $this->buttonUrl = route('faq.index');
        $this->buttonTitle = __('loyalty-program.email.user-proposal-canceled.button-title');
    }
}
