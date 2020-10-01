<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\UserController;

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


Route::group(['prefix' => 'v1'], function() {
    Route::get('/categories', [CategoryController::class, 'index']);

    // post route
    Route::get('/posts', [PostController::class, 'index']);

    // post show
    Route::apiResource('/post', PostController::class)->only('show');

    // register
    Route::post('/register', [UserController::class, 'register']);

    // login
    Route::post('/login', [UserController::class, 'login']);

    //user
    Route::get('/users', [UserController::class, 'index']);


    // Authentication user
    Route::middleware('auth:api')->group(function () {
        // category route
        Route::apiResource('/category', CategoryController::class);

        // comment route
        Route::post('/comment/create/{post}', [CommentController::class, 'addPostComment']);
        Route::apiResource('/comment', CommentController::class)->only('destroy', 'update');

        // post route
        Route::apiResource('/post', PostController::class)->only('store', 'destroy', 'update');

        // logout
        Route::get('/logout', [UserController::class, 'logout']);

        // user route
        Route::apiResource('/user', UserController::class);

    });


});




