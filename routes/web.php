<?php
/*
|--------------------------------------------------------------------------
| Web Routes __construct
|--------------------------------------------------------------------------
*/
App::setLocale((Cookie::get('locale')) ?? 'en');
$userMiddlewareArray = ['auth'];
if(\App::environment('production')) $userMiddlewareArray[] = 'verified';

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
Route::get('set_locale/{locale}', 'SetLocale@index')->name('set_locale');
Route::get('/', function (){ return redirect('dibbling'); })->name('home');
Route::get('player', function (){ return view('player'); })->name('player');
Route::middleware($userMiddlewareArray)->group(function () {
    Route::get('dibbling','Dibbling@index')->name('dibbling');
    Route::get('dibbling_list','DibblingList@index')->name('dibbling_list');
    Route::get('dibbling_record','DibblingRecord@index')->name('dibbling_record');
    Route::get('setting', 'Setting@index')->name('setting');
    Route::get('player_controller','PlayerController@index')->name('player_controller');
});
Auth::routes(['verify' => \App::environment('production')]);
