<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/todos', function () {
    return view('todos');
})->middleware(['auth', 'verified'])->name('todos');

Route::get('/counter', function () {
    return view('counter');
})->middleware(['auth', 'verified'])->name('counter');

require __DIR__.'/auth.php';
