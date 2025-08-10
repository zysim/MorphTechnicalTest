<?php

use App\Models\User;
use App\Models\Post;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('web')->group(function () {
    Route::get('/users/me', function (Request $request) {
        return $request->user();
    });

    Route::controller(PostController::class)->group(function () {
        Route::get('/posts', 'index');
        Route::get('/posts/rank', 'rank');
        Route::get('/posts/{post}', 'show');
        Route::delete('/posts/{post}', 'destroy');
    });
});
