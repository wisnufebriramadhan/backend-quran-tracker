<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuranLogController;

/*
|--------------------------------------------------------------------------
| AUTH - PUBLIC
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// 🔑 Forgot & Reset Password
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])
    ->middleware('throttle:5,1');

Route::post('/reset-password', [AuthController::class, 'resetPassword']);

/*
|--------------------------------------------------------------------------
| AUTH - PROTECTED
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // 🔒 Change Password
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    // 📖 Quran Logs
    Route::get('/quran/logs', [QuranLogController::class, 'index']);
    Route::post('/quran/logs', [QuranLogController::class, 'store']);
    Route::get('/quran/streak', [QuranLogController::class, 'streak']);
    Route::get('/quran/calendar', [QuranLogController::class, 'calendar']);
    Route::get('/quran/logs/by-date', [QuranLogController::class, 'byDate']);
});
