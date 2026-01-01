<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('User List') }}
            </h2>
            @can ('add-user')
            <a href="{{ route('users.create') }}"
               class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">
                Add User
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-alert />
                <x-error />

                <div class="p-6 text-gray-900">
                    <table class="datatable w-full" id="data-table">
                        <thead class="bg-gray-100">
                            <tr class="border-b">
                                <th class="px-6 py-3 text-left" style="width:30px">#</th>
                                <th class="px-6 py-3 text-left" style="width:130px">Name</th>
                                <th class="px-6 py-3 text-left" style="width:260px">Email</th>
                                <th class="px-6 py-3 text-left" style="width:80px">Roles</th>
                                <!-- <th class="px-6 py-3 text-left">Permissions</th> -->
                                <th class="px-6 py-3" style="width:20px;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($users as $user)
                            <tr id="row-{{ $user->id }}" class="border-b">
                                <td class="px-6 py-2">{{ $loop->iteration }}</td>
                                <td class="px-6 py-2">{{ $user->name }}</td>
                                <td class="px-6 py-2">{{ $user->email }}</td>

                                <td class="px-6 py-2">
                                    @foreach($user->roles as $role)
                                        <span class="bg-blue-100 px-2 py-1 rounded text-xs">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>

                                <!-- <td class="px-6 py-2">
                                    @foreach($user->getAllPermissions() as $permission)
                                        <span class="bg-green-100 px-2 py-1 rounded text-xs mr-2">
                                            {{ $permission->name }}
                                        </span>
                                    @endforeach
                                </td> -->

                                <td class="px-6 py-2 text-center">
                                    <div class="flex justify-center gap-2">
                                        @can('edit-user')
                                        <a href="{{ route('users.edit', encrypt($user->id)) }}"
                                            class="text-blue-600 hover:text-blue-800 transition">
                                            <i class="fas fa-edit text-lg"></i>
                                        </a> 
                                        @endcan

                                        @can('delete-user')
                                        <a href="#" data-id="{{ encrypt($user->id) }}"
                                           class="delete-user text-red-600 hover:text-red-800 transition">
                                            <i class="fas fa-trash text-lg"></i>
                                        </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    @push('scripts')
    <script>
        const destroyUserUrl = "{{ route('users.destroy', ':id') }}";
    </script>

    <!-- SweetAlert CDN (CORRECT) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Public JS file -->
    <script src="{{ asset('assets/admin/js/userDelete.js') }}"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    @endpush

</x-app-layout>
