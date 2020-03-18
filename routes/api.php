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


/*
|--------------------------------------------------------------------------
| Api Route
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'v2'], function ()
{
    // 需驗證身份 production 處理
    $middleware = ['auth:api'];
    if(\App::environment('production')) $middleware[] = 'verified';
    // dibbling client
    Route::middleware($middleware)->group(function () {
        // 取得使用者
        Route::get('user','v2\UserController@index');
        // 點播
        Route::post('list','v2\ListController@insert');
        // 重新點歌
        Route::put('list/{id}', 'v2\ListController@redibbling');
        // 切歌 & 移除
        Route::delete('list/{id}', 'v2\ListController@destroy');
        // 控制器指令
        Route::post('command', 'v2\CommandController@index');
        // 取得點播清單
        Route::get('list', 'v2\ListController@list');
        // 取得已播清單
        Route::post('list/played', 'v2\ListController@played');
        // 取得正在播放
        Route::get('playing', 'v2\PlayingController@get');
        // 點讚
        Route::post('like', 'v2\LikeController@like');
    });
    // dibbling player
    Route::get('/next', 'v2\PlayerController@next');
});
