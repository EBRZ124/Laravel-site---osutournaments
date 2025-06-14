<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\TournamentController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;

// Public Homepage
Route::get('/', [PageController::class, 'homepage'])->name('home');

// Static Pages
Route::get('/apply',   [PageController::class, 'apply'])->name('apply');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact',[PageController::class, 'sendContact'])->name('contact.send');

// Archived Tournaments Listing (public)
Route::get('/archives', [TournamentController::class, 'index'])->name('archives');

// Single Tournament Detail (public)
// placed before catch-all to avoid conflicts
Route::get('/archives/{tournament}', [TournamentController::class, 'show'])
     ->name('tournaments.show')
     ->whereNumber('tournament');

// Routes for verified users (requires authentication & email verification)
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Create & Store Tournament
    Route::get('/archives/create', [TournamentController::class, 'create'])->name('tournaments.create');
    Route::post('/archives',      [TournamentController::class, 'store'])->name('tournaments.store');

    // Post Comment under Tournament
    Route::post('/archives/{tournament}/comments', [CommentController::class, 'store'])
         ->name('comments.store');

    // Verified Users: Create Forum Posts (if using)
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts',       [PostController::class, 'store'])->name('posts.store');
});

// Redirect legacy /home
Route::get('/home', function () {
    return redirect()->route('dashboard');
});