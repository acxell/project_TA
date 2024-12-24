<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = DB::table('roles')->get();

        return view('role.view', ['roles' => $role]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = DB::table('roles')->get();

        return view('role.create', ['roles' => $role]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
            'name' => 'required|string|unique:roles,name',
        ]);
        $validateData['guard_name'] = $validateData['guard_name'] ?? 'web';

        $role = Role::create($validateData);

        if ($role) {
            return to_route('role.view')->with('success', 'Role Telah Ditambahkan');
        } else {
            return to_route('role.view')->with('failed', 'Role Gagal Ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {

        return view('role.edit', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validateData = $request->validate([
           'name' => [
                'required',
                'string',
                Rule::unique('roles')->ignore($role->id),
            ],
        ]);

        $validateData['guard_name'] = $validateData['guard_name'] ?? 'web';
        $role->update($validateData);

        if ($role) {
            return to_route('role.view')->with('success', 'Role Berhasil Diubah');
        } else {
            return to_route('role.view')->with('failed', 'Role Gagal Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        if ($role) {
            return to_route('role.view')->with('success', 'Role Telah Dihapus');
        } else {
            return to_route('role.view')->with('failed', 'Role Gagal Dihapus');
        }
    }

    public function addPermissionToRole(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_id', $role->id)
            ->pluck('permission_id')
            ->toArray();

        return view('addRolePermission.create', compact('role', 'permissions', 'rolePermissions'));
    }

    public function storePermissionToRole(Request $request, Role $role)
    {
        $request->validate([
            'permission' => 'nullable|array',
        ]);

        $role->syncPermissions($request->input('permission', []));
    
        return redirect()->route('role.view')->with('success', 'Permission Berhasil Diperbarui');
    }
    
}
