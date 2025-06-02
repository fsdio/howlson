<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolePermissionController extends Controller
{
    /**
     * Display roles page
     */
    public function roles()
    {
        $roles = Role::all();
        
        return Inertia::render('RolePermission/Roles', [
            'roles' => $roles
        ]);
    }

    /**
     * Display permissions page
     */
    public function permissions()
    {
        $permissions = Permission::all();
        
        return Inertia::render('RolePermission/Permissions', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        $user = auth()->user();
        $isAdmin = $user->hasRole('admin');
        
        return Inertia::render('RolePermission/IsAdmin', [
            'isAdmin' => $isAdmin,
            'user' => $user
        ]);
    }

    /**
     * Check if user is regular user
     */
    public function isUser()
    {
        $user = auth()->user();
        $isUser = $user->hasRole('user');
        
        return Inertia::render('RolePermission/IsUser', [
            'isUser' => $isUser,
            'user' => $user
        ]);
    }
}