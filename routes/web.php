<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\QuranLogController;
use App\Http\Controllers\Admin\LearningController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome')->name('home');

/*
|--------------------------------------------------------------------------
| Auth (Web)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Forgot Password
|--------------------------------------------------------------------------
*/
Route::post('/forgot-password', [AuthController::class, 'sendResetLink']);

Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])
    ->name('password.reset');

Route::post('/reset-password', [AuthController::class, 'resetPassword'])
    ->name('password.update');

/*
|--------------------------------------------------------------------------
| Admin Area (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        /*
        |----------------------------------
        | Dashboard (Admin & User)
        |----------------------------------
        */
        Route::get('/', [DashboardController::class, 'index'])
            ->name('dashboard');

        /*
        |----------------------------------
        | Users (ADMIN ONLY)
        |----------------------------------
        */
        Route::middleware('admin')->group(function () {

            Route::get('/users', [UserController::class, 'index'])
                ->name('users.index');

            Route::get('/users/{user}', [UserController::class, 'show'])
                ->name('users.show');

            Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])
                ->name('users.toggleActive');

            Route::patch('/users/{user}/toggle-role', [UserController::class, 'toggleRole'])
                ->name('users.toggleRole');

            Route::delete('/users/{user}', [UserController::class, 'destroy'])
                ->name('users.destroy');

            Route::patch('/users/{id}/restore', [UserController::class, 'restore'])
                ->name('users.restore');
        });

        /*
        |----------------------------------
        | Quran Logs (Admin & User)
        |----------------------------------
        */
        Route::get('/quran-logs', [QuranLogController::class, 'index'])
            ->name('quran.logs');

        Route::get('/quran-logs/{log}', [QuranLogController::class, 'show'])
            ->name('quran.logs.show');

        /*
        |----------------------------------
        | Learning (Admin & User)
        |----------------------------------
        */
        Route::get('/learning', [LearningController::class, 'index'])
            ->name('learning.index');

        Route::post('/learning/attendance', [LearningController::class, 'attend'])
            ->name('learning.attend');
    });
