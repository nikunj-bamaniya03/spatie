<!-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif -->


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Role') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="font-medium">Role Name</label>
                            <input type="text"
                                name="name"
                                value="{{ old('name', $role->name) }}"
                                class="border rounded w-1/2">
                            @error('name')
                            <p class="text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-4 gap-2">
                            @foreach($permissions as $permission)
                            <label class="flex items-center gap-2">
                                <input type="checkbox"
                                    name="permission[]"
                                    value="{{ $permission->name }}"
                                    {{ in_array($permission->name, $hasPermissions) ? 'checked' : '' }}>
                                {{ $permission->name }}
                            </label>
                            @endforeach
                        </div>

                        <button class="mt-4 bg-slate-700 text-white px-5 py-2 rounded">
                            Update Role
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>