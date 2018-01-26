<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();
Route::get('/', 'HomeController@index')->name('home.index');

Route::prefix('active')->group(function () {
    Route::get('{id}/{code}', 'ActivateController@active')->name('active.active');
    Route::get('{id}', 'UserController@resend')->name('active.resend');
});

Route::prefix('themes')->group(function () {
    Route::get('/', 'ThemeController@index');
    Route::get('create', 'ThemeController@create');
});

Route::middleware('auth')->group(function () {
    Route::get('/home', 'HomeController@dashboard')->name('home');
    Route::get('/site/create', 'SiteController@create')->name('site.create');

    Route::prefix('dashboard')->group(function () {
        Route::get('/{type}/{id}/{address}', 'PageController@show')->name('page.show');
        Route::get('/{type}/{action}/{id}/{address}', 'PageController@edit');
        Route::get('/{type}/{address}', 'PageController@index')->name('page.index');
    });
    // Bizlight Template NOT UPDATED
    Route::put('/const/{id}', 'ConstantController@update')->name('const.update');
    Route::put('/site/{id}', 'SiteController@update')->name('site.update');
    Route::delete('/section/{id}', 'SectionController@destroy')->name('section.delete');
    // END
});

Route::get('/s/{address}/{slug?}/{id?}', 'SiteController@show')->name('site');


Route::post('/contact/{id}', 'SectionController@message');
