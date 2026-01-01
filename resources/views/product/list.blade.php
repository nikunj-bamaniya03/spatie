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
            <div class="mb-6">
                <form method="GET" action="{{ route('products.index') }}">
                    <div class="flex gap-3 items-center">

                        <select name="category_id"
                            class="border rounded px-4 py-2 w-64">
                            <option value="">-- All Categories --</option>

                            @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->categorie_name }}
                            </option>
                            @endforeach
                        </select>

                        <button type="submit"
                            class="bg-indigo-600 text-white px-5 py-2 rounded">
                            Filter
                        </button>

                        @if(request( 'category_id'))
                        <a href="{{ route('products.index') }}"
                            class="bg-gray-200 px-5 py-2 rounded">
                            Reset
                        </a>
                        @endif

                    </div>
                </form>
            </div>

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
                        @if($product->categories->count())
                        @foreach($product->categories as $category)
                        <span class="text-xs bg-indigo-100 text-indigo-700 px-2 py-1 rounded mr-1">
                            {{ $category->categorie_name }}
                        </span>
                        @endforeach
                        @else
                        <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">
                            No Category
                        </span>
                        @endif
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