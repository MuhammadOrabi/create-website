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

Route::get('/active/{id}/{code}', 'ActivateController@active')->name('active.active');
Route::get('/active/{id}', 'UserController@resend')->name('active.resend');

Route::get('/', 'HomeController@index')->name('home.index');
Route::get('/home', 'HomeController@dashboard')->name('home');

Route::get('/sites/create', 'SiteController@create')->name('site.create');

Route::get('/themes', 'ThemeController@index');
Route::get('/themes/create', 'ThemeController@create');