<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolePermissionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Role and Permission routes
    Route::get('/roles', [RolePermissionController::class, 'roles'])->name('roles.index');
    Route::get('/permissions', [RolePermissionController::class, 'permissions'])->name('permissions.index');
    Route::get('/is-admin', [RolePermissionController::class, 'isAdmin'])->name('is-admin');
    Route::get('/is-user', [RolePermissionController::class, 'isUser'])->name('is-user');
});

require __DIR__.'/auth.php';
