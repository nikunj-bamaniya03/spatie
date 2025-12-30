<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Edit User</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white p-6 rounded shadow">

                <form action="{{ route('users.update', encrypt($user->id)) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-4">

                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}"readonly
                                class="mt-2 w-full border-gray-300 shadow-sm rounded-lg bg-gray-100 cursor-not-allowed focus:ring focus:ring-indigo-200"
                                placeholder="Enter full name">
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}"readonly
                                class="mt-2 w-full border-gray-300 shadow-sm rounded-lg bg-gray-100 cursor-not-allowed focus:ring focus:ring-indigo-200 readonly"
                                placeholder="Enter email address">
                        </div>
                    </div>


                    <!-- Roles -->
                    <div class="mb-4">
                        <label class="font-medium">Roles</label>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($roles as $role)
                            <label class="flex gap-2">
                                <input type="radio" name="roles[]" value="{{ $role->name }}"
                                    {{ in_array($role->name, $hasRoles) ? 'checked' : '' }}>
                                {{ $role->name }}
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Permissions -->
                    <div class="mb-4">
                        <label class="font-medium">Permissions</label>
                        <div class="grid grid-cols-4 gap-2">
                            @foreach($permissions as $permission)
                            <label class="flex gap-2">
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    {{ in_array($permission->name, $hasPermissions) ? 'checked' : '' }}>
                                {{ $permission->name }}
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <button class="bg-slate-700 text-white px-5 py-2 rounded">
                        Update User
                    </button>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>