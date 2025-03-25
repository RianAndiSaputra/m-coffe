<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Outlet;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::all();
            return $this->successResponse($products, 'Products retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi request
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
            'is_active' => 'required|boolean',
            'outlet_ids' => 'required|array', // Ubah ke array
            'outlet_ids.*' => 'exists:outlets,id', // Validasi setiap item array
            'quantity' => 'required|numeric',
            'min_stock' => 'required|numeric',
        ]);


        try {

            DB::beginTransaction();
            // Simpan gambar ke storage
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public'); // Simpan di folder 'public/products'
                $imagePath = $path; // Simpan path gambar
            } else {
                return $this->errorResponse('Image is required', 400);
            }

            // Buat produk tanpa menyimpan file temporary
            $product = Product::create([
                'name' => $request->name,
                'sku' => $request->sku,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'image' => $imagePath, // Simpan path gambar, bukan file temporary
                'is_active' => $request->is_active,
            ]);

            foreach ($request->outlet_ids as $outletId) {
                Inventory::create([
                    'product_id' => $product->id,
                    'outlet_id' => $outletId,
                    'quantity' => $request->quantity, // Atur nilai default quantity
                    'min_stock' => $request->min_stock,
                ]);
            }

            DB::commit();

            return $this->successResponse($product, 'Product created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try {
            return $this->successResponse($product, 'Product retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'is_active' => 'required|boolean',
        ]);

        try {

            if ($request->hasFile('image')) {
                Storage::delete('images/' . $product->image);
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $request['image'] = $imageName;
            }
            $product->update($request->all());
            return $this->successResponse($product, 'Product updated successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
            Storage::delete('images/' . $product->image);
            return $this->successResponse(null, 'Product deleted successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getOutletProducts($outletId)
    {
        try {
            $outlet = Outlet::findOrFail($outletId);

            $products = $outlet->products()
                ->with(['category'])
                ->withPivot(['quantity', 'min_stock'])
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'sku' => $product->sku,
                        'description' => $product->description,
                        'price' => $product->price,
                        'image' => asset('storage/' . $product->image),
                        'is_active' => $product->is_active,
                        'category' => [
                            'id' => $product->category->id,
                            'name' => $product->category->name,
                        ],
                        'min_stock' => $product->pivot->min_stock,
                        'quantity' => $product->pivot->quantity,
                    ];
                });

            return $this->successResponse($products, 'Products retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
    public function getOutletProductsPos(Request $request)
    {
        try {
            $outlet = Outlet::findOrFail($request->user()->outlet_id);

            $products = $outlet->products()
                ->with(['category'])
                ->withPivot(['quantity', 'min_stock'])
                ->get()
                ->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'sku' => $product->sku,
                        'description' => $product->description,
                        'price' => $product->price,
                        'image' => asset('storage/' . $product->image),
                        'is_active' => $product->is_active,
                        'category' => [
                            'id' => $product->category->id,
                            'name' => $product->category->name,
                        ],
                        'min_stock' => $product->pivot->min_stock,
                        'quantity' => $product->pivot->quantity,
                    ];
                });

            return $this->successResponse($products, 'Products retrieved successfully');
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage());
        }
    }
}
