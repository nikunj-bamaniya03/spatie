<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Illuminate\View\View;


class ProductController extends Controller
{
    // public function __construct()
    // {
    //     $this->authorizeResource(Product::class, 'product');
    // }

    private function handleImageUpload(Request $request, ?string $oldImagePath = null): ?string
    {
        /* 
         * REMOVE IMAGE (X BUTTON CLICK)
        */
        if ($request->remove_image == 1) {

            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }

            return null;
        }

        /* 
         * NEW IMAGE UPLOAD
        */
        if ($request->hasFile('product_image')) {

            // delete old image
            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }

            $image = $request->file('product_image');
            $fileName = time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('products', $fileName, 'public');

            return 'products/' . $fileName;
        }
        // if not edit image than stay old image path in db
        return $oldImagePath;
    }


    public function categories(): Collection
    {
        return Category::select('id', 'categorie_name')->get();
    }

    public function productsByCategory($id): Collection
    {
        return Product::where('category_id', $id)
            ->select('id', 'product_name', 'product_price', 'product_image')->get();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $categories = Category::orderBy('categorie_name')->get();

        $categoryId = null;

        if ($request->filled('category_id')) {
            try {
                $categoryId = decrypt($request->category_id);
            } catch (\Exception $e) {
                // $categoryId = null;
            }
        }

        $products = Product::with('categories')
            ->when($categoryId, function ($query) use ($categoryId) { //check if categoryId exist either skip
                $query->whereHas('categories', function ($q) use ($categoryId) { //check matched id
                    $q->where('categories.id', $categoryId); // check both id
                });
            })
            ->latest()->paginate(4)->withQueryString();
        return view('product.list', compact('products', 'categories'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(AddProductRequest $request): RedirectResponse
    {
        // Image upload (your existing method)
        $imagePath = $this->handleImageUpload($request);

        $product = Product::create($request->only('product_name', 'product_description', 'product_price') + ['product_image' => $imagePath]);

        // Attach multiple categories (pivot table)
        $product->categories()->sync($request->category_id);

        return redirect()->route('products.index')->with('success', 'Product added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $decryptedId = decrypt($id);
        $product = Product::with('categories')->findOrFail($decryptedId);
        $categories = Category::select('id', 'categorie_name')->get();
        return view('product.edit', compact('product', 'categories'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id): RedirectResponse
    {
        // Get product
        $decryptedId = decrypt($id);
        $product = Product::findOrFail($decryptedId);
        // Handle image upload
        $imagePath = $this->handleImageUpload($request, $product->product_image);

        // Update product
        $product->update($request->only('product_name', 'product_description', 'product_price') + ['product_image' => $imagePath]);

        // Sync categories (pivot table)
        $product->categories()->sync($request->category_id ?? []);

        // Redirect correctly
        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $decryptedId = decrypt($id);
        $product = Product::findOrFail($decryptedId);
        $product->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully',
        ]);
    }
}
