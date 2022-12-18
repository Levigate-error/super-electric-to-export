<?php

use App\Http\Controllers\Api\CertificateController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['as' => 'api.',], static function () {
    Route::post('/excel', 'ProductController@createWithExcel');
    Route::group(['prefix' => '/catalog', 'as' => 'catalog.'], static function () {
        Route::get('/product-categories', 'ProductCategoryController@list')->name('product-categories');
        Route::get('/product-families', 'ProductFamilyController@listByParams')->name('product-families');
        Route::get('/product-divisions', 'ProductDivisionController@listByParams')->name('product-divisions');
        Route::get('/filters', 'ProductFeatureController@getFilters')->name('filters');
        Route::post('/products', 'ProductController@listByParams')->name('products');
        Route::get('/products/recommended', 'ProductController@getRecommended')->name('recommended');
        Route::get('/products/{id}/buy-with-it', 'ProductController@getBuyWithIt')->name('buy-with-it');

        Route::group(['prefix' => '/products', 'as' => 'products.', 'middleware' => ['auth']], static function () {
            Route::post('/add-to-favorite', 'ProductController@addToFavorite')->name('add-to-favorite');
            Route::post('/remove-from-favorite', 'ProductController@removeFromFavorite')->name('remove-from-favorite');
        });
    });

    Route::group(['prefix' => '/project', 'as' => 'project.'], static function () {
        Route::post('/list', 'ProjectController@list')->name('list');
        Route::post('/create', 'ProjectController@store')->name('create');
        Route::post('/update/{id}', 'ProjectController@update')->name('update');
        Route::get('/details/{id}', 'ProjectController@details')->name('details');
        Route::delete('/delete/{id}', 'ProjectController@delete')->name('delete');
        Route::get('/status/list', 'ProjectController@statusesList')->name('status');
        Route::post('/product/add', 'ProjectController@addProduct')->name('product-add');
        Route::post('/create-from-file', 'ProjectController@createProjectFromFile')->name('create-from-file');

        Route::group(['prefix' => '/category', 'as' => 'category.'], static function () {
            Route::post('/add/{id}', 'ProjectController@addCategory')->name('add');
            Route::get('/list/{id}', 'ProjectController@categoriesList')->name('list');
        });

        Route::group(['prefix' => '/{project_id}'], static function () {
            Route::group(['prefix' => '/category/{category_id}', 'as' => 'project-category.'], static function () {
                Route::get('/divisions', 'ProjectController@categoryDivisions')->name('category-divisions');
                Route::delete('/', 'ProjectController@deleteCategory')->name('delete');
            });

            Route::get('/division/{division_id}/products', 'ProjectController@divisionProducts')->name('division-products');
            Route::delete('/product/{product_id}/delete', 'ProjectController@productDelete')->name('product-delete');
            Route::post('/products', 'ProjectController@products')->name('products');
            Route::patch('/product/{product_id}/update', 'ProjectController@productUpdate')->name('product-update');
            Route::get('/export', 'ProjectController@export')->name('export');
            Route::post('/compare-with-file', 'ProjectController@compareWithFile')->name('compare-with-file');
            Route::patch('/apply-changes', 'ProjectController@applyChanges')->name('apply-changes');
        });

        Route::group(['prefix' => '/specification', 'as' => 'specification.'], static function () {
            Route::group(['prefix' => '/{specification_id}'], static function () {
                Route::group(['prefix' => '/sections', 'as' => 'sections.'], static function () {
                    Route::get('/list', 'SpecificationController@specificationSectionsList')->name('list');
                    Route::post('/add', 'SpecificationController@specificationSectionAdd')->name('add');
                    Route::delete('/{specification_section_id}/delete', 'SpecificationController@specificationSectionDelete')->name('delete');
                    Route::patch('/{specification_section_id}/update', 'SpecificationController@specificationSectionUpdate')->name('update');
                    Route::post('/{specification_section_id}/add-product', 'SpecificationController@specificationSectionAddProduct')->name('add-product');
                });

                Route::group(['prefix' => '/products', 'as' => 'products.'], static function () {
                    Route::post('/move', 'SpecificationController@productMove')->name('move');
                    Route::patch('/{specification_product_id}/update', 'SpecificationController@productUpdate')->name('update');
                    Route::delete('/{specification_product_id}/delete', 'SpecificationController@productDelete')->name('delete');
                    Route::post('/replace', 'SpecificationController@productReplace')->name('replace');
                });
            });
        });
    });

    Route::group(['prefix' => '/specification', 'as' => 'specification.'], static function () {
        Route::group(['prefix' => '/files', 'as' => 'files.'], static function () {
            Route::post('/check', 'SpecificationController@checkFile')->name('check');
            Route::get('/example', 'SpecificationController@getFileExample')->name('example');
        });
    });

    Route::group(['prefix' => '/analog', 'as' => 'analog.'], static function () {
        Route::post('/search', 'AnalogueController@search')->name('search');
    });

    Route::group(['prefix' => 'user', 'as' => 'user.'], static function () {
        Route::get('/auth/check', 'UserController@checkAuth')->name('auth-check');

        Route::group(['middleware' => ['auth']], static function () {
            Route::patch('/password', 'UserController@passwordUpdate')->name('password-update');
            Route::post('/personal-data', [UserController::class, 'storePersonalData']);
            Route::delete('/', 'UserController@delete')->name('delete');

            Route::group(['prefix' => '/profile', 'as' => 'profile.'], static function () {
                Route::patch('/', 'UserController@profileUpdate')->name('update');
                Route::post('/photo', 'UserController@profilePhotoUpdate')->name('photo-update');
                Route::patch('/published', 'UserController@profilePublishedUpdate')->name('published-update');
                Route::get('/completeness-check', 'UserController@profileCompletenessCheck')->name('completeness-check');
            });
        });

        Route::group(['middleware' => ['guest']], static function () {
            Route::post('/', 'UserController@register')->name('register');
        });
    });

    Route::group(['prefix' => 'loyalty', 'as' => 'loyalty.'], static function () {
        Route::group(['middleware' => ['auth']], static function () {
            Route::post('/', 'LoyaltyController@getList')->name('get-list');
            Route::post('/register-user', 'LoyaltyController@registerUser')->name('register-user');
            Route::post('/register-product-code', 'LoyaltyController@registerProductCode')->name('register-product-code');
            Route::post('/upload-receipt', 'LoyaltyController@uploadReceipt')->name('upload-receipt');
            Route::post('/manually-upload-receipt', 'LoyaltyController@uploadReceiptManually')->name('upload-receipt-manually');
            Route::post('/choose-gift', 'LoyaltyController@chooseGift')->name('choose-gift');
            Route::get('/{id}/proposals', 'LoyaltyController@getProposalsList')->name('proposals');

            Route::get('/uploaded-receipts', 'LoyaltyController@getLoyaltyReceiptsByUser')->name('uploaded-receipts');
            Route::get('/total-amount', 'LoyaltyController@getLoyaltyReceiptsTotalAmountByUser')->name('total-amount');

            Route::get('/add-coupon', 'LoyaltyController@addCoupon')->name('add-coupon');
            Route::get('/user-coupons', 'LoyaltyController@userCoupons')->name('user-coupons');
        });

        Route::get('/documents', 'LoyaltyController@documents')->name('documents');
        Route::get('/gifts', 'LoyaltyController@gifts')->name('gifts');



    });

    //Route::get('/test-amount', 'LoyaltyController@getLoyaltyReceiptsTotalAmountByUserTest');
    Route::group(['prefix' => '/feedback', 'as' => 'feedback.'], static function () {
        Route::post('/', 'FeedbackController@store')->name('store');
    });

    Route::group(['prefix' => '/city', 'as' => 'city.'], static function () {
        Route::post('/search', 'CityController@search')->name('search');
    });

    Route::group(['prefix' => '/banner', 'as' => 'banner.'], static function () {
        Route::get('/', 'BannerController@list')->name('list');
    });

    Route::group(['prefix' => '/video', 'as' => 'video.'], static function () {
        Route::get('/categories', 'VideoController@getVideoCategoryList')->name('get-category-list');
        Route::post('/search', 'VideoController@searchVideo')->name('search-video');
    });

    Route::group(['prefix' => '/faq', 'as' => 'faq.'], static function () {
        Route::post('/get-faqs', 'FaqController@getFaqs')->name('get-faqs');
    });

    Route::group(['prefix' => '/news', 'as' => 'news.'], static function () {
        Route::post('/get-news', 'NewsController@getNews')->name('get-news');
        Route::get('/{id}', 'NewsController@details')->name('details');
    });

    Route::group(['prefix' => '/tests', 'as' => 'tests.'], static function () {
        Route::get('/', 'TestController@getTests')->name('get-tests');
        Route::get('/{id}', 'TestController@getDetails')->name('get-details');
        Route::post('/{id}', 'TestController@registerTest')->name('register-test');
    });
    Route::group(['prefix' => '/certificate', 'middleware' => ['auth']], function () {
        Route::post('/register', [CertificateController::class, 'register']);
    });
});
