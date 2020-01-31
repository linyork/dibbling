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
    Route::get('list', 'v2\ListController@list');
    Route::get('list/played', 'v2\ListController@played');
    Route::get('list/random', 'v2\ListController@random');
    Route::get('playing', 'v2\PlayingController@get');

    Route::group(['middleware' => 'auth:api'], function ()
    {
        Route::post('playing', 'v2\PlayingController@playing');
        Route::post('list','v2\ListController@insert');
        Route::put('list/{id}', 'v2\ListController@redibbling');
        Route::delete('list/{id}', 'v2\ListController@destroy');
    });

});
