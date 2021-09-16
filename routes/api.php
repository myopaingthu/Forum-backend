<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\ReplyController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\NotificationController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'authenticate']);

Route::middleware('auth:api')->group(function () {
  Route::post('logout', [AuthController::class, 'logout']);
  Route::apiResource('categories', CategoryController::class);
  Route::apiResource('questions', QuestionController::class);
  Route::apiResource('questions.replies', ReplyController::class)->shallow();
  Route::post('replies/{reply}/likes', [LikeController::class, 'store']);
  Route::delete('replies/{reply}/likes', [LikeController::class, 'destroy']);
  Route::post('notifications', [NotificationController::class, 'index']);
  Route::post('markAsRead', [NotificationController::class, 'markAsRead']);
  Route::post('replies/{reply}/bestReply', [ReplyController::class, 'bestReplyStore']);
  Route::delete('replies/{reply}/bestReply', [ReplyController::class, 'bestReplyDestroy']);
});
