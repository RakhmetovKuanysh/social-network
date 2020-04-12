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

// Авторизация
Route::get('login', 'AuthController@login')->name('login');
Route::post('login', 'AuthController@authenticate')->name('authenticate');
Route::get('register', 'AuthController@register')->name('register');
Route::post('register', 'AuthController@post')->name('post');
Route::post('logout', 'AuthController@logout')->name('logout');

// Профиль
Route::get('profile', 'UserController@profile')->name('profile');

// Подписка
Route::get('subscribe', 'UserController@subscribe')->name('subscribe');
Route::get('unsubscribe', 'UserController@unsubscribe')->name('unsubscribe');

// Сообщения
Route::get('messages', 'MessageController@index')->name('messages');
Route::post('sendMessage', 'MessageController@sendMessage')->name('sendMessage');

// Посты
Route::post('publish', 'PostController@publish')->name('publish');

// Главная
Route::post('search', 'HomeController@search')->name('search');
Route::get('home', 'HomeController@index')->name('home');
