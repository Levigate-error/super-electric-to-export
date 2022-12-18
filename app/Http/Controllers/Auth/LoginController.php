<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Domain\ServiceContracts\User\UserServiceContract;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

/**
 * Class LoginController
 * @package App\Http\Controllers\Auth
 */
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * @var UserServiceContract
     */
    protected $userService;

    /**
     * LoginController constructor.
     * @param UserServiceContract $userService
     */
    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return redirect('/');
    }

    /**
     * @param Request $request
     * @param User $user
     * @return mixed
     */
    protected function authenticated(Request $request, User $user)
    {
        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
            $this->guard()->logout();
            $request->session()->invalidate();

            $resendUrl = $this->getResendUrl($user->email);

            abort(403, trans('auth.email-not-verified', ['url' => $resendUrl]));
        }

        return $this->userService->getUserProfile($user->id);
    }

    /**
     * @param string $email
     * @return string
     */
    protected function getResendUrl(string $email): string
    {
        $expiration = Carbon::now()->addMinutes(Config::get('auth.verification.resend_expire', 60));

        $parameters = [
            'email' => $email,
        ];

        return URL::temporarySignedRoute('verification.resend', $expiration, $parameters);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function loggedOut(Request $request)
    {
        return [
            'result' => true,
        ];
    }
}
