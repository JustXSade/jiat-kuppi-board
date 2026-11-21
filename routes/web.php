<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('board.index');
Route::post('/posts', [PostController::class, 'store'])->name('board.store');
Route::patch('/posts/{post}/toggle', [PostController::class, 'toggleStatus'])->name('board.toggle');