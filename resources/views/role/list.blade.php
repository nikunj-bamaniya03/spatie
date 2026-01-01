<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Role List') }}
            </h2>
            <a href="{{ route('roles.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Add Role</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-alert />
                <x-error />
                <div class="p-6 text-gray-900">

                    <table id="data-table" class="datatable w-full">
                        <thead class="bg-gray-100">
                            <tr class="border-b">
                                <th class="px-6 py-3 text-left" width="60">#</th>
                                <th class="px-6 py-3 text-left" width="100">Name</th>
                                <th class="px-6 py-3 text-left">Permission</th>
                                <th class="px-6 py-3 text-left" width="100">Created</th>
                                <th class="px-6 py-3 text-center" width="80">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white-100">
                            @if($roles->isNotEmpty())
                            @foreach ($roles as $role)
                            <tr class="border-b">
                                <td class="px-6 py-3">{{ $loop->iteration }}</td>
                                <td class="px-6 py-3">{{ $role->name }}</td>
                                <td class="px-6 py-3">
                                    {{ $role->permissions->pluck('name')->implode(', ') ?: '—' }}
                                </td>
                                <td class="px-6 py-3">
                                    {{ $role->created_at->format('d M, Y') }}
                                </td>
                                <td class="mt-4 flex text-center gap-8">
                                    <div class="flex justify-center gap-2">
                                        @can('edit-role')
                                        <a href="{{ route('roles.edit', encrypt($role->id)) }}"
                                            class="text-blue-600 hover:text-blue-800 transition">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a>
                                        @endcan 

                                        @can('delete-role')
                                        <a href="#" data-id="{{ encrypt($role->id) }}"
                                            class="delete-role text-red-600 hover:text-red-800 transition">
                                            <i class="fas fa-trash text-lg"></i>
                                        </a>
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    @push('scripts')
    <script>
        const destroyRoleUrl = "{{ route('roles.destroy', ':id') }}";
    </script>

    <!-- SweetAlert CDN (CORRECT) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Public JS file -->
    <script src="{{ asset('assets/admin/js/role.js') }}"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    @endpush


</x-app-layout>