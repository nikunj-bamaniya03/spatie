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
            <div class="row mb-3">
                <!-- Name Search -->
                <div class="col-md-4">
                    <input type="text" id="name_filter" class="form-control"
                        placeholder="Search Name">
                </div>

                <!-- Created At Date Range -->
                <div class="col-md-4 d-flex gap-2">
                    <input type="date" id="from_date" class="form-control">
                    <input type="date" id="to_date" class="form-control">
                </div>

                <!-- Role Multi Select -->
                <div class="col-md-4">
                    <select id="role_filter" class="form-select" multiple placeholder="Select Role">
                        @foreach($roles as $role)
                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-alert />
                <x-error />

                <div class="p-6 text-gray-900">
                    <table class="table table-striped" style="width:100%" id="data-table">
                        <thead class="bg-gray-100">
                            <tr class="border-b">
                                <th class="px-6 py-3 text-left" style="width:30px">#</th>
                                <th class="px-6 py-3 text-left" style="width:130px">Name</th>
                                <th class="px-6 py-3 text-left" style="width:260px">Email</th>
                                <th class="px-6 py-3 text-left" style="width:80px">Roles</th>
                                <th class="px-6 py-3 text-left" style="width:80px">Created At</th>
                                <!-- <th class="px-6 py-3 text-left">Permissions</th> -->
                                <th class="px-6 py-3" style="width:20px;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @push('scripts')
    <script>
        const destroyUserUrl = "{{ route('users.destroy', ':id') }}";
    </script>

    <!-- SweetAlert CDN (CORRECT) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Public JS file -->
    <script src="{{ asset('assets/admin/js/userDelete.js') }}"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>


    <!-- multi-select dropdown -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script src="{{ asset('assets/admin/js/multi-select.js') }}"></script>

    <script>
        $(document).ready(function() {

            let table = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.list') }}",
                    data: function(d) {
                        d.name = $('#name_filter').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                        d.roles = $('#role_filter').val(); // array
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'roles',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                order: [
                    [1, 'asc']
                ],
                pageLength: 3,
                lengthMenu: [3, 10, 50, 100]
            });

            // Trigger reload on filters
            $('#name_filter, #from_date, #to_date').on('keyup change', function() {
                table.draw();
            });

            $('#role_filter').on('change', function() {
                table.draw();
            });

        });
    </script>


    @endpush
</x-app-layout>