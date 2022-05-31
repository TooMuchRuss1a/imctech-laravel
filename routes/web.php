<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/pschool', function () {
    return view('pschool');
})->name('pschool');;

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', function () {
    return view('login');
})->name('login');

Route::get('/login/success', function () {
    return view('success');
})->name('success');

Route::get('/login/logout', function () {
    return view('logout');
})->name('logout');

Route::get('/pschool/analytics', function () {
    return view('analytics');
})->name('analytics'); // commit for commit // second commit
