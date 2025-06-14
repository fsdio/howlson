<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Users permissions
            'users index',
            'users create',
            'users edit',
            'users delete',
            
            // Roles permissions
            'roles index',
            'roles create',
            'roles edit',
            'roles delete',
            
            // Permissions permissions
            'permissions index',
            'permissions create',
            'permissions edit',
            'permissions delete',
            
            // Blog permissions
            'blogs index',
            'blogs create',
            'blogs edit',
            'blogs delete',
            
            // Product permissions
            'products index',
            'products create',
            'products edit',
            'products delete',
            
            // Product Category permissions
            'product-categories index',
            'product-categories create',
            'product-categories edit',
            'product-categories delete',
            
            // Dashboard permission
            'admin dashboard',
        ];
        
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission],
                [
                    'id' => Str::uuid(),
                    'guard_name' => 'web'
                ]
            );
        }
    }
}
