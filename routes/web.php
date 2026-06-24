<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController; // Pastikan ini di-import dan controllernya sudah dibuat
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// ===== LANDING PAGE (SINKRONISASI CEK ADMIN) =====
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        
        // Samakan kondisi check admin menggunakan email atau nama
        return ($user->email === 'admin@gmail.com' || $user->name === 'Admin') 
            ? redirect()->route('admin.dashboard') 
            : redirect()->route('dashboard');
    }
    return view('welcome');
})->name('welcome');

// ===== MIDDLEWARE AUTH & VERIFIED =====
Route::middleware(['auth', 'verified'])->group(function () {

    // --- GRUP KHUSUS ADMIN ---
    // Menggunakan alias 'admin' dari bootstrap/app.php
    Route::middleware('admin')->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
    });

    // --- GRUP USER BIASA ---
    // Dashboard User
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');
    
    // Fitur Postingan
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::post('/posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.uploadImage');
    Route::patch('/posts/{post}/found', [PostController::class, 'markAsFound'])->name('posts.found');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/postingan-saya', [PostController::class, 'myPosts'])->name('posts.mine');

    // Profile (Bisa diakses user maupun admin)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';