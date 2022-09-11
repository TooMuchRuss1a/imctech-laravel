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
Route::get('/', [UserController::class, 'home'])->name('home');
Route::get('/pschool', [UserController::class, 'pschool'])->name('pschool');
Route::get('/psession', [UserController::class, 'psession'])->name('psession');
Route::get('/pschool/analytics', [UserController::class, 'analytics'])->name('analytics');
Route::get('/privacy', [UserController::class, 'privacy'])->name('privacy');

// Login Routes...
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Registration Routes...
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// Password Reset Routes...
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::group(['middleware' => 'isAuth'], function () {
    // Email Verification Routes...
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

    Route::group(['middleware' => 'emailVerified', 'prefix' => '/service',
    ], function () {
        Route::get('/', [UserController::class, 'service'])->name('service');
        Route::get('/activity/create', [UserController::class, 'activityCreate'])->name('service.activity');
        Route::post('/activity/create', [UserController::class, 'activitySave']);

        Route::group(['middleware' => 'can:view admin', 'prefix' => '/admin'], function () {
            Route::group(['middleware' => 'can:view logs'], function () {
                Route::get('/audits', [AdminController::class, 'audits'])->name('admin.audits');
                Route::get('/api', [AdminController::class, 'api'])->name('admin.api');
                Route::get('/errors', [AdminController::class, 'errors'])->name('admin.errors');
            });

            Route::group(['middleware' => 'can:view users'], function () {
                Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
                Route::get('/view/{id}', [AdminController::class, 'view'])->name('admin.view');
            });

            Route::group(['middleware' => 'can:view events'], function () {
                Route::get('/events', [AdminController::class, 'events'])->name('admin.events');
            });
            Route::group(['middleware' => 'can:create events'], function () {
                Route::get('/events/create', [AdminController::class, 'eventCreate'])->name('admin.events.create');
                Route::post('/events/create', [AdminController::class, 'eventSave']);
            });
            Route::group(['middleware' => 'can:edit'], function () {
                Route::get('/edit/{table}/{id}', [AdminController::class, 'edit'])->name('admin.edit');
                Route::post('/edit/{table}/{id}', [AdminController::class, 'editSave']);
            });
            Route::group(['middleware' => 'can:getlost'], function () {
                Route::get('/getlost', [AdminController::class, 'getLostUsers'])->name('admin.getlost');
                Route::post('/getlost', [AdminController::class, 'getLostUsersPost']);
            });
            Route::group(['middleware' => 'can:remove chat user'], function () {
                Route::get('/removechatuser/{chat_id}', [AdminController::class, 'removeChatUser'])->name('admin.removeChatUser');
                Route::post('/removechatuser/{chat_id}', [AdminController::class, 'removeChatUserPost']);
            });
            Route::group(['middleware' => 'can:edit roles'], function () {
                Route::get('/roles', [AdminController::class, 'roles'])->name('admin.roles');
                Route::get('/roles/create', [AdminController::class, 'roleCreate'])->name('admin.roles.create');
                Route::post('/roles/create', [AdminController::class, 'roleSave']);
                Route::get('/role/{id}/permission/add', [AdminController::class, 'permissionAdd'])->name('admin.permissionAdd');
                Route::post('/role/{id}/permission/add', [AdminController::class, 'permissionAddPost']);
                Route::get('/role/{id}/user/add', [AdminController::class, 'userAdd'])->name('admin.userAdd');
                Route::post('/role/{id}/user/add', [AdminController::class, 'userAddPost']);
                Route::get('/role/{id}/permission/remove/{permission_id}', [AdminController::class, 'permissionRemove'])->name('admin.permissionRemove');
                Route::get('/role/{id}/user/remove/{user_id}', [AdminController::class, 'userRemove'])->name('admin.userRemove');
                Route::get('/role/{id}/delete', [AdminController::class, 'roleDelete'])->name('admin.roleDelete');
            });
        });
    });
});
