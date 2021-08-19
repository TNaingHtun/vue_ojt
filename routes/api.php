<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Api\Post\PostApiController;
use App\Http\Controllers\Api\User\UserApiController;
use App\Http\Controllers\Api\User\ProfileApiController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/post', [PostApiController::class,'getPostList']);
Route::get('/post/list', [PostApiController::class,'showPostList']);
Route::get('/post/search/{keyword}', [PostApiController::class,'showSearchPostList']);
Route::get('/post/list/{id}', [PostApiController::class,'showPostListById']);
Route::post('/post/create', [PostApiController::class,'createPost']);
Route::put('/post/edit/{id}', [PostApiController::class,'updatePostListById']);
Route::post('/post/upload', [PostApiController::class,'uploadCSVPost']);
Route::delete('/post/delete/{id}', [PostApiController::class,'deletePostListById']);
Route::post('/post/download/', [PostApiController::class,'downloadPostCSV']);

Route::get('/user/list', [UserApiController::class,'showUserList']);

//profile
Route::get('/profile', [ProfileApiController::class,'showProfileList']);
Route::get('/profile/{id}', [ProfileApiController::class,'showProfilebyId']);
Route::post('/profile/create', [ProfileApiController::class,'createProfile']);
Route::post('/profile/edit/{profileId}', [ProfileApiController::class,'updateProfile']);
Route::delete('/profile/delete/{profile}', [ProfileApiController::class,'deleteProfile']);
