<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Route::middleware(['web', 'prevent_concurrent_login'])->group(function () {
//     // Your login route(s) go here
//     Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
//     Route::post('/login', 'Auth\LoginController@login');
//     // ...
// });

Route::group(['middleware' => 'single.session'], function () {
    // Routes that require single session
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    // Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
    // ...
});

use App\Http\Controllers\Auth\LogoutController;

Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
