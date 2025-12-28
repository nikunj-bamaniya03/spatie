<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="text-xl font-semibold">Product List</h2>

            @can('add-product')
            <a href="{{ route('products.create') }}"
                class="bg-slate-700 text-white px-5 py-2 rounded">
                Add Product
            </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                @foreach($products as $product)
                <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                     <!-- Image  -->
                    <div class="h-48 bg-gray-100 overflow-hidden">
                        @if($product->product_image)
                        <img src="{{ asset('storage/'.$product->product_image) }}"
                            class="h-full w-full object-cover hover:scale-105 transition">
                        @else
                        <div class="flex items-center justify-center h-full text-gray-400">
                            No Image
                        </div>
                        @endif
                    </div>

                    
                    <!-- Body -->
                    <div class="p-4">

                        <!-- Category -->
                        <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded">
                            {{ $product->category->categorie_name ?? 'No Category' }}
                        </span>

                        <!-- Name -->
                        <h3 class="font-semibold text-lg mt-2">
                            {{ $product->product_name }}
                        </h3>

                        <!-- Description -->
                        <p class="text-sm text-gray-500 mt-1 line-clamp-2">
                            {{ $product->product_description }}
                        </p>

                        <!-- Price -->
                        <div class="mt-3 text-xl font-bold text-green-600">
                            ₹ {{ number_format($product->product_price, 2) }}
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 flex gap-2">
                            @can('edit-product')
                            <a href="{{ route('products.edit',$product->id) }}"
                                class="flex-1 text-center bg-blue-600 text-white py-2 rounded text-sm">
                                Edit
                            </a>
                            @endcan

                            @can('delete-product')
                            <button data-id="{{ $product->id }}"
                                class="delete-product flex-1 bg-red-600 text-white py-2 rounded text-sm">
                                Delete
                            </button>
                            @endcan
                        </div>

                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    <!-- AJAX -->
    @push('scripts')
    <script>
        var productDestroyUrl = "{{ route('products.destroy', ':id') }}";
    </script>
    <script src="{{ asset('assets/admin/js/productDelete.js') }}"></script>
    @endpush

</x-app-layout>