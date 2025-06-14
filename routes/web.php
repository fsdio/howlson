<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductCategoryController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
    $user = Auth::user();
    
    // Redirect admin users to admin dashboard
    if ($user && $user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Blog routes
    Route::get('/blog', function () {
        return Inertia::render('Blog');
    })->name('blog.index');
    
    Route::get('/blog/{id}', function ($id) {
        return Inertia::render('BlogDetail', ['articleId' => $id]);
    })->name('blog.detail');
    
    // Role and Permission routes
    Route::get('/roles', [RolePermissionController::class, 'roles'])->name('roles.index');
    Route::get('/permissions', [RolePermissionController::class, 'permissions'])->name('permissions.index');
    Route::get('/is-admin', [RolePermissionController::class, 'isAdmin'])->name('is-admin');
    Route::get('/is-user', [RolePermissionController::class, 'isUser'])->name('is-user');

    // Produk route
    Route::get('/produk', function () {
        return Inertia::render('Produk');
    })->name('produk.index');
    
    // Navbar Demo route
    Route::get('/navbar-demo', function () {
        return Inertia::render('NavbarDemo');
    })->name('navbar.demo');
    
    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Role Management
        Route::resource('roles', RoleController::class);
        
        // Permission Management
        Route::resource('permissions', PermissionController::class);
        
        // Blog Management
        Route::resource('blogs', BlogController::class);
        
        // Product Management
        Route::resource('products', ProductController::class);
        
        // Product Category Management
        Route::resource('product-categories', ProductCategoryController::class);
    });
});

require __DIR__.'/auth.php';
