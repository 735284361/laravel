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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::any('/wechat', 'WeChatController@serve');
//Route::any('/testApi', 'WeChatController@testApi');

//Route::any('testApi/{action}','WeChatController');
Route::any('testApi/{action}', function(App\Http\Controllers\WeChatController $index, $action){
    return $index->$action();
});

Route::group(['middleware' => ['web', 'wechat.oauth']], function () {
    Route::get('/user', function () {
        $user = session('wechat.oauth_user.default'); // 拿到授权用户资料

        dd($user);
    });
});

Route::group(['middleware' => 'mock.user'], function () {//这个中间件可以先忽略，我们稍后再说
    Route::middleware('wechat.oauth:snsapi_base')->group(function () {
        Route::get('/login', 'SelfAuthController@autoLogin')->name('login');
    });
    Route::middleware('wechat.oauth:snsapi_userinfo')->group(function () {
        Route::get('/register', 'SelfAuthController@autoRegister')->name('register');
    });
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/example', 'HomeController@index');
});