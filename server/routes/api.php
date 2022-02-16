<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
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

    /////////AUTH

    Route::patch('/auth/update-data', [AuthController::class, 'updatedata']);
    Route::delete('/auth/logout', [AuthController::class, 'logout']);
    Route::patch('/auth/update-password', [AuthController::class, 'updatepassword']);

    ////////Order

    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::delete('/orders/{order}', [OrderController::class, 'destory']);
    Route::patch('/orders/{order}', [OrderController::class, 'update']);
    Route::get('/orders/{order}', [OrderController::class, 'show']);

});

Route::get('/delete-image/{image}', [OrderController::class, 'deleteImage'])->name('delete-image');

Route::post('/orders', [OrderController::class, 'store']);