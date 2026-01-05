<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class UserController extends Controller
{
    // public function __construct()
    // {
    //     $this->authorizeResource(User::class, 'user');
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        // Get the ID of the currently authenticated user
        $currentUserId = Auth::id();

        // Remove the current user form list of user
        $users = User::latest()
            ->where('id', '!=', $currentUserId)->get();

        return view('user.list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::orderBy('name')->get();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * when user can registered
     */
    public function store(Request $request): RedirectResponse
    {
        $user = User::create($request->only('name','email') + ['password' => Hash::make($request->password)]);

        // assign EXACT selected role
        $role = Role::findById($request->role_id);
        $user->assignRole($role->name);

        return redirect()->route('users.index')->with('success', 'User added successfully');
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
        $user = User::findOrFail($decryptedId);

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
    public function update(Request $request, string $id): RedirectResponse
    {
        $decryptedId = decrypt($id);
        $user = User::findOrFail($decryptedId);

        // Update basic info
        $user->update($request->only('name','email') + ['password' => Hash::make($request->password)]);

        // Sync roles
        $user->syncRoles($request->roles ?? []);

        // Sync permissions
        $user->syncPermissions($request->permissions ?? []);

        return redirect() ->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $decryptedId = decrypt($id);
        $user = User::findOrFail($decryptedId);
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
