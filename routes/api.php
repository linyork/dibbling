<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use App\Http\Controllers;
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
    if(App::environment('production')) $middleware[] = 'verified';
    // dibbling client
    Route::middleware($middleware)->group(function () {
        // 取得使用者
        Route::get('user', [Controllers\v2\UserController::class, 'index']);
        // 點播
        Route::post('list', [Controllers\v2\ListController::class, 'insert']);
        // 重新點歌
        Route::put('list/{id}/{type?}', [Controllers\v2\ListController::class, 'redibbling']);
        // 切歌 & 移除
        Route::delete('list/{id}', [Controllers\v2\ListController::class, 'destroy']);
        // 控制器指令
        Route::post('command', [Controllers\v2\CommandController::class, 'index']);
        // 取得點播清單
        Route::get('list', [Controllers\v2\ListController::class, 'list']);
        // 取得已播清單
        Route::post('list/played', [Controllers\v2\ListController::class, 'played']);
        // 取得已讚清單
        Route::post('list/liked', [Controllers\v2\ListController::class, 'liked']);
        // 取得正在播放
        Route::get('playing', [Controllers\v2\PlayingController::class, 'get']);
        // 點讚
        Route::post('like', [Controllers\v2\LikeController::class, 'like']);
        // 資訊
        Route::post('info', [Controllers\v2\ListController::class, 'info']);
        // 設定播放起訖時間
        Route::post('setRange', [Controllers\v2\ListController::class, 'setRange']);
        // 點播歷程
        Route::post('timeline', [Controllers\v2\ListController::class, 'timeline']);

        // admin 區塊
        Route::middleware('can:admin')->group(function ()
        {
            // 移除使用者
            Route::delete('user/delete/{id}', [Controllers\v2\AdminController::class, 'deleteUser']);
            // google小姐廣播
            Route::post('broadcast', [Controllers\v2\AdminController::class, 'broadcast']);
        });

        // dibbling extension (開放給 chrome 的插件打的 api)
        Route::post('list/extension', [Controllers\v2\ListController::class, 'insert']);
        Route::put('list/extension/{id}', [Controllers\v2\ListController::class, 'redibbling']);
    });
    // dibbling player
    Route::get('next', [Controllers\v2\PlayerController::class, 'next']);
});
