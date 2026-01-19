<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ __('Yajra User List') }}
        </h2>
    </x-slot>

    <!-- FontAwesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- FILTERS --}}
            <div class="row mb-3">
                <div class="col-md-4">
                    <input type="text" id="name_filter"
                        class="form-control"
                        placeholder="Search Name">
                </div>

                <div class="col-md-4 d-flex gap-2">
                    <input type="date" id="from_date" class="form-control">
                    <input type="date" id="to_date" class="form-control">
                </div>

                <div class="col-md-4">
                    <select id="role_filter" class="form-select" multiple>
                        @foreach(\Spatie\Permission\Models\Role::all() as $role)
                        <option value="{{ $role->name }}">
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- TABLE (BUILDER GENERATED) --}}
            {!! $html->table(['class' => 'table table-striped table-bordered w-full']) !!}

        </div>
    </div>

    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
    
    {{-- SCRIPTS --}}
    {!! $html->scripts() !!}
    
    
    <!-- multi-select dropdown -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script src="{{ asset('assets/admin/js/multi-select.js') }}"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    @push('scripts')
    <script>
        $('#name_filter, #from_date, #to_date').on('keyup change', function() {
            $('#users-table').DataTable().draw();
        });

        $('#role_filter').on('change', function() {
            $('#users-table').DataTable().draw();
        });
    </script>
    @endpush
</x-app-layout>

<!-- DataTables Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
