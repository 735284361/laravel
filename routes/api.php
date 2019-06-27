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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::group(['middleware' => 'mock.user'], function () {//这个中间件可以先忽略，我们稍后再说
//    Route::middleware('wechat.oauth:snsapi_base')->group(function () {
//        Route::get('/login', 'SelfAuthController@autoLogin')->name('login');
//    });
//    Route::middleware('wechat.oauth:snsapi_userinfo')->group(function () {
//        Route::get('/register', 'SelfAuthController@autoRegister')->name('register');
//    });
//});

Route::group(['middleware' => 'auth:api'], function () {

});


Route::post('/user/wxapp/login', 'MiniAuthController@login');
Route::post('/user/wxapp/register/complex', 'MiniAuthController@register');
Route::get('/user/check-token', 'MiniAuthController@checkToken');
