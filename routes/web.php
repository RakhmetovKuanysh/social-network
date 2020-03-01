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

Route::get('/', function () {
    return redirect('home');
});

Route::get('login', 'AuthController@login')->name('login');
Route::post('login', 'AuthController@authenticate')->name('authenticate');
Route::get('register', 'AuthController@register')->name('register');
Route::post('register', 'AuthController@post')->name('post');
Route::post('logout', 'AuthController@logout')->name('logout');

Route::get('profile', 'UserController@profile')->name('profile');
Route::get('subscribe', 'UserController@subscribe')->name('subscribe');
Route::get('unsubscribe', 'UserController@unsubscribe')->name('unsubscribe');

Route::post('publish', 'PostController@publish')->name('publish');

Route::post('search', 'HomeController@search')->name('search');
Route::get('home', 'HomeController@index')->name('home');
