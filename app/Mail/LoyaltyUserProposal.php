<?php

namespace App\Mail;

use App\Models\User;

/**
 * Class LoyaltyUserProposal
 * @package App\Mail
 */
class LoyaltyUserProposal extends BaseMail
{
    /**
     * @var array
     */
    public $params;

    /**
     * LoyaltyUserProposal constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->to($user->email);
        $this->subject(__('loyalty-program.email.user-proposal.subject', ['url' => $this->getSiteHost()]));

        $this->params = $user->toArray();
        $this->title = __('loyalty-program.email.user-proposal.title');
        $this->text = __('loyalty-program.email.user-proposal.text', ['email' => $user->email]);
        // $this->buttonUrl = route('loyalty-program.index'); //временно убираем ссылку
        $this->buttonTitle = __('loyalty-program.email.user-proposal.button-title');
    }
}
