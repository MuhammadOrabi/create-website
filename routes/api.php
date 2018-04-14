<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Dashboard

Route::middleware('auth:api')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::prefix('sites')->group(function () {
            Route::post('/', 'SiteController@store');
            Route::get('exists/{address}', 'SiteController@exists');
            Route::put('/{id}', 'SiteController@update');
        });

        
        Route::prefix('pages')->group(function () {
            Route::post('/{address}', 'PageController@store');
            Route::get('/{id}', 'PageController@show');
            Route::put('/{id}', 'PageController@update');
        });

        Route::prefix('sections')->group(function () {
            Route::post('{id}', 'SectionController@store');
            Route::get('{id}', 'SectionController@edit');
            Route::put('{id}', 'SectionController@update');
            Route::delete('{id}', 'SectionController@destroy');
        });

        Route::prefix('contents')->group(function () {
            Route::get('{id}', 'ContentController@edit');
            Route::post('/{id}', 'ContentController@store');
            Route::put('/{id}', 'ContentController@update');
            Route::delete('/{id}', 'ContentController@destroy');
        });

        Route::prefix('extras')->group(function () {
            Route::get('{id}', 'ExtraController@edit');
            Route::post('{extraable}/{id}', 'ExtraController@store');
            Route::put('{id}', 'ExtraController@update');
            Route::delete('{extraable}/{id}', 'ExtraController@destroy');
        });

        Route::prefix('imgs')->group(function () {
            Route::get('{address}', 'ImgController@index');
            Route::post('/', 'ImgController@store');
        });

        Route::prefix('users')->group(function () {
            Route::get('/{address}', 'UserController@index');
            Route::put('/{address}/edit/{option}', 'UserController@updateByAdmin');
        });

        Route::prefix('constants')->group(function () {
            Route::put('{id}', 'ConstantController@update');
        });
    });


    Route::prefix('users')->group(function () {
        Route::put('/{id}', 'UserController@update');
    });
});
// Site
Route::prefix('sites')->group(function () {
    Route::get('/info/{type}/{address}', 'SiteController@info');
});

Route::prefix('users')->group(function () {
    Route::post('/site/register', 'UserController@store');
    Route::post('/site/login', 'UserController@login');
    Route::get('/{id}/{address}', 'UserController@show');
});

Route::prefix('pages')->group(function () {
    Route::get('/{id}', 'PageController@show');
});

Route::prefix('sections')->group(function () {
    Route::get('/{id}', 'SectionController@show');
    Route::post('/{id}', 'SectionController@store');
});

Route::prefix('contents')->middleware('auth:api')->group(function () {
    Route::get('/{id}', 'ContentController@show');
});

Route::prefix('constants')->group(function () {
    Route::get('{id}', 'ConstantController@show');
});

Route::get('imgs/{tag}', 'ImgController@show');

// End


Route::post('/contact/{id}', 'SectionController@message');
