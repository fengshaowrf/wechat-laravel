<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//微信接口
Route::any('/wechat', 'WechatController@index');

Route::get('login', function () {
    $data = array(
        'special' => 0,
        'title' => '登录',
        'desc' => '手机验证码登录'
    );
    return view('login.index',compact('data'));
});

Route::group(['middleware' => ['web', 'forchange.wxoauth']], function () {
    Route::get('/userinfo', 'IndexController@userinfo');
});