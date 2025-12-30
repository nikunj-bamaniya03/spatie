<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Category Dropdown -->
                        <div>
                            <label class="text-lg font-medium">Category</label>
                            <div class="my-3">
                                <select name="category_id" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                                    <option value="">-- Select Category --</option>

                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->categorie_name }}
                                    </option>
                                    @endforeach
                                </select>

                                @error('category_id')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Product Name -->
                        <div>
                            <label class="text-lg font-medium">Product Name</label>
                            <div class="my-3">
                                <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}"
                                    placeholder="Enter Product Name"
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg">

                                @error('product_name')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Product Description -->
                        <div>
                            <label class="text-lg font-medium">Product Description</label>
                            <div class="my-3">
                                <input type="text" name="product_description" value="{{ old('product_description', $product->product_description) }}"
                                    placeholder="Enter Product Description"
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg">

                                @error('product_description')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Product Price  -->
                        <div>
                            <label class="text-lg font-medium">Product Price</label>
                            <div class="my-3">
                                <input type="text" name="product_price" value="{{ old('product_price',$product->product_price) }}"
                                    placeholder="Enter Product Price"
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg">

                                @error('product_price')
                                <p class="text-red-400 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Product Image -->
                        <div>
                            <label class="text-lg font-medium">Product Image</label>
                            <div class="my-3">
                                <div class="flex">
                                    @if($product->product_image)
                                    <div class="mb-2">
                                        <p class="text-sm text-gray-600">Current Image:</p>
                                        <img src="{{ asset('storage/' . $product->product_image) }}" alt="Current Image" width="100" class="mb-2 border rounded">
                                    </div>
                                    @endif
                                    <div id="preview_container" class="mb-2" style="display: none;">
                                        <p class="text-sm text-gray-600">Preview:</p>
                                        <img id="preview_image" alt="Preview Image" width="100" class="mb-2 border rounded">
                                    </div>

                                    @error('product_image')
                                    <p class="text-red-400 font-medium">{{ $message }}</p>
                                    @enderror
                                </div>

                                <input type="file" name="product_image" id="product_image"
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg" accept="image/*">
                            </div>
                        </div>

                        <button type="submit" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">
                            Update Product
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('assets/admin/js/editProductPreview.js') }}"></script>
    @endpush

</x-app-layout>