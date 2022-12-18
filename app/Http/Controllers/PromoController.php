<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Http\Resources\UserResource;

/**
 * Class PromoController
 * @package App\Http\Controllers
 */
class PromoController extends BaseFrontController
{
    /**
     * @return View
     */
    public function index(): View
    {
        if (!empty(\Auth::user())) {
            $data["user_roles"] = \Auth::user()->getRoles();
        }

        $data["breadcrumbs"] = [
            [
                'title' => trans('promo.title'),
            ],
        ];

        $data["csrf"] = csrf_token();
        $data["user"] = \Auth::user();
        $data['userResource'] = (\Auth::user()) ? UserResource::make(\Auth::user())->resolve() : [];
        $data["recaptcha"] = config('recaptcha.google-recaptcha-site-key');
        
        return view('promo.index', [
            'data' => json_encode($data),
        ]);
    }
}
