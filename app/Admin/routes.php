<?php

use App\Admin\Controllers\CertificateController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Encore\Admin\Facades\Admin;

Route::as('admin.upload-image')
    ->post('upload-image', 'App\Admin\Controllers\TextEditorImageController@upload');

Admin::routes();

Route::group([
    'prefix' => config('admin.route.prefix'),
    'namespace' => config('admin.route.namespace'),
    'middleware' => config('admin.route.middleware'),
    'as' => 'admin.',
], static function (Router $router) {
    $router->get('/', 'HomeController@index')->name('admin.home');

    Route::group(['prefix' => 'catalog', 'as' => 'catalog.'], static function () {
        Route::group(
            ['prefix' => '/product-categories', 'as' => 'product-categories.', 'namespace' => 'Product'],
            static function () {
                Route::get('/', 'ProductCategoriesController@index')->name('index');

                Route::group(['prefix' => '/{id}'], static function () {
                    Route::get('/', 'ProductCategoriesController@show')->name('show');
                    Route::get('/edit', 'ProductCategoriesController@edit')->name('edit');
                    Route::put('/', 'ProductCategoriesController@update')->name('update');
                });
            }
        );

        Route::group(['prefix' => '/product-families', 'as' => 'product-families.'], static function () {
            Route::get('/', 'ProductFamiliesController@index')->name('index');
            Route::put('/{id}', 'ProductFamiliesController@publish')->name('publish');
        });

        Route::group(['prefix' => '/product-divisions', 'as' => 'product-divisions.'], static function () {
            Route::get('/', 'ProductDivisionsController@index')->name('index');

            Route::group(['prefix' => '/{id}'], static function () {
                Route::get('/edit', 'ProductDivisionsController@edit')->name('edit');
                Route::put('/update', 'ProductDivisionsController@update')->name('update');
                Route::put('/', 'ProductDivisionsController@publish')->name('publish');
                Route::get('/', 'ProductDivisionsController@show')->name('show');
                Route::put('/{feature_type_division_id}', 'ProductDivisionsController@publishFeatureTypeDivision')
                    ->name('publishFeatureTypeDivision');
            });
        });

        Route::group(['prefix' => '/products', 'as' => 'products.', 'namespace' => 'Product'], static function () {
            Route::get('/', 'ProductController@index')->name('list');

            Route::group(['prefix' => '/{id}'], static function () {
                Route::put('/', 'ProductController@update')->name('update');
            });
        });
    });

    Route::group(
        ['prefix' => '/loyalty-program', 'as' => 'loyalty-program.', 'namespace' => 'Loyalty'],
        static function () {
            Route::group(['prefix' => '/loyalties', 'as' => 'loyalties.'], static function () {
                Route::get('/', 'LoyaltyController@index')->name('list');

                Route::group(['prefix' => '/{id}'], static function () {
                    Route::get('/', 'LoyaltyController@show')->name('show');
                    Route::put('/{entity_id}', 'LoyaltyController@loyaltyEntityChangeStatus')->name('change-status');
                    Route::get('/{proposal_id}/edit', 'LoyaltyController@editProposal')->name('edit-proposal');
                });
            });

            Route::resource('/receipts', 'LoyaltyReceiptsController');
            Route::resource('/gifts', 'LoyaltyGiftsController');
            Route::resource('/coupons', 'LoyaltyCouponsController');
            Route::resource('/documents', 'LoyaltyDocumentsController');
            Route::resource('/giftProducts', 'GiftsController');

            Route::group(['prefix' => '/settings', 'as' => 'settings.'], static function () {
                Route::group(['prefix' => '/product-codes', 'as' => 'product-codes.'], static function () {
                    Route::get('/', 'LoyaltyProductCodeController@index')->name('list');
                    Route::get('/{id}/edit', 'LoyaltyProductCodeController@edit')->name('edit');
                    Route::get('/create', 'LoyaltyProductCodeController@create')->name('create');
                    Route::put('/{id}', 'LoyaltyProductCodeController@update')->name('update');
                    Route::post('/', 'LoyaltyProductCodeController@store')->name('store');
                    Route::delete('/{id}', 'LoyaltyProductCodeController@delete')->name('delete');
                });

                Route::group(['prefix' => '/certificates', 'as' => 'certificates.'], static function () {
                    Route::get('/', [CertificateController::class , 'index'])->name('list');
                    Route::get('/{id}/edit', [CertificateController::class , 'edit'])->name('edit');
                    Route::get('/create', [CertificateController::class , 'create'])->name('create');
                    Route::put('/{id}', [CertificateController::class , 'update'])->name('update');
                    Route::post('/', [CertificateController::class , 'store'])->name('store');
                    Route::delete('/{id}', [CertificateController::class , 'delete'])->name('delete');
                });
            });
        }
    );

    Route::group(['prefix' => '/users', 'as' => 'users.', 'namespace' => 'User'], static function () {
        Route::get('/', 'UserController@index')->name('list');
        Route::get('/import', 'UserController@formImport')->name('form-import');
        Route::post('/import', 'UserController@import')->name('import');

        Route::group(['prefix' => '/{id}'], static function () {
            Route::delete('/', 'UserController@destroy')->name('destroy');
            Route::put('/', 'UserController@update')->name('update');
        });
    });

    Route::group(['prefix' => '/banners', 'as' => 'banners.'], static function () {
        Route::get('/', 'BannerController@index')->name('list');
        Route::get('/create', 'BannerController@create')->name('create');
        Route::post('/', 'BannerController@store')->name('store');

        Route::group(['prefix' => '/{id}'], static function () {
            Route::get('/edit', 'BannerController@edit')->name('edit');
            Route::put('/', 'BannerController@update')->name('update');
            Route::delete('/', 'BannerController@destroy')->name('destroy');
            Route::get('/', 'BannerController@show')->name('show');
        });
    });

    Route::group(['prefix' => '/video', 'as' => 'video.', 'namespace' => 'Video'], static function () {
        Route::resource('categories', 'VideoCategoryController');
        Route::resource('videos', 'VideoController');
    });

    Route::resource('/faq', 'FaqController');
    Route::resource('/news', 'NewsController');
    Route::resource('/feedback', 'FeedbackController');
    Route::resource('/setting', 'SettingController');

    Route::group(['prefix' => '/test', 'as' => 'test.', 'namespace' => 'Test'], static function () {
        Route::resource('/main', 'TestController');
        Route::resource('/result', 'TestResultController');
        Route::resource('/question', 'TestQuestionController');
        Route::resource('/answer', 'TestAnswerController');
    });
});
