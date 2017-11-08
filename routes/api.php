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

	Route::prefix('section')->group(function () {
		Route::get('{id}', 'SectionController@edit');
	});
	
	Route::prefix('imgs')->group(function () {
		Route::get('{address}', 'ImgController@index');
		Route::post('{address}', 'ImgController@store');
	});

	Route::put('/content', 'ContentController@update');

});