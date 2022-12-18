<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Http\Requests\User\UserRegisterRequest;
use App\Domain\ServiceContracts\User\UserServiceContract;
use App\Domain\Dictionaries\Users\SourceDictionary;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * @var UserServiceContract
     */
    protected $userService;

    /**
     * RegisterController constructor.
     * @param UserServiceContract $userService
     */
    public function __construct(UserServiceContract $userService)
    {
        $this->userService = $userService;
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return redirect('/');
    }

    /**
     * @param UserRegisterRequest $request
     *
     * @return array|Translator|string|null
     */
    public function register(UserRegisterRequest $request)
    {

        $data = $request->validated();

        $data['source'] =  SourceDictionary::REGISTRATION;

        $user = $this->create($data);

        event(new Registered($user));

        return trans('auth.sent-email-verified', ['email' => $user->email]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data): User
    {
        return $this->userService->getRepository()->getSource()::createUser($data);
    }
}
