<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Str;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permission = DB::table('permissions')->get();

        return view('permission.view',['permissions' => $permission]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permission = DB::table('permissions')->get();

        return view('permission.create',['permissions' => $permission]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
        'name' => 'string|required|unique:permissions,name',
        ]);
        $validateData['guard_name'] = $validateData['guard_name'] ?? 'web';

        $permission = Permission::create($validateData);

        if ($permission) {
            return to_route('permission.view')->with('success', 'Data Telah Ditambahkan');
        }
        else {
            return to_route('permission.view')->with('failed', 'Data Gagal Ditambahkan');
        }
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permission $permission)
    {

        return view('permission.edit',['permission' => $permission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permission $permission)
    {
        $validateData = $request->validate([
            'name' => 'string|required|unique:permissions,name',
            ]);
    
            $validateData['guard_name'] = $validateData['guard_name'] ?? 'web';
            $permission->update($validateData);
    
            if ($permission) {
                return to_route('permission.view')->with('success', 'Data Berhasil Diubah');
            }
            else {
                return to_route('permission.view')->with('failed', 'Data Gagal Diubah');
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
    
            if ($permission) {
                return to_route('permission.view')->with('success', 'Data Telah Dihapus');
            }
            else {
                return to_route('permission.view')->with('failed', 'Data Gagal Dihapus');
            }
    }
}