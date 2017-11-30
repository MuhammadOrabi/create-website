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

Route::middleware('auth:api')->group(function () {
    Route::prefix('site')->group(function () {
        Route::post('/', 'SiteController@store');
        Route::get('exists/{address}', 'SiteController@exists');
    });

    Route::prefix('sections')->group(function () {
        Route::post('{id}', 'SectionController@store');
        Route::get('{id}/edit', 'SectionController@update');
        Route::put('{id}/edit', 'SectionController@editExtras');
        Route::delete('{id}', 'SectionController@destroyAPI');
    });

    Route::prefix('imgs')->group(function () {
        Route::post('/', 'ImgController@store');
        Route::get('{address}', 'ImgController@index');
    });

    Route::prefix('contents')->group(function () {
        Route::post('/{id}', 'ContentController@store');
        Route::put('/{id}', 'ContentController@updateExtras');
        Route::put('/', 'ContentController@update');
        Route::delete('/{id}', 'ContentController@destroy');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', 'UserController@show');
        Route::get('/{address}', 'UserController@index');
        Route::put('/{address}/edit/{option}', 'UserController@updateByAdmin');
        Route::put('/', 'UserController@update');
    });

    Route::prefix('extras')->group(function () {
    });
});

Route::prefix('user')->group(function () {
    Route::post('/', 'UserController@store');
    Route::post('login', 'UserController@login');
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
