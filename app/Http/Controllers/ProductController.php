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
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class ProductController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('permission:view-product', only: ['index']),
            new Middleware('permission:add-product', only: ['create', 'store']),
            new Middleware('permission:edit-product', only: ['edit', 'update']),
            new Middleware('permission:delete-product', only: ['destroy']),
        ];
    }

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
            ->select('id', 'product_name', 'product_price', 'product_image')
            ->get();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $products = Product::with('category')->orderBy('created_at', 'DESC')->paginate(4);
        return view('product.list', compact('products'));
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
        // Image upload
        $imagePath = $this->handleImageUpload($request);

        // Insert product
        Product::create([
            'category_id'         => $request->category_id,
            'product_name'        => $request->product_name,
            'product_description' => $request->product_description,
            'product_price'       => $request->product_price,
            'product_image'       => $imagePath,
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product added successfully!');
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
        $product = Product::findOrFail($decryptedId);
        $categories = Category::all();
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
        $product->update([
            'category_id'         => $request->category_id,
            'product_name'        => $request->product_name,
            'product_description' => $request->product_description,
            'product_price'       => $request->product_price,
            'product_image'       => $imagePath,
        ]);

        // Redirect correctly
        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully!');
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
            'message' => 'Product deleted successfully'
        ]);
    }
}
