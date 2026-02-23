<?php

use App\Http\Controllers\Api\V1\CategoryApiController;
use App\Http\Controllers\Api\V1\CommentApiController;
use App\Http\Controllers\Api\V1\PostApiController;
use App\Http\Controllers\Api\V1\TagApiController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API v1 Routes
|--------------------------------------------------------------------------
*/

Route::prefix('v1')->middleware(['throttle:api'])->group(function () {
    // Posts
    Route::get('/posts', [PostApiController::class, 'index']);
    Route::get('/posts/popular', [PostApiController::class, 'popular']);
    Route::get('/posts/{slug}', [PostApiController::class, 'show']);

    // Categories
    Route::get('/categories', [CategoryApiController::class, 'index']);
    Route::get('/categories/{slug}', [CategoryApiController::class, 'show']);
    Route::get('/categories/{slug}/posts', [CategoryApiController::class, 'posts']);

    // Tags
    Route::get('/tags', [TagApiController::class, 'index']);
    Route::get('/tags/{slug}', [TagApiController::class, 'show']);
    Route::get('/tags/{slug}/posts', [TagApiController::class, 'posts']);

    // Comments
    Route::get('/posts/{postId}/comments', [CommentApiController::class, 'index']);
    Route::post('/posts/{postId}/comments', [CommentApiController::class, 'store']);
});
