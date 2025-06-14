<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class PermissionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    /**
     * Display a listing of permissions.
     */
    public function index()
    {
        $permissions = Permission::with('roles')->get();
        
        return Inertia::render('Admin/Permissions/Index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create()
    {
        $roles = Role::all();
        
        return Inertia::render('Admin/Permissions/Create', [
            'roles' => $roles
        ]);
    }

    /**
     * Store a newly created permission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ]);

        $permission = Permission::create([
            'id' => Str::uuid(),
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        if ($request->has('roles')) {
            foreach ($request->roles as $roleId) {
                $role = Role::find($roleId);
                if ($role) {
                    $role->givePermissionTo($permission);
                }
            }
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit(Permission $permission)
    {
        $roles = Role::all();
        $permissionRoles = $permission->roles->pluck('id')->toArray();
        
        return Inertia::render('Admin/Permissions/Edit', [
            'permission' => $permission,
            'roles' => $roles,
            'permissionRoles' => $permissionRoles
        ]);
    }

    /**
     * Update the specified permission.
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission->id)],
            'roles' => 'array',
            'roles.*' => 'exists:roles,id'
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        // Remove permission from all roles first
        foreach (Role::all() as $role) {
            $role->revokePermissionTo($permission);
        }

        // Assign permission to selected roles
        if ($request->has('roles')) {
            foreach ($request->roles as $roleId) {
                $role = Role::find($roleId);
                if ($role) {
                    $role->givePermissionTo($permission);
                }
            }
        }

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission berhasil diperbarui.');
    }

    /**
     * Remove the specified permission.
     */
    public function destroy(Permission $permission)
    {
        // Remove permission from all roles
        foreach (Role::all() as $role) {
            $role->revokePermissionTo($permission);
        }

        $permission->delete();

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission berhasil dihapus.');
    }
}