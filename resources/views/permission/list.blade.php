<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Permission List') }}
            </h2>
            <a href="{{ route('permissions.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Add Permission</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-alert />
                <x-error />
                <div class="p-6 text-gray-900">
                    <table class="datatable w-full">
                        <thead class="bg-gray-100">
                            <tr class="border-b">
                                <th class="px-6 py-3 text-left" width="60">#</th>
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left" width="180">Created</th>
                                <th class="px-6 py-3 text-center" width="180">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white-100">
                            @if($permissions->isNotEmpty())
                                @foreach ($permissions as $permission)
                                    <tr class="border-b">
                                        <td class="px-6 py-3 text-left">{{ $permission->id }}</td>
                                        <td class="px-6 py-3 text-left">{{ $permission->name }}</td>
                                        <td class="px-6 py-3 text-left">
                                            {{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}
                                        </td>
                                        
                                        <td class="px-6 py-3 text-center">
                                            <div class="flex justify-center gap-2">
                                                @can('edit-permission')
                                                <a href="{{ route('permissions.edit',$permission->id) }}" 
                                                class="bg-slate-600 text-sm rounded-md text-white px-3 py-1 hover:bg-slate-500">
                                                Edit</a>
                                                @endcan

                                                @can('delete-permission')
                                                <a href="#" data-id="{{ $permission->id }}" 
                                                class="delete-permission bg-red-600 text-sm rounded-md text-white px-3 py-1 hover:bg-red-500">
                                                Delete</a>
                                                @endcan
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Define dynamic route variable -->
    @push('scripts')
    <script>
        var permissionDestroyUrl = "{{ route('permissions.destroy', ':id') }}";
    </script>

    <!-- public JS file -->
    <script src="{{ asset('assets/admin/js/permission.js') }}"></script>
    @endpush
</x-app-layout>
