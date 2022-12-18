<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class BaseFrontController extends Controller
{
    /**
     * @param string $method
     * @param array $parameters
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function callAction($method, $parameters)
    {
        $userResource = (Auth::user()) ? UserResource::make(Auth::user())->resolve() : [];

        View::share('userResource', $userResource);

        return parent::callAction($method, $parameters);
    }
}
