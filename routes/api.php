<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ReplyCommentController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\UserController;
use App\Models\ReplyComment;
use Illuminate\Http\Request;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


// post
Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{slug}', [PostController::class, 'show']);

// category
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/{slug}', [CategoryController::class, 'show']);

// comment
Route::post('/comment', [CommentController::class, 'store']);

// reply comment
Route::post('/reply-comment', [ReplyCommentController::class, 'store']);

// user
Route::get('/profile/{username}', [UserController::class, 'profileWithPost']);

// tutorial
Route::get('/tutorial', [TutorialController::class, 'index']);
Route::get('/tutorial/{slug}', [TutorialController::class, 'show']);

Route::middleware('guest')->group(function () {

    // user
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'authenticate']);
});

Route::middleware('auth:sanctum')->group(function () {
    // user
    Route::put('/profile/{username}', [UserController::class, 'update']);
    Route::post('/logout', [UserController::class, 'logout']);

    // post
    Route::resource('/posts', PostController::class)->except('index', 'show');

    // category
    Route::resource('/category', CategoryController::class)->except('index', 'show');

    // comments
    Route::resource('/comment', CommentController::class)->except('store');

    // tutorial
    Route::resource('/tutorial', TutorialController::class)->except('index', 'show');
});
