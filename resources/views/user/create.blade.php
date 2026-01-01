<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form id="create-user" action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div>
                            <!-- Name -->
                            <label for="name" class="text-lg font-medium">Name</label>
                            <div class="my-3">
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter Role Name" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('name')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- E-mail -->
                            <label for="email" class="text-lg font-medium">Email</label>
                            <div class="my-3">
                                <input type="text" name="email" value="{{ old('email') }}" placeholder="Enter Role email" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                @error('email')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                            <!-- Role -->
                            <div>
                                <label class="text-lg font-medium">Role</label>

                                <div class="my-3">
                                    <select name="role_id" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                        <option value="">-- Select Role --</option>

                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                        @endforeach
                                    </select>

                                    @error('role_id')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>
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