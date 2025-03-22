<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Livewire\Categories\CreateCategory;
use App\Livewire\Categories\EditCategory;
use App\Http\Controllers\NoteController;
use App\Livewire\Notes\CreateNote;
use App\Livewire\Notes\EditNote;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware('auth')->group(function () {
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/create', CreateCategory::class)->name('categories.create');
    Route::get('categories/{category}/edit', EditCategory::class)->name('categories.edit');

    Route::get('notes', [NoteController::class, 'index'])->name('notes.index');
    Route::get('notes/create', CreateNote::class)->name('notes.create');
    Route::get('notes/{note}/edit', EditNote::class)->name('notes.edit');
});

require __DIR__.'/auth.php';
