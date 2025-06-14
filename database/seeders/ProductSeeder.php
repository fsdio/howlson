<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories
        $smartphoneCategory = ProductCategory::where('name', 'Smartphones')->first();
        $laptopCategory = ProductCategory::where('name', 'Laptops')->first();
        $menClothingCategory = ProductCategory::where('name', 'Men\'s Clothing')->first();
        $womenClothingCategory = ProductCategory::where('name', 'Women\'s Clothing')->first();
        $furnitureCategory = ProductCategory::where('name', 'Furniture')->first();
        $gardenToolsCategory = ProductCategory::where('name', 'Garden Tools')->first();

        if (!$smartphoneCategory) {
            $this->command->warn('Product categories not found. Please run ProductCategorySeeder first.');
            return;
        }

        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => '<p>The latest iPhone with advanced features and stunning design.</p><ul><li>A17 Pro chip</li><li>Pro camera system</li><li>Titanium design</li><li>USB-C connector</li></ul>',
                'short_description' => 'Latest iPhone with A17 Pro chip and titanium design.',
                'sku' => 'IPH15PRO-128',
                'price' => 999.00,
                'sale_price' => 899.00,
                'stock_quantity' => 50,
                'weight' => 0.187,
                'dimensions' => '146.6 x 70.6 x 8.25 mm',
                'category_id' => $smartphoneCategory->id,
                'status' => 'active',
                'is_featured' => true,
                'meta_title' => 'iPhone 15 Pro - Latest Apple Smartphone',
                'meta_description' => 'Get the latest iPhone 15 Pro with advanced A17 Pro chip and titanium design.',
            ],
            [
                'name' => 'Samsung Galaxy S24 Ultra',
                'description' => '<p>Premium Android smartphone with S Pen and advanced camera system.</p><ul><li>Snapdragon 8 Gen 3</li><li>200MP camera</li><li>S Pen included</li><li>5000mAh battery</li></ul>',
                'short_description' => 'Premium Android smartphone with S Pen and 200MP camera.',
                'sku' => 'SGS24U-256',
                'price' => 1199.00,
                'sale_price' => null,
                'stock_quantity' => 30,
                'weight' => 0.232,
                'dimensions' => '162.3 x 79.0 x 8.6 mm',
                'category_id' => $smartphoneCategory->id,
                'status' => 'active',
                'is_featured' => true,
                'meta_title' => 'Samsung Galaxy S24 Ultra - Premium Android Phone',
                'meta_description' => 'Experience the power of Samsung Galaxy S24 Ultra with S Pen and advanced features.',
            ],
            [
                'name' => 'MacBook Pro 14-inch',
                'description' => '<p>Powerful laptop for professionals with M3 Pro chip.</p><ul><li>M3 Pro chip</li><li>14-inch Liquid Retina XDR display</li><li>Up to 22 hours battery life</li><li>Advanced camera and audio</li></ul>',
                'short_description' => 'Professional laptop with M3 Pro chip and stunning display.',
                'sku' => 'MBP14-M3PRO',
                'price' => 1999.00,
                'sale_price' => 1799.00,
                'stock_quantity' => 25,
                'weight' => 1.6,
                'dimensions' => '312.6 x 221.2 x 15.5 mm',
                'category_id' => $laptopCategory->id,
                'status' => 'active',
                'is_featured' => true,
                'meta_title' => 'MacBook Pro 14-inch - Professional Laptop',
                'meta_description' => 'Get the powerful MacBook Pro 14-inch with M3 Pro chip for professional work.',
            ],
            [
                'name' => 'Dell XPS 13',
                'description' => '<p>Ultra-portable laptop with premium design and performance.</p><ul><li>Intel Core i7 processor</li><li>13.4-inch InfinityEdge display</li><li>Premium materials</li><li>Long battery life</li></ul>',
                'short_description' => 'Ultra-portable laptop with premium design and Intel Core i7.',
                'sku' => 'DELLXPS13-I7',
                'price' => 1299.00,
                'sale_price' => null,
                'stock_quantity' => 40,
                'weight' => 1.27,
                'dimensions' => '295.7 x 199.04 x 14.8 mm',
                'category_id' => $laptopCategory->id,
                'status' => 'active',
                'is_featured' => false,
                'meta_title' => 'Dell XPS 13 - Ultra-portable Laptop',
                'meta_description' => 'Experience premium performance with the ultra-portable Dell XPS 13 laptop.',
            ],
            [
                'name' => 'Classic Cotton T-Shirt',
                'description' => '<p>Comfortable cotton t-shirt perfect for everyday wear.</p><ul><li>100% cotton material</li><li>Available in multiple colors</li><li>Regular fit</li><li>Machine washable</li></ul>',
                'short_description' => 'Comfortable 100% cotton t-shirt for everyday wear.',
                'sku' => 'TSHIRT-COT-M',
                'price' => 29.99,
                'sale_price' => 24.99,
                'stock_quantity' => 100,
                'weight' => 0.2,
                'dimensions' => 'M: 71cm length',
                'category_id' => $menClothingCategory->id,
                'status' => 'active',
                'is_featured' => false,
                'meta_title' => 'Classic Cotton T-Shirt for Men',
                'meta_description' => 'Shop comfortable cotton t-shirts perfect for casual and everyday wear.',
            ],
            [
                'name' => 'Elegant Summer Dress',
                'description' => '<p>Beautiful summer dress perfect for special occasions.</p><ul><li>Lightweight fabric</li><li>Elegant design</li><li>Available in multiple sizes</li><li>Perfect for summer events</li></ul>',
                'short_description' => 'Elegant summer dress perfect for special occasions.',
                'sku' => 'DRESS-SUM-M',
                'price' => 89.99,
                'sale_price' => null,
                'stock_quantity' => 60,
                'weight' => 0.3,
                'dimensions' => 'M: 120cm length',
                'category_id' => $womenClothingCategory->id,
                'status' => 'active',
                'is_featured' => false,
                'meta_title' => 'Elegant Summer Dress for Women',
                'meta_description' => 'Look stunning in our elegant summer dress perfect for any special occasion.',
            ],
            [
                'name' => 'Modern Office Chair',
                'description' => '<p>Ergonomic office chair designed for comfort and productivity.</p><ul><li>Ergonomic design</li><li>Adjustable height</li><li>Lumbar support</li><li>Premium materials</li></ul>',
                'short_description' => 'Ergonomic office chair with lumbar support and adjustable height.',
                'sku' => 'CHAIR-OFF-ERG',
                'price' => 299.99,
                'sale_price' => 249.99,
                'stock_quantity' => 35,
                'weight' => 15.5,
                'dimensions' => '65 x 65 x 110-120 cm',
                'category_id' => $furnitureCategory->id,
                'status' => 'active',
                'is_featured' => true,
                'meta_title' => 'Modern Ergonomic Office Chair',
                'meta_description' => 'Enhance your workspace with our comfortable and ergonomic office chair.',
            ],
            [
                'name' => 'Professional Garden Shears',
                'description' => '<p>High-quality garden shears for precise cutting and trimming.</p><ul><li>Stainless steel blades</li><li>Comfortable grip</li><li>Durable construction</li><li>Perfect for pruning</li></ul>',
                'short_description' => 'Professional garden shears with stainless steel blades.',
                'sku' => 'SHEARS-PRO-SS',
                'price' => 49.99,
                'sale_price' => null,
                'stock_quantity' => 80,
                'weight' => 0.5,
                'dimensions' => '25 cm length',
                'category_id' => $gardenToolsCategory->id,
                'status' => 'active',
                'is_featured' => false,
                'meta_title' => 'Professional Garden Shears - Stainless Steel',
                'meta_description' => 'Get precise cuts with our professional garden shears featuring stainless steel blades.',
            ],
        ];

        foreach ($products as $productData) {
            $productData['id'] = Str::uuid();
            $productData['slug'] = Str::slug($productData['name']);
            
            Product::create($productData);
        }

        $this->command->info('Product seeder completed successfully.');
    }
}