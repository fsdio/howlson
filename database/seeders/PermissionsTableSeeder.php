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
        //permission users
        Permission::create(['id' => Str::uuid(), 'name' => 'users index', 'guard_name' => 'web']);
        Permission::create(['id' => Str::uuid(), 'name' => 'users create', 'guard_name' => 'web']);
        Permission::create(['id' => Str::uuid(), 'name' => 'users edit', 'guard_name' => 'web']);
        Permission::create(['id' => Str::uuid(), 'name' => 'users delete', 'guard_name' => 'web']);

        //permission roles
        Permission::create(['id' => Str::uuid(), 'name' => 'roles index', 'guard_name' => 'web']);
        Permission::create(['id' => Str::uuid(), 'name' => 'roles create', 'guard_name' => 'web']);
        Permission::create(['id' => Str::uuid(), 'name' => 'roles edit', 'guard_name' => 'web']);
        Permission::create(['id' => Str::uuid(), 'name' => 'roles delete', 'guard_name' => 'web']);

        //permission permissions
        Permission::create(['id' => Str::uuid(), 'name' => 'permissions index', 'guard_name' => 'web']);
        Permission::create(['id' => Str::uuid(), 'name' => 'permissions create', 'guard_name' => 'web']);
        Permission::create(['id' => Str::uuid(), 'name' => 'permissions edit', 'guard_name' => 'web']);
        Permission::create(['id' => Str::uuid(), 'name' => 'permissions delete', 'guard_name' => 'web']);
    }
}
