<?php

namespace App\Mail;

use App\Models\User;

/**
 * Class LoyaltyUserProposalApproved
 * @package App\Mail
 */
class LoyaltyUserProposalApproved extends BaseMail
{
    /**
     * @var array
     */
    public $params;

    /**
     * LoyaltyUserProposalApproved constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->to($user->email);
        $this->subject(__('loyalty-program.email.user-proposal-approved.subject', ['url' => $this->getSiteHost()]));

        $this->params = $user->toArray();
        $this->title = __('loyalty-program.email.user-proposal-approved.title');
        $this->text = __('loyalty-program.email.user-proposal-approved.text');
        // $this->buttonUrl = route('loyalty-program.index'); //временно убираем ссылку
        $this->buttonTitle = __('loyalty-program.email.user-proposal-approved.button-title');
    }
}
