<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ProductCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of product categories.
     */
    public function index(Request $request)
    {
        $query = ProductCategory::with('parent', 'children');

        // Filter by parent
        if ($request->has('parent') && $request->parent !== 'all') {
            if ($request->parent === 'none') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $request->parent);
            }
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $categories = $query->latest()->paginate(10);
        $parentCategories = ProductCategory::whereNull('parent_id')->active()->get();
        
        return Inertia::render('Admin/ProductCategories/Index', [
            'categories' => $categories,
            'parentCategories' => $parentCategories,
            'filters' => $request->only(['parent', 'status', 'search'])
        ]);
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        $parentCategories = ProductCategory::whereNull('parent_id')->active()->get();
        
        return Inertia::render('Admin/ProductCategories/Create', [
            'parentCategories' => $parentCategories
        ]);
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data = $request->except(['image']);
        $data['id'] = Str::uuid();
        $data['slug'] = Str::slug($request->name);
        $data['sort_order'] = $request->sort_order ?? 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('category-images', 'public');
        }

        ProductCategory::create($data);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Kategori produk berhasil dibuat.');
    }

    /**
     * Display the specified category.
     */
    public function show(ProductCategory $productCategory)
    {
        $productCategory->load('parent', 'children', 'products');
        
        return Inertia::render('Admin/ProductCategories/Show', [
            'category' => $productCategory
        ]);
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(ProductCategory $productCategory)
    {
        $parentCategories = ProductCategory::whereNull('parent_id')
            ->where('id', '!=', $productCategory->id)
            ->active()
            ->get();
        
        return Inertia::render('Admin/ProductCategories/Edit', [
            'category' => $productCategory,
            'parentCategories' => $parentCategories
        ]);
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => [
                'nullable',
                'exists:product_categories,id',
                function ($attribute, $value, $fail) use ($productCategory) {
                    if ($value == $productCategory->id) {
                        $fail('Kategori tidak dapat menjadi parent dari dirinya sendiri.');
                    }
                },
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data = $request->except(['image']);
        $data['slug'] = Str::slug($request->name);
        $data['sort_order'] = $request->sort_order ?? 0;

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($productCategory->image) {
                Storage::disk('public')->delete($productCategory->image);
            }
            $data['image'] = $request->file('image')->store('category-images', 'public');
        }

        $productCategory->update($data);

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Kategori produk berhasil diperbarui.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(ProductCategory $productCategory)
    {
        // Check if category has products
        if ($productCategory->products()->count() > 0) {
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki produk.');
        }

        // Check if category has children
        if ($productCategory->children()->count() > 0) {
            return redirect()->route('admin.product-categories.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki sub kategori.');
        }

        // Delete image
        if ($productCategory->image) {
            Storage::disk('public')->delete($productCategory->image);
        }

        $productCategory->delete();

        return redirect()->route('admin.product-categories.index')
            ->with('success', 'Kategori produk berhasil dihapus.');
    }
}