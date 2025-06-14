<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(
            ['name' => 'admin'],
            [
                'id' => Str::uuid(),
                'guard_name' => 'web'
            ]
        );
        
        Role::firstOrCreate(
            ['name' => 'user'],
            [
                'id' => Str::uuid(),
                'guard_name' => 'web'
            ]
        );
    }
}
