<?php

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard', ['isAdmin' => Auth::user()->is_admin]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('post/{post}', function(Post $post) {
    return Inertia::render('Post', ['post' => new PostResource($post) ]);
})->name('post');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
