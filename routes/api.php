<?php

use Illuminate\Http\Request;

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
	Route::get('user', function () {
	   return $request->user();
	});

	Route::prefix('site')->group(function () {
		Route::post('/', 'SiteController@store');
		Route::get('exists/{address}', 'SiteController@exists');
	});

	Route::prefix('sections')->group(function () {
		Route::get('{id}', 'SectionController@index');
		Route::get('{id}/edit', 'SectionController@edit');
		Route::post('{id}', 'SectionController@store');
		Route::delete('{id}', 'SectionController@destroyAPI');
	});
	
	Route::prefix('imgs')->group(function () {
		Route::post('/', 'ImgController@store');
		Route::get('{address}', 'ImgController@index');
	});

	Route::prefix('contents')->group(function () {
		Route::put('/', 'ContentController@update');
	});

});