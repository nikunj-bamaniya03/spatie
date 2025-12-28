<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


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



    public function categories()
    {
        return Category::select('id','categorie_name')->get();
    }

    public function productsByCategory($id)
    {
        return Product::where('category_id', $id)
            ->select('id','product_name','product_price','product_image')
            ->get();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'DESC')->get();
        return view('product.list', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(AddProductRequest $request)
    {
        // STEP 1: Image upload
        $imagePath = null;

        if ($request->hasFile('product_image')) {

            $image = $request->file('product_image');

            // STEP 2: Unique file name
            $fileName = time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();

            // STEP 3: Store image
            $image->storeAs('products', $fileName, 'public');

            // STEP 4: Save path
            $imagePath = 'products/' . $fileName;
        }

        // STEP 5: Insert product (MATCH DB COLUMNS)
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
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        // STEP 1: Get product
        $product = Product::findOrFail($id);

        // STEP 2: Keep old image by default
        $imagePath = $product->product_image;

        // STEP 3: If new image uploaded
        if ($request->hasFile('product_image')) {

            // Delete old image (optional but best practice)
            if ($product->product_image && Storage::disk('public')->exists($product->product_image)) {
                Storage::disk('public')->delete($product->product_image);
            }

            $image = $request->file('product_image');

            // Create unique filename
            $fileName = time() . '_' . Str::random(8) . '.' . $image->getClientOriginalExtension();

            // Store image
            $image->storeAs('products', $fileName, 'public');

            // Save new path
            $imagePath = 'products/' . $fileName;
        }

        // STEP 4: Update product
        $product->update([
            'category_id'         => $request->category_id,
            'product_name'        => $request->product_name,
            'product_description' => $request->product_description,
            'product_price'       => $request->product_price,
            'product_image'       => $imagePath,
        ]);

        // STEP 5: Redirect correctly
        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted successfully'
        ]);
    }   
}
