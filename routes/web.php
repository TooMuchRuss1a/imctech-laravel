<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

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
Auth::routes();
Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/pschool', [UserController::class, 'pschool'])->name('pschool');
Route::get('/psession', [UserController::class, 'psession'])->name('psession');
Route::get('/pschool/analytics', [UserController::class, 'analytics'])->name('analytics');

// Login Routes...
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes...
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes...
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Email Verification Routes...
Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

Route::group(['middleware' => 'emailVerified', 'prefix' => '/service',
], function () {
    Route::get('/', [UserController::class, 'service'])->name('service');
    Route::get('/activity/create', [UserController::class, 'activityCreate'])->name('service.activity');
    Route::post('/activity/create', [UserController::class, 'activitySave']);

    Route::group(['middleware' => 'hasRole', 'prefix' => '/admin',], function () {
        Route::get('/errors', [AdminController::class, 'errors'])->name('admin.errors');
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/view/{id}', [AdminController::class, 'view'])->name('admin.view');
        Route::get('/events', [AdminController::class, 'events'])->name('admin.events');
        Route::get('/events/create', [AdminController::class, 'eventCreate'])->name('admin.events.create');
        Route::post('/events/create', [AdminController::class, 'eventSave']);
        Route::get('/roles', [AdminController::class, 'roles'])->name('admin.roles');
        Route::get('/roles/create', [AdminController::class, 'roleCreate'])->name('admin.roles.create');
        Route::post('/roles/create', [AdminController::class, 'roleSave']);
    });
});
