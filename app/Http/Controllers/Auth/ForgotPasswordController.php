<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Exceptions\User\EmailNotFoundException;
use Illuminate\Http\JsonResponse;

/**
 * Class ForgotPasswordController
 * @package App\Http\Controllers\Auth
 */
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        return redirect('/');
    }

    /**
     * @param  Request  $request
     * @param $response
     * @return JsonResponse
     */
    protected function sendResetLinkResponse(Request $request, $response): JsonResponse
    {
        return response()->json([
            'message' => trans($response, ['email' => $request->get('email')]),
        ]);
    }

    /**
     * @param  Request  $request
     * @param $response
     */
    protected function sendResetLinkFailedResponse(Request $request, $response): void
    {
        throw new EmailNotFoundException(trans($response));
    }
}
