<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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
        Route::get('user', [\App\Http\Controllers\v2\UserController::class, 'index']);
        // 點播
        Route::post('list', [\App\Http\Controllers\v2\ListController::class, 'insert']);
        // 重新點歌
        Route::put('list/{id}', [\App\Http\Controllers\v2\ListController::class, 'redibbling']);
        // 切歌 & 移除
        Route::delete('list/{id}', [\App\Http\Controllers\v2\ListController::class, 'destroy']);
        // 控制器指令
        Route::post('command', [\App\Http\Controllers\v2\CommandController::class, 'index']);
        // 取得點播清單
        Route::get('list', [\App\Http\Controllers\v2\ListController::class, 'list']);
        // 取得已播清單
        Route::post('list/played', [\App\Http\Controllers\v2\ListController::class, 'played']);
        // 取得正在播放
        Route::get('playing', [\App\Http\Controllers\v2\PlayingController::class, 'get']);
        // 點讚
        Route::post('like', [\App\Http\Controllers\v2\LikeController::class, 'like']);
        // 移除使用者
        Route::delete('user/delete/{id}', [\App\Http\Controllers\v2\AdminController::class, 'deleteUser'])
            ->middleware('can:admin');
        Route::post('broadcast', [\App\Http\Controllers\v2\AdminController::class, 'broadcast'])
            ->middleware('can:admin');

        // dibbling extension
        Route::post('list/extension', [\App\Http\Controllers\v2\ListController::class, 'insert']);
    });
    // dibbling player
    Route::get('next', 'v2\PlayerController@next');
});
