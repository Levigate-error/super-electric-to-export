<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be resent if the user did not receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except('verify', 'resend');
        $this->middleware('signed')->only('verify', 'resend');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {
        return redirect('/');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws AuthorizationException
     */
    public function verify(Request $request)
    {
        $userId = $request->route('id');
        $token = $request->get('token');

        if (!Hash::check($userId, $token)) {
            throw new AuthorizationException;
        }

        $user = User::query()->findOrFail($userId);

        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        return redirect($this->redirectPath())->with('email_verified', true);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function resend(Request $request)
    {
        $email = $request->get('email');

        $user = User::query()
            ->where(['email' => $email])
            ->firstOrFail();

        if ($user->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $user->sendEmailVerificationNotification();

        return back()->with('email_resent', true);
    }
}
