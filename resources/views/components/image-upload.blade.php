@props([
    'image' => null,
    'inputName' => 'product_image'
])

<div class="image-uploader relative">

    {{-- Label --}}
    <div>
        <label class="text-lg font-medium">Product Image</label>
    </div>

    {{-- Image Box --}}
    <div class="my-3 relative inline-block">
        <div class="image-box relative w-32 h-32 border rounded overflow-hidden cursor-pointer">

            {{-- Main / Preview Image --}}
            <img class="main-image w-full h-full object-cover" src="{{ $image ? asset('storage/'.$image) : '' }}"
                alt="Product Image">

            {{-- Remove Image Button --}}
            <button type="button" class="remove-image absolute top-1 right-1 bg-red-500 text-white
                rounded-full w-6 h-6 text-sm flex items-center justify-center hidden">
                ✕
            </button>
        </div>
    </div>

    {{-- Hidden flag --}}
    <input type="hidden" name="remove_image" class="remove-flag" value="0">

    {{-- File Input --}}
    <input type="file" name="{{ $inputName }}" class="image-input border-gray-300 shadow-sm rounded-lg mt-2" accept="image/*">

    {{-- Zoom Modal --}}
    <div
        class="image-modal fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">

        <img class="zoom-image max-w-[90%] max-h-[90%] rounded shadow-lg">

        <button type="button" class="close-modal absolute top-5 right-5 text-white text-3xl">
            ✕
        </button>
    </div>

</div>
