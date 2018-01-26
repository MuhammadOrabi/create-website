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

    
    Route::prefix('pages')->group(function () {
        Route::get('/{id}', 'PageController@show');
        Route::put('/{id}', 'PageController@update');
    });

    Route::prefix('sections')->group(function () {
        Route::get('{id}', 'SectionController@edit');
        Route::post('{id}', 'SectionController@store');
        Route::put('{id}', 'SectionController@update');
        Route::delete('{id}', 'SectionController@destroy');
    });

    Route::prefix('contents')->group(function () {
        Route::get('{id}', 'ContentController@edit');
        Route::post('/{id}', 'ContentController@store');
        Route::put('/{id}', 'ContentController@update');
        Route::delete('/{id}', 'ContentController@destroy');
    });

    Route::prefix('imgs')->group(function () {
        Route::get('{address}', 'ImgController@index');
        Route::post('/', 'ImgController@store');
    });

    Route::prefix('users')->group(function () {
        Route::get('/{address}', 'UserController@index');
        Route::put('/{address}/edit/{option}', 'UserController@updateByAdmin');
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

Route::prefix('pages')->group(function () {
    Route::get('/{id}', 'PageController@show');
});
Route::prefix('sections')->group(function () {
    Route::get('/{id}', 'SectionController@show');
});
// End


Route::post('/contact/{id}', 'SectionController@message');
