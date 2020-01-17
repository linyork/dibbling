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

// home
Route::get('/', function(){
    return redirect('dibbling');
});
// dibbling
Route::get('dibbling', function(){
    return view('dibbling');
})->name('dibbling');
// player
Route::get('player', function(){
    return view('player');
})->name('player');

// api
Route::group(['prefix' => 'v1'], function () {
    Route::get('list', 'v1\ListController@index');
    Route::get('list/{action}', 'v1\ListController@show');
    Route::post('list','v1\ListController@store');
    Route::put('list/{id}', 'v1\ListController@update');
    Route::delete('list/{id}', 'v1\ListController@destroy');

    Route::get('playing', 'v1\PlayingController@show');
    Route::post('playing', 'v1\PlayingController@store');
});
