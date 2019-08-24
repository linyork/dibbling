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

// page
Route::get('/', 'Dibbling@index');
Route::get('dibbling', 'Dibbling@index');
Route::get('player', 'player@index');

// api
Route::group(['prefix' => 'player'], function () {
    Route::get('playing/{id}', 'Player@playing');
    Route::get('list', 'Player@list');
    Route::get('played-list', 'Player@play_list');
    Route::get('random', 'Player@random');
});

// api
Route::group(['prefix' => 'v1'], function () {
    Route::post('list','v1\ListController@store');
    Route::delete('list/{id}', 'v1\ListController@destroy');
    
    Route::get('playing', 'v1\PlayingController@show');
    Route::post('playing', 'v1\PlayingController@store');
});
