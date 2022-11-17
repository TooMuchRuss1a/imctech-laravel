<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\EventController;

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
        Route::get('/profile', [UserController::class, 'profile'])->name('service.profile');

        Route::group(['middleware' => 'can:view admin', 'prefix' => '/admin'], function () {
            Route::group(['middleware' => 'can:view logs'], function () {
                Route::get('/audits', [AdminController::class, 'audits'])->name('admin.audits');
                Route::get('/api', [AdminController::class, 'api'])->name('admin.api');
                Route::get('/errors', [AdminController::class, 'errors'])->name('admin.errors');
            });

            Route::group(['middleware' => 'can:view users'], function () {
                Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
                Route::get('/view/{id}', [AdminController::class, 'view'])->name('admin.users.view');
                Route::get('/create', [AdminController::class, 'userCreate'])->name('admin.users.create');
                Route::post('/create', [AdminController::class, 'userSave']);
            });

            Route::group(['prefix' => '/events'], function () {
                Route::get('/', [EventController::class, 'index'])->name('admin.events');
                Route::get('/create', [EventController::class, 'create'])->name('admin.events.create');
                Route::post('/create', [EventController::class, 'save']);
                Route::get('/edit/{id}', [EventController::class, 'edit'])->name('admin.events.edit');
                Route::post('/edit/{id}', [EventController::class, 'update']);
                Route::get('/delete/{id}', [EventController::class, 'delete'])->name('admin.events.delete');
                Route::get('/view/{id}', [EventController::class, 'view'])->name('admin.events.view');
            });
            Route::group(['middleware' => 'can:edit'], function () {
                Route::get('/edit/{table}/{id}', [AdminController::class, 'edit'])->name('admin.edit');
                Route::post('/edit/{table}/{id}', [AdminController::class, 'editSave']);
            });
            Route::group(['middleware' => 'can:getlost'], function () {
                Route::get('/getlost', [AdminController::class, 'getLostUsers'])->name('admin.getlost');
                Route::post('/getlost', [AdminController::class, 'getLostUsersPost']);
            });
            Route::get('/dead_souls', [AdminController::class, 'dead_souls'])->name('admin.dead_souls');
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
            Route::group(['middleware' => 'can:edit timetable', 'prefix' => '/timetable'], function () {
                Route::get('/', [TimetableController::class, 'index'])->name('admin.timetable.index');
                Route::get('/create', [TimetableController::class, 'create'])->name('admin.timetable.create');
                Route::post('/create', [TimetableController::class, 'store']);
                Route::get('/edit/{id}', [TimetableController::class, 'edit'])->name('admin.timetable.edit');
                Route::post('/edit/{id}', [TimetableController::class, 'update']);
                Route::get('/delete/{id}', [TimetableController::class, 'delete'])->name('admin.timetable.delete');
                Route::get('/toggle', [TimetableController::class, 'toggle'])->name('admin.timetable.toggle');
            });
        });
    });
});
