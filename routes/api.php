<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('/user/profile/update', [AuthController::class, 'updateProfileImage']);
    Route::delete('/user/remove', [AuthController::class, 'remove']);
    Route::get('/me', [AuthController::class, 'me']);
});
