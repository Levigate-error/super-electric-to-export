<?php

namespace App\Mail;

use App\Models\User;

/**
 * Class LoyaltyUserCanceled
 * @package App\Mail
 */
class LoyaltyUserCanceled extends BaseMail
{
    /**
     * @var array
     */
    public $params;

    /**
     * LoyaltyUserCanceled constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->to($user->email);
        $this->subject(__('loyalty-program.email.user-loyalty-change-status.subject'));

        $this->params = $user->toArray();
        $this->title = __('loyalty-program.email.user-loyalty-change-status.title');
        $this->text = __('loyalty-program.email.user-loyalty-change-status.text');
        $this->buttonUrl = route('user.profile');
        $this->buttonTitle = __('loyalty-program.email.user-loyalty-change-status.button-title');
    }
}
