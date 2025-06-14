<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or get admin user
        $user = User::firstOrCreate(
            ['email' => 'izaldev@gmail.com'],
            [
                'id' => Str::uuid(),
                'name' => 'syahrizaldev',
                'password' => bcrypt('asdf1234'),
            ]
        );

        // Get all permissions
        $permissions = Permission::all();

        // Get role admin
        $role = Role::where('name', 'admin')->first();

        if ($role) {
            // Assign all permissions to admin role
            $role->syncPermissions($permissions);

            // Assign admin role to user if not already assigned
            if (!$user->hasRole('admin')) {
                $user->assignRole($role);
            }
        }
        
        // Create a regular user role if it doesn't have permissions
        $userRole = Role::where('name', 'user')->first();
        if ($userRole && $userRole->permissions->isEmpty()) {
            // Give basic permissions to user role
            $basicPermissions = $permissions->whereIn('name', [
                'blogs index',
                'products index',
                'product-categories index'
            ]);
            $userRole->syncPermissions($basicPermissions);
        }
    }
}
