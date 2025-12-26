<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product List') }}
            </h2>
            <a href="{{ route('products.create') }}" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">Add Product</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-alert />
                <x-error />
                <div class="p-6 text-gray-900">

                    <table class="w-full">
                        <thead class="bg-gray-100">
                            <tr class="border-b">
                                <th class="px-6 py-3 text-left" width="60">#</th>
                                <th class="px-6 py-3 text-left">Category</th>
                                <th class="px-6 py-3 text-left">Product</th>
                                <th class="px-6 py-3 text-left" width="180">Description</th>
                                <th class="px-6 py-3 text-left" width="180">Price</th>
                                <th class="px-6 py-3 text-left" width="180">Image</th>
                                <th class="px-6 py-3 text-center" width="180">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($products->isNotEmpty())
                            @foreach($products as $product)
                            <tr>
                                <td class="px-6 py-3 text-left" width="60">{{ $product->id }}</td>
                                <td class="px-6 py-3 text-left">{{ $product->category_id }}</td>
                                <td class="px-6 py-3 text-left">{{ $product->product_name }}</td>
                                <td class="px-6 py-3 text-left">{{ $product->product_description }}</td>
                                <td class="px-6 py-3 text-left">{{ $product->product_price }}</td>
                                <td class="px-6 py-3 text-left">{{ $product->product_image }}</td>

                                <td class="px-6 py-3 text-center">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('products.edit',$product->id)}}"
                                            class="bg-slate-600 text-sm rounded-md text-white px-3 py-1 hover:bg-slate-500">
                                            Edit</a>
                                        <a href="#" data-id=""
                                            class="delete-permission bg-red-600 text-sm rounded-md text-white px-3 py-1 hover:bg-red-500">
                                            Delete</a>
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
        var roleDestroyUrl = "{{ route('roles.destroy', ':id') }}";
    </script>

    <!-- public JS file -->
    <script src="{{ asset('assets/admin/js/role.js') }}"></script>
    @endpush
</x-app-layout>