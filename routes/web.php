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

Route::group(['middleware' => 'auth'], function ()
{
    Route::get('/', function ()
        {
            return redirect('dibbling');
        }
    );
    Route::get('dibbling','Dibbling@index')->name('dibbling');
    Route::get('dibbling_list','DibblingList@index')->name('dibbling_list');
    Route::get('dibbling_record','DibblingRecord@index')->name('dibbling_record');
});

// player
Route::get('player', function ()
{
    return view('player');
}
)->name('player');

Auth::routes();
