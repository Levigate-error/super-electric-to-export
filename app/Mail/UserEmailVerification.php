<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;

/**
 * Class UserEmailVerification
 * @package App\Mail
 */
class UserEmailVerification extends BaseMail
{
    /**
     * @var array
     */
    public $params;

    /**
     * UserEmailVerification constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $siteHost = $this->getSiteHost();

        $this->to($user->email);
        $this->subject(__('user.email.verification', ['url' => $siteHost]));

        $this->params = $user->toArray();
        $this->title = __('user.email.verification-title', ['url' => $siteHost]);

        $this->buttonUrl = $this->verificationUrl($user);
        $this->buttonTitle = __('user.email.verification-button-title');

        $text = __('user.email.verification-info', ['url' => $siteHost]) .
            __('user.email.verification-wrong', ['url' => $siteHost]);

        $this->text = $text;

    }

    /**
     * @param User $user
     * @return string
     */
    protected function verificationUrl(User $user): string
    {
        $expiration = Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60));

        $parameters = [
            'id' => $user->getKey(),
            'token' => Hash::make($user->getKey()),
        ];

        return URL::temporarySignedRoute('verification.verify', $expiration, $parameters);
    }
}
