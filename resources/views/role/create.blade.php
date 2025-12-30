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

                    <form id="create-role" action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div>
                            <label for="name" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter Role Name" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('name')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-4 mb-3">
                                @if($permissions->isNotEmpty())
                                @foreach($permissions as $permission)
                                <div class="mt-3">
                                    <input type="checkbox" class="rounded" name="permission[]" id="permission-{{ $permission->id }}" value="{{ $permission->name }}">
                                    <label for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                </div>
                                @endforeach
                                @endif
                            </div>
                        </div>

                        <button type="submit" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    {{-- jQuery Validation --}}
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    {{-- jQuery validation --}}
    <script src="{{ asset('assets/admin/js/validation.js') }}"></script>
    @endpush
</x-app-layout>