<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/pschool', [UserController::class, 'pschool'])->name('pschool');
Route::get('/login', [UserController::class, 'login'])->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/login/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/pschool/analytics', [UserController::class, 'analytics'])->name('analytics');
Route::get('/registration', [UserController::class, 'registration'])->name('registration');
Route::post('/registration', [UserController::class, 'registration'])->name('registration');
Route::get('/confirm', [UserController::class, 'confirm'])->name('confirm');
Route::get('/confirmed', [UserController::class, 'confirmed'])->name('confirmed');
Route::get('/confirm/{hash}', [UserController::class, 'confirmHash'])->name('confirmHash');
