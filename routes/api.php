<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuranLogController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/quran/logs', [QuranLogController::class, 'index']);
    Route::post('/quran/logs', [QuranLogController::class, 'store']);
    Route::get('/quran/streak', [QuranLogController::class, 'streak']);
    Route::get('/quran/calendar', [QuranLogController::class, 'calendar']);
    Route::get('/quran/logs/by-date', [QuranLogController::class, 'byDate']);
});
