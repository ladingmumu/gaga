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


//主页
Route::get('/','StaticPagesController@home')->name('home');

//帮助页
Route::get('/help','StaticPagesController@help')->name('help');

//关于页
Route::get('/about','StaticPagesController@about')->name('about');

//注册
Route::get('/signup','UsersController@create')->name('signup');

//用户资源
Route::resource('users','UsersController');

//显示登录页面
Route::get('login','SessionsController@create')->name('login');

//创建新会话（登录）
Route::post('login','SessionsController@store')->name('login');

//销毁会话（退出登录）
Route::delete('logout','SessionsController@destroy')->name('logout');

//激活路由
Route::get('signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');

//显示重置密码的邮箱发送页面
Route::get('password/reset','Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');

//邮箱发送重设链接
Route::post('password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

//密码更新页面
Route::get('password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.reset');

//执行密码更新操作
Route::post('password/reset','Auth\ResetPasswordController@reset')->name('password.update');







