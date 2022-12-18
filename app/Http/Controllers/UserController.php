<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends BaseFrontController
{
    /**
     * @return View
     */
    public function profile(): View
    {
        $breadcrumbs = [
            [
                'title' => trans('user.profile'),
            ],
        ];

        return view('user.profile', [
            'breadcrumbs' => $breadcrumbs,
        ]);
    }
}
