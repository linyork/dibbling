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
    // 需驗證身份
    Route::middleware('auth:api')->group(function () {
        // 點播
        Route::post('list','v2\ListController@insert');
        // 重新點歌
        Route::put('list/{id}', 'v2\ListController@redibbling');
        // 切歌 & 移除
        Route::delete('list/{id}', 'v2\ListController@destroy');
    });
    // 取得點播清單
    Route::get('list', 'v2\ListController@list');
    // 取得已播清單
    Route::get('list/played', 'v2\ListController@played');
    // 隨機一首
    Route::get('list/random', 'v2\ListController@random');
    // TODO: 或許可用list最新更新時間取得
    // 取得正在播放
    Route::get('playing', 'v2\PlayingController@get');
    // 更新正在播放
    Route::post('playing', 'v2\PlayingController@playing');
});
