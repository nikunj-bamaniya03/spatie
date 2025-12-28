<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPermissonRequest;
use App\Http\Requests\StorePermissionRequest;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class PermissionController extends Controller implements HasMiddleware
{
    public static function middleware(): Array
    {
        return [
            new Middleware('permission:view-permission', only: ['index']),
            new Middleware('permission:add-permission', only: ['create']),
            new Middleware('permission:edit-permission', only: ['edit']),
            new Middleware('permission:delete-permission', only: ['destroy'])

        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $permissions = Permission::orderBy('created_at','DESC')->get();
        return view('permission.list',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddPermissonRequest $request): RedirectResponse
    {
        Permission::create([
        'name' => $request->name,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission added successfully');
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
        $permission = Permission::findorFail($id);
        return view('permission.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePermissionRequest $request, string $id): RedirectResponse
    {
        $permission = Permission::findOrFail($id);

    $permission->update([
        'name' => $request->name,
    ]);

    return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json([
            'status' => true,
            'message' => 'Permission deleted successfully'
        ]);
    }
}
