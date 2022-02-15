<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::post('/auth/signup', [AuthController::class, 'signup'])->name('signup');
Route::post('/auth/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/forget-password', [AuthController::class, 'forgetPassword'])->name('forgetpassword');
Route::post('/auth/reset-password/{token}', [AuthController::class, 'resetpassword']);

Route::middleware('auth:sanctum')->group(function () {
    Route::patch('/auth/update-data', [AuthController::class, 'updatedata']);

    Route::patch('/auth/update-password', [AuthController::class, 'updatepassword']);
});