<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;

Route::get('/', [PageController::class, 'homepage'])->name('home');

Route::get('/apply',   [PageController::class, 'apply'])->name('apply');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact',[PageController::class, 'sendContact'])->name('contact.send');

Route::get('/archives', [TournamentController::class, 'index'])->name('archives');


Route::get('/archives/{tournament}', [TournamentController::class, 'show'])
     ->name('tournaments.show')
     ->whereNumber('tournament');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    Route::get('/archives/create', [TournamentController::class, 'create'])->name('tournaments.create');
    Route::post('/archives',      [TournamentController::class, 'store'])->name('tournaments.store');

    Route::post('/archives/{tournament}/comments', [CommentController::class, 'store'])
         ->name('comments.store');

    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts',       [PostController::class, 'store'])->name('posts.store');
});

Route::get('/home', function () {
    return redirect()->route('dashboard');
});
