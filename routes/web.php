<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

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

Auth::routes(['verify' => true]);

Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('isAuthenticated', [HomeController::class, 'isAuthenticated']);

// // Route::get('user', [App\Http\Controllers\HomeController::class, 'user'])->name('user');
//Route::get('webuser',[AuthController::class,'webuser']);