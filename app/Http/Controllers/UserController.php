<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-user', only: ['index']),
            // new Middleware('permission:add-user', only: ['create', 'store']),
            new Middleware('permission:edit-user', only: ['edit', 'update']),
            new Middleware('permission:delete-user', only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->get();
        return view('user.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // default role for new user
        // $user->assignRole('user'); 
        Auth::login($user);

        return redirect()->route('dashboard');
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
        $user = User::findOrFail($id);

        $roles = Role::orderBy('name')->get();
        $permissions = Permission::orderBy('name')->get();

        $hasRoles = $user->roles->pluck('name')->toArray();
        $hasPermissions = $user->getAllPermissions()->pluck('name')->toArray();

        return view('user.edit', compact(
            'user',
            'roles',
            'permissions',
            'hasRoles',
            'hasPermissions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // Update basic info
        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        // Sync roles
        $user->syncRoles($request->roles ?? []);

        // Sync permissions
        $user->syncPermissions($request->permissions ?? []);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
