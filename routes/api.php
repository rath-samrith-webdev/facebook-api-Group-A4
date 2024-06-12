<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ReplyController;
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
    Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
    Route::post('/password/reset', [AuthController::class, 'resetPassword']);
    Route::prefix('comments')->group(function () {
        Route::get('/all', [CommentController::class, 'index']);
        Route::get('/replies', [ReplyController::class, 'index']);
    });
    Route::prefix('likes')->group(function () {
        Route::get('/all', [LikeController::class, 'index']);
    });
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('/user/profile-image/update', [AuthController::class, 'updateProfileImage']);
    Route::put('/user/profile-data/update', [AuthController::class, 'updateProfileData']);
    Route::delete('/user/remove', [AuthController::class, 'remove']);
    Route::get('/me', [AuthController::class, 'me']);
    Route::prefix('comments')->group(function () {
        Route::post('/create', [CommentController::class, 'store']);
        Route::get('/my-comments', [CommentController::class, 'myComments']);
        Route::put('/update/{comment}', [CommentController::class, 'update']);
        Route::delete('/delete/{comment}', [CommentController::class, 'destroy']);
    });
    Route::prefix('replies')->group(function () {
        Route::post('/create', [ReplyController::class, 'store']);
        Route::get('/my-replies', [ReplyController::class, 'myReplies']);
        Route::put('/update/{reply}', [ReplyController::class, 'update']);
        Route::delete('/delete/{reply}', [ReplyController::class, 'destroy']);
    });
    Route::prefix('likes')->group(function () {
        Route::post('/create', [LikeController::class, 'store']);
        Route::get('/my-likes', [LikeController::class, 'myLikes']);
        Route::put('/update/{like}', [LikeController::class, 'update']);
        Route::delete('/delete/{like}', [LikeController::class, 'destroy']);
    });
});

