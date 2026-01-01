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
                        <div class="mt-4 flex justify-center gap-4">
                            @can('edit-product')
                            <a href="{{ route('products.edit',encrypt($product->id)) }}"
                                class="text-blue-600 hover:text-blue-800 transition">
                                <i class="fas fa-edit text-lg"></i>
                            </a>
                            @endcan

                            @can('delete-product')
                            <a data-id="{{ encrypt($product->id) }}"
                                class="delete-product text-red-600 hover:text-red-800 transition cursor-pointer">
                                <i class="fas fa-trash text-lg"></i>
                            </a>
                            @endcan
                        </div>

                    </div>
                </div>
                @endforeach

            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        </div>
    </div>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AJAX -->
    @push('scripts')
    <script>
        const destroyProductUrl = "{{ route('products.destroy', ':id') }}";
    </script>

    <!-- SweetAlert CDN (CORRECT) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Public JS file -->
    <script src="{{ asset('assets/admin/js/productDelete.js') }}"></script>
    @endpush

</x-app-layout>