<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Http\Requests\UpdateRoleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;
use Termwind\Components\Raw;

class RoleController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-role', only: ['index']),
            new Middleware('permission:add-role', only: ['create']),
            new Middleware('permission:edit-role', only: ['edit']),
            new Middleware('permission:delete-role', only: ['destroy'])

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $roles = Role::orderBy('name', 'ASC')->get();
        return view('role.list', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $permissions = Permission::orderBy('name', 'ASC')->get();
        return view('role.create', compact('permissions'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Role create
        $role = Role::create([
            'name' => $request->name,
        ]);

        // Assign permissions (if selected)
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
    public function edit(string $id): View
    {
        $decryptedId = decrypt($id);
        $role = Role::findOrFail($decryptedId);

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
    public function update(UpdateRoleRequest $request, string $id): RedirectResponse
    {
        $decryptedId = decrypt($id);
        $role = Role::findOrFail($decryptedId);
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

    public function destroy(string $id): JsonResponse
    {
        $decryptedId = decrypt($id);
        $role = Role::findOrFail($decryptedId);
        $role->delete();

        return response()->json([
            'status' => true,
            'message' => 'Role deleted successfully'
        ]);
    }

}
