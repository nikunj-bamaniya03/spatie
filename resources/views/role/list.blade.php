<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Role List') }}
            </h2>
            <!-- <a href="{{ route('roles.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Add Role</a> -->
            @can('add-role')
            <a href="{{ route('roles.create') }}"
                class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">
                Add Role
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

                    <table class="table table-striped" style="width:100%" id="data-table">
                        <thead class="bg-gray-100">
                            <tr class="border-b">
                                <th class="px-6 py-3 text-left" style="width:60">#</th>
                                <th class="px-6 py-3 text-left" style="width:100">Role Name</th>
                                <!-- <th class="px-6 py-3 text-left">Permission</th> -->
                                <!-- <th class="px-6 py-3 text-left" width="100">Created</th> -->
                                <th class="px-6 py-3" style="width:80px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @push('scripts')
    <script>
        const destroyRoleUrl = "{{ route('roles.destroy', ':id') }}";
    </script>

    <!-- SweetAlert CDN (CORRECT) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Public JS file -->
    <script src="{{ asset('assets/admin/js/role.js') }}"></script>

    <!-- DataTables JS -->
    <!-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> -->
    <!-- DataTables CSS -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> -->



    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {

            const table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('roles.list') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });
    </script>
    @endpush


</x-app-layout>