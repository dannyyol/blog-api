<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;

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


// Route::group(['prefix' => 'v1'], function() {


// });

// Route::get('/','Api\PostController@index');
    // Route::resource('posts','Api\PostController');

// category route
Route::apiResource('/category', CategoryController::class);
Route::get('/categories', [CategoryController::class, 'index']);

// post route
Route::apiResource('/post', PostController::class);
Route::get('/posts', [PostController::class, 'index']);

// comment route
Route::post('/comment/create/{post}', [CommentController::class, 'addPostComment']);
Route::apiResource('/comment', CommentController::class)->only('destroy', 'update');




