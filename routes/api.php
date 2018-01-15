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
Route::prefix('dashboard')->middleware('auth:api')->group(function () {
    Route::prefix('sites')->group(function () {
        Route::post('/', 'SiteController@store');
        Route::get('exists/{address}', 'SiteController@exists');
    });

    Route::prefix('sections')->group(function () {
        Route::post('{id}', 'SectionController@store');
        Route::get('{id}', 'SectionController@edit');
        Route::put('{id}', 'SectionController@update');
        Route::delete('{id}', 'SectionController@destroy');
    });

    Route::prefix('imgs')->group(function () {
        Route::post('/', 'ImgController@store');
        Route::get('{address}', 'ImgController@index');
    });

    Route::prefix('contents')->group(function () {
        Route::put('/{address}', 'ContentController@update');
    });
    Route::prefix('users')->group(function () {
        Route::put('/{address}/edit/{option}', 'UserController@updateByAdmin');
        Route::get('/{address}', 'UserController@index');
    });
});
// Site
Route::prefix('sites')->group(function () {
    Route::get('/info/{type}/{address}', 'SiteController@info');
});

Route::prefix('users')->group(function () {
    Route::post('/site/register', 'UserController@store');
    Route::post('/site/login', 'UserController@login');
});

// End

Route::middleware('auth:api')->group(function () {
    Route::prefix('contents')->group(function () {
        Route::post('/{id}', 'ContentController@store');
        Route::put('/{id}', 'ContentController@updateExtras');
        Route::delete('/{id}', 'ContentController@destroy');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', 'UserController@show');
        Route::put('/', 'UserController@update');
    });
});

Route::prefix('sections')->group(function () {
    Route::get('/{id}', 'SectionController@showAPI');
});

Route::prefix('contents')->group(function () {
    Route::get('/{id}', 'ContentController@show');
});

Route::prefix('pages')->group(function () {
    Route::get('/{id}', 'PageController@show');
});

Route::post('/contact/{id}', 'SectionController@message');

Route::prefix('logs')->group(function () {
    Route::post('/', 'LogController@store');
});
