<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public static function content()
    {
        return function (Row $row) {
            $row->column(4, function (Column $column) {
                $column->append(view('vendor.admin.dashboard.dashboard'));
            });

            $row->column(4, function (Column $column) {
                $column->append(view('vendor.admin.dashboard.dashboard'));
            });

            $row->column(4, function (Column $column) {
                $column->append(view('vendor.admin.dashboard.dashboard'));
            });
        };
    }

    public function index(Content $content)
    {
        return $content
            ->header('Панель')
            ->description('Панель управления')
            ->row(self::content());
    }
}
