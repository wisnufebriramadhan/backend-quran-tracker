<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Admin Auth (WEB)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Dashboard (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::get('/users', [UserController::class, 'index'])
            ->name('admin.users.index');

        Route::get('/users/{user}', [UserController::class, 'show'])
            ->name('admin.users.show');

        Route::patch('/users/{user}/status', [UserController::class, 'toggleStatus'])
            ->name('admin.users.status');

         Route::patch('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])
            ->name('admin.users.toggleActive');

        Route::patch('/users/{user}/toggle-role', [UserController::class, 'toggleRole'])
            ->name('admin.users.toggleRole');
    });
