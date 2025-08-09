<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('mine', function () {
    return 'Yippee';
});

Route::resource('test', TestController::class);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
