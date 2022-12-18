<?php

use Illuminate\Support\Facades\Route;

Route::group(['as' => 'remote-api.'], static function () {
    Route::group(['prefix' => 'electrician', 'as' => 'electrician.'], static function () {
        Route::group(['middleware' => ['remote-api']], static function () {
            Route::get('/', 'ElectricianController@getList')->name('get-list');
        });
    });
});
