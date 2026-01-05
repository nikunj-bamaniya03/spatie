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

                    <form id="edit-product" action="{{ route('products.update', encrypt($product->id)) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Category Dropdown -->
                        <div>
                            <label class="text-lg font-medium">Category</label>

                            <div class="my-3">
                                <select id="category-select" name="category_id[]" multiple
                                    class="border-gray-300 shadow-sm w-1/2 rounded-lg">

                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ in_array($category->id,old('category_id', $product->categories->pluck('id')->toArray())) ? 'selected' : '' }}>
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
                        <x-image-upload :image="$product->product_image" />

                        <button type="submit" class="bg-slate-700 text-sm rounded-md text-white px-5 py-3">
                            Update Product
                        </button>
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
    {{-- edit image preview link --}}
    <script src="{{ asset('assets/admin/js/image-upload.js') }}"></script>

    {{-- Multiple-select --}}
    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>
    <script src="{{ asset('assets/admin/js/multi-select.js') }}"></script>
    @endpush

</x-app-layout>