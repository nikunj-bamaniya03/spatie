<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UpdateRoleRequest;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('role.list', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('role.create', compact('permissions'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request)
    {
        // 1. Role create
        $role = Role::create([
            'name' => $request->name,
        ]);

        // 2. Assign permissions (if selected)
        if ($request->filled('permission')) {
            $role->syncPermissions($request->permission);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $role = Role::findOrFail($id);

        // existing permissions of this role
        $hasPermissions = $role->permissions->pluck('name')->toArray();

        // get all permissions
        $permissions = Permission::orderBy('name', 'ASC')->get();

        return view('role.edit', compact(
            'role',
            'permissions',
            'hasPermissions'
        ));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, string $id)
    {
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $request->name,
        ]);

        // Sync permissions
        $role->syncPermissions($request->permission ?? []);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully');
    }

    //
    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'status' => true,
            'message' => 'Role deleted successfully'
        ]);
    }

}
