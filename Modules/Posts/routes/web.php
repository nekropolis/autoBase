<?php

use Illuminate\Support\Facades\Route;
use Modules\Posts\Http\Controllers\PostController;

Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
