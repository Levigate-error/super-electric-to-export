<?php

namespace App\Mail;

use App\Models\User;

/**
 * Class ResetPassword
 * @package App\Mail
 */
class ResetPassword extends BaseMail
{
    /**
     * @var array
     */
    public $params;

    /**
     * ResetPassword constructor.
     * @param User $user
     * @param string $token
     */
    public function __construct(User $user, string $token)
    {
        $siteHost = $this->getSiteHost();

        $this->to($user->email);
        $this->subject( __('user.email.reset-password', ['url' => $siteHost]));

        $this->params = $user->toArray();
        $this->title = __('user.email.reset-password-title');

        $resetPasswordUrl = route('password.reset', [
            'token' => $token,
            'email' => $user->getEmailForPasswordReset()
        ], true);

        $this->buttonUrl = $resetPasswordUrl;
        $this->buttonTitle = __('user.email.reset-password-button-title');

        $fullName = $user->first_name . ' ' . $user->last_name;
        $text = __('user.email.reset-password-info', ['fullName' => $fullName, 'url' => $siteHost]) .
                __('user.email.reset-password-wrong') .
                __('user.email.reset-password-expire', ['expire' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]);

        $this->text = $text;

    }
}
