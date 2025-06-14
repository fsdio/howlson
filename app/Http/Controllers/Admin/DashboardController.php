<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Blog;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'roles' => Role::count(),
            'permissions' => Permission::count(),
            'blogs' => Blog::count(),
            'published_blogs' => Blog::published()->count(),
            'draft_blogs' => Blog::draft()->count(),
            'products' => Product::count(),
            'active_products' => Product::active()->count(),
            'categories' => ProductCategory::count(),
        ];

        $recent_blogs = Blog::with('author')
            ->latest()
            ->take(5)
            ->get();

        $recent_products = Product::with('category')
            ->latest()
            ->take(5)
            ->get();

        $recent_users = User::with('roles')
            ->latest()
            ->take(5)
            ->get();

        return Inertia::render('Admin/Dashboard', [
            'stats' => $stats,
            'recent_blogs' => $recent_blogs,
            'recent_products' => $recent_products,
            'recent_users' => $recent_users,
        ]);
    }
}