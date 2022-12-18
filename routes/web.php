<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

if (request()->getHttpHost() == 'xn--e1aajhbc0ajddrf7k.xn--p1ai') {
    header('Location: https://superelektrik.ru');
}

Auth::routes(['verify' => true]);

Route::get('/', 'IndexController@index')->name('index');

Route::group(['prefix' => 'catalog', 'as' => 'catalog.'], static function () {
    Route::get('/', 'CatalogController@index')->name('index');
    Route::get('/product/{product}', 'ProductController@detail')->name('product');
});

Route::group(['prefix' => 'project', 'as' => 'project.'], static function () {
    Route::get('/list', 'ProjectController@list')->name('list');
    Route::get('/create', 'ProjectController@create')->name('create');
    Route::get('/details/{project}', 'ProjectController@details')->name('details');
    Route::get('/update/{project}', 'ProjectController@update')->name('update');
    Route::get('/products/{project}', 'ProjectController@products')->name('products');
    Route::get('/specifications/{project}', 'ProjectController@specifications')->name('specifications');
});

Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => ['auth']], static function () {
    Route::get('/profile', 'UserController@profile')->name('profile');
});

Route::group(['as' => 'loyalty-program.'], static function () {
    Route::get('/loyalty-program', 'LoyaltyProgramController@index')->name('index');
    Route::get('/leto_legrand', 'LoyaltyProgramController@inspiriaIndex')->name('inspiria');
    // Route::get('/inspiria', [LoyaltyProgramController::class, 'inspiriaIndex'])->name('inspiria');
});

Route::group(['prefix' => 'promo', 'as' => 'promo.'], static function () {
    Route::get('/', 'PromoController@index')->name('index');
});

Route::group(['prefix' => 'registration', 'as' => 'register-modal.'], static function () {
    Route::get('/', 'RegisterModalOpenController@index')->name('index');
});

Route::group(['prefix' => 'video', 'as' => 'video.'], static function () {
    Route::get('/', 'VideoController@index')->name('index');
});

Route::group(['prefix' => 'faq', 'as' => 'faq.'], static function () {
    Route::get('/', 'FaqController@index')->name('index');
});

Route::group(['prefix' => 'news', 'as' => 'news.'], static function () {
    Route::get('/', 'NewsController@index')->name('index');
    Route::get('/{id}', 'NewsController@show')->name('show');
});

Route::group(['prefix' => 'test', 'as' => 'test.'], static function () {
    Route::get('/', 'TestController@index')->name('index');
    Route::get('/{id}', 'TestController@show')->name('show');
});
