<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Authentication routes
Route::get('/login', [AuthController::class, 'showLogin'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->middleware('guest');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Redirect homepage to bulletin posts
Route::redirect('/', '/posts');

// Display published posts
Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');

// Create and store posts (must be registered BEFORE /posts/{id})
Route::get('/posts/create', [PostController::class, 'create'])
    ->middleware('auth')
    ->name('posts.create');

Route::post('/posts', [PostController::class, 'store'])
    ->middleware('auth')
    ->name('posts.store');

// Store comments
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');

// Display one post
Route::get('/posts/{id}', [PostController::class, 'show'])
    ->name('posts.show');

// Display author profile
Route::get('/authors/{author}', [AuthorController::class, 'show'])
    ->name('authors.show');
