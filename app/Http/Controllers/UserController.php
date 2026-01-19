<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    // public function builderIndex(UsersDataTable $dataTable) : View
    // {
    //     return $dataTable->render('users.yajra-index'); // new blade view
    // }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        // Get the ID of the currently authenticated user
        $currentUserId = Auth::id();

        // Remove the current user form list of user
        $users = User::latest()
            ->where('id', '!=', $currentUserId)->get();
        // return view('user.list', compact('users'));

        $roles = Role::select('id', 'name')->get();

        return view('user.list', compact('users', 'roles'));
    }

    /**
     * Display listing of the user in yajra data-table
     */
    public function listTable(Request $request) : JsonResponse 
    {
        if ($request->ajax()) {

            $currentUserId = Auth::id();

            $users = User::with('roles')
                ->where('id', '!=', $currentUserId);

            // Name Search
            if ($request->filled('name')) {
                $users->where('name', 'like', '%' . $request->name . '%');
            }

            // Date Range Filter
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $users->whereBetween('created_at', [
                    $request->from_date . ' 00:00:00',
                    $request->to_date . ' 23:59:59'
                ]);
            }

            // Role Multi Select Filter
            if ($request->filled('roles')) {
                $users->whereHas('roles', function ($q) use ($request) {
                    $q->whereIn('name', $request->roles);
                });
            }

            return DataTables::of($users)
                ->addIndexColumn()

                ->editColumn('created_at', function ($user) {
                    return $user->created_at
                        ? $user->created_at->format('Y-m-d')
                        : '';
                })

                ->addColumn('roles', function ($user) {
                    return $user->roles->map(
                        fn($role) =>
                        '<span class="bg-blue-100 px-2 py-1 rounded text-xs mr-1">'
                            . $role->name .
                            '</span>'
                    )->implode('');
                })

               
                ->addColumn('action', function ($user) {
                    $buttons = '';

                    if (auth()->user()->can('edit-user')) {
                        $buttons .= '<a href="' . route('users.edit', encrypt($user->id)) . '" class="text-blue-600 mr-2">
                        <i class="fas fa-edit"></i>
                    </a>';
                    }

                    if (auth()->user()->can('delete-user')) {
                        $buttons .= '<a href="javascript:void(0)"
                        data-id="' . encrypt($user->id) . '"
                        class="delete-user text-red-600">
                        <i class="fas fa-trash"></i>
                    </a>';
                    }

                    return $buttons;
                })

                ->rawColumns(['roles', 'action'])
                ->make(true);
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $this->authorize('create', User::class);

        $roles = Role::orderBy('name')->get();
        return view('user.create', compact('roles'));
    }

    /**
     * when user can registered
     */
    public function store(Request $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $user = User::create($request->only('name', 'email') + ['password' => Hash::make($request->password)]);

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
        $this->authorize('update', User::class);

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
        $this->authorize('update', User::class);

        $decryptedId = decrypt($id);
        $user = User::findOrFail($decryptedId);

        // Update basic info
        $user->update($request->only('name', 'email') + ['password' => Hash::make($request->password)]);

        // Sync roles
        $user->syncRoles($request->roles ?? []);

        // Sync permissions
        $user->syncPermissions($request->permissions ?? []);

        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        // decrypt the ID first
        $decryptedId = decrypt($id);

        $user = User::findOrFail($decryptedId);
        $user->delete();

        return response()->json([
            'status' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}
