<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

/*
|--------------------------------------------------------------------------
| Web Routes __construct
|--------------------------------------------------------------------------
*/
App::setLocale((Cookie::get('locale')) ?? 'en');
$userMiddlewareArray = ['auth'];
if(App::environment('production')) $userMiddlewareArray[] = 'verified';

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
// auth
Auth::routes(['verify' => App::environment('production')]);

// set block
Route::get('set_locale/{locale}', [\App\Http\Controllers\Set::class, 'locale'])
    ->name('set_locale');
Route::get('set_mode/{mode}', [\App\Http\Controllers\Set::class, 'mode'])
    ->name('set_mode');
// web block
Route::get('/', function (){ return redirect('dibbling'); })
    ->name('home');
Route::get('player', function (){ return view('player'); })
    ->name('player');
// user web block
Route::middleware($userMiddlewareArray)->group(function () {
    Route::get('dibbling', [\App\Http\Controllers\Dibbling::class, 'index'])
        ->name('dibbling');
    Route::get('dibbling_list', [\App\Http\Controllers\DibblingList::class, 'index'])
        ->name('dibbling_list');
    Route::get('dibbling_record', [\App\Http\Controllers\DibblingRecord::class, 'index'])
        ->name('dibbling_record');
    Route::get('setting', [\App\Http\Controllers\Setting::class, 'index'])
        ->name('setting');
    Route::get('admin_interface', [\App\Http\Controllers\AdminInterface::class, 'index'])
        ->middleware('can:admin')
        ->name('admin_interface');
});