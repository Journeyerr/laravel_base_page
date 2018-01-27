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

Route::get('/','StaticPagesController@home');
Route::get('/help','StaticPagesController@help')->name('help');
Route::get('/about','StaticPagesController@about');

// 用户资源路由
Route::resource('users', 'UsersController');
Route::get('user', 'UsersController@create')->name('signup'); //显示登录页面
Route::get('login', 'SessionController@create')->name('login'); //显示登录页面
Route::post('login', 'SessionController@store')->name('login'); //登录验证
Route::delete('logout', 'SessionController@destore')->name('logout');   //注销登录

Route::get('signup/confirm/{token}', 'UsersController@checkConfirEmail')->name('confirm_email');   //激活邮件验证
