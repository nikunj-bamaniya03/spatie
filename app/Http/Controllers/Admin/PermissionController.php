<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddPermissonRequest;
use App\Http\Requests\StorePermissionRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::orderBy('created_at','DESC')->get();
        return view('permission.list',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AddPermissonRequest $request)
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
    public function edit(string $id)
    {
        $permission = Permission::findorFail($id);
        return view('permission.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePermissionRequest $request, string $id)
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
