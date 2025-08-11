<?php

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (Auth::user() == null) {
        return to_route('login');
    }
    return to_route('dashboard');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard', ['isAdmin' => Auth::user()->is_admin]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('post/{post}', function(Post $post) {
    return Inertia::render('Post', ['post' => new PostResource($post), 'isAdmin' => Auth::user()->is_admin ]);
})->name('post');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
