<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'description' => 'Electronic devices and gadgets',
                'parent_id' => null,
                'status' => 'active',
                'sort_order' => 1,
                'meta_title' => 'Electronics - Latest Gadgets and Devices',
                'meta_description' => 'Shop the latest electronic devices, gadgets, and accessories.',
            ],
            [
                'name' => 'Clothing',
                'description' => 'Fashion and apparel for all occasions',
                'parent_id' => null,
                'status' => 'active',
                'sort_order' => 2,
                'meta_title' => 'Clothing - Fashion and Apparel',
                'meta_description' => 'Discover the latest fashion trends and quality clothing for men and women.',
            ],
            [
                'name' => 'Home & Garden',
                'description' => 'Home improvement and garden supplies',
                'parent_id' => null,
                'status' => 'active',
                'sort_order' => 3,
                'meta_title' => 'Home & Garden - Improve Your Living Space',
                'meta_description' => 'Find everything you need for home improvement and garden maintenance.',
            ],
            [
                'name' => 'Books',
                'description' => 'Books and educational materials',
                'parent_id' => null,
                'status' => 'active',
                'sort_order' => 4,
                'meta_title' => 'Books - Knowledge and Entertainment',
                'meta_description' => 'Explore our collection of books across various genres and topics.',
            ],
        ];

        $createdCategories = [];
        
        // Create parent categories first
        foreach ($categories as $categoryData) {
            $categoryData['id'] = Str::uuid();
            $categoryData['slug'] = Str::slug($categoryData['name']);
            
            $category = ProductCategory::create($categoryData);
            $createdCategories[$categoryData['name']] = $category;
        }

        // Create subcategories
        $subcategories = [
            [
                'name' => 'Smartphones',
                'description' => 'Latest smartphones and mobile devices',
                'parent_name' => 'Electronics',
                'status' => 'active',
                'sort_order' => 1,
                'meta_title' => 'Smartphones - Latest Mobile Devices',
                'meta_description' => 'Shop the latest smartphones with cutting-edge technology.',
            ],
            [
                'name' => 'Laptops',
                'description' => 'Laptops and portable computers',
                'parent_name' => 'Electronics',
                'status' => 'active',
                'sort_order' => 2,
                'meta_title' => 'Laptops - Portable Computing Solutions',
                'meta_description' => 'Find the perfect laptop for work, gaming, or everyday use.',
            ],
            [
                'name' => 'Men\'s Clothing',
                'description' => 'Fashion and apparel for men',
                'parent_name' => 'Clothing',
                'status' => 'active',
                'sort_order' => 1,
                'meta_title' => 'Men\'s Clothing - Fashion for Men',
                'meta_description' => 'Discover stylish and comfortable clothing options for men.',
            ],
            [
                'name' => 'Women\'s Clothing',
                'description' => 'Fashion and apparel for women',
                'parent_name' => 'Clothing',
                'status' => 'active',
                'sort_order' => 2,
                'meta_title' => 'Women\'s Clothing - Fashion for Women',
                'meta_description' => 'Explore trendy and elegant clothing collections for women.',
            ],
            [
                'name' => 'Furniture',
                'description' => 'Home furniture and decor',
                'parent_name' => 'Home & Garden',
                'status' => 'active',
                'sort_order' => 1,
                'meta_title' => 'Furniture - Home Decor and Furnishing',
                'meta_description' => 'Transform your home with our quality furniture collection.',
            ],
            [
                'name' => 'Garden Tools',
                'description' => 'Tools and equipment for gardening',
                'parent_name' => 'Home & Garden',
                'status' => 'active',
                'sort_order' => 2,
                'meta_title' => 'Garden Tools - Gardening Equipment',
                'meta_description' => 'Find the right tools to maintain and beautify your garden.',
            ],
        ];

        foreach ($subcategories as $subcategoryData) {
            $parentCategory = $createdCategories[$subcategoryData['parent_name']];
            unset($subcategoryData['parent_name']);
            
            $subcategoryData['id'] = Str::uuid();
            $subcategoryData['slug'] = Str::slug($subcategoryData['name']);
            $subcategoryData['parent_id'] = $parentCategory->id;
            
            ProductCategory::create($subcategoryData);
        }

        $this->command->info('Product category seeder completed successfully.');
    }
}