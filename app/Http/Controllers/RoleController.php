<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Role;

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
            'name' => 'string|required|unique:roles,name',
        ]);
        $validateData['guard_name'] = $validateData['guard_name'] ?? 'web';

        $role = Role::create($validateData);

        if ($role) {
            return to_route('role.view')->with('success', 'Data Telah Ditambahkan');
        } else {
            return to_route('role.view')->with('failed', 'Data Gagal Ditambahkan');
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
            'name' => 'string|required|unique:roles,name',
        ]);

        $validateData['guard_name'] = $validateData['guard_name'] ?? 'web';
        $role->update($validateData);

        if ($role) {
            return to_route('role.view')->with('success', 'Data Berhasil Diubah');
        } else {
            return to_route('role.view')->with('failed', 'Data Gagal Diubah');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();

        if ($role) {
            return to_route('role.view')->with('success', 'Data Telah Dihapus');
        } else {
            return to_route('role.view')->with('failed', 'Data Gagal Dihapus');
        }
    }

    public function addPermissionToRole(Role $role)
    {
        $permission = Permission::get();
        $rolePermissions = DB::table('role_has_permissions')
                        ->where('role_has_permissions.role_id', $role->uuid)
                        ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
                        ->all();

        return view('addRolePermission.create', ['role' => $role, 'permissions' => $permission, 'rolePermissions' => $rolePermissions]);
    }

    public function storePermissionToRole(Request $request, Role $role)
    {
        // Debugging output
        //dd($request->all());
    
        $request->validate([
            'permission' => 'required|array',
        ]);
    
        $role->syncPermissions($request->permission);
    
        return redirect()->route('addRolePermission.create', $role->uuid)
                         ->with('success', 'Permissions successfully updated.');
    }
}
