<?php

namespace App\Mail;

use App\Models\User;

/**
 * Class LoyaltyUser
 * @package App\Mail
 */
class LoyaltyUser extends BaseMail
{
    /**
     * @var array
     */
    public $params;

    /**
     * LoyaltyUser constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->to($user->email);
        $this->subject(__('loyalty-program.email.user-loyalty.subject'));

        $this->params = $user->toArray();
        $this->title = __('loyalty-program.email.user-loyalty.title');
        $this->text = __('loyalty-program.email.user-loyalty.text');
        // $this->buttonUrl = route('loyalty-program.index'); //временно убираем ссылку
        $this->buttonTitle = __('loyalty-program.email.user-loyalty.button-title');
    }
}
