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
            $products = Product::with('outlets')->get();
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
        
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'sku' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'is_active' => 'required|boolean',
                'outlet_ids' => 'required|array',
                'outlet_ids.*' => 'exists:outlets,id',
                'quantity' => 'required|numeric',
                'min_stock' => 'required|numeric',
            ]);

            DB::beginTransaction();
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('products', 'public');
                $imagePath = $path;
            } else {
                return $this->errorResponse('Image is required', 400);
            }

            $product = Product::create([
                'name' => $request->name,
                'sku' => $request->sku,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'image' => $imagePath,
                'is_active' => $request->is_active,
            ]);

            foreach ($request->outlet_ids as $outletId) {
                Inventory::create([
                    'product_id' => $product->id,
                    'outlet_id' => $outletId,
                    'quantity' => $request->quantity,
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

        // dd($request->all());

        // if ($request->isMethod('PUT') && $request->hasFile('gambar')) {
        //     $request->setMethod('POST');
        // }
        // if ($request->isMethod('put') && $request->hasFile('image')) {
        //     $request->merge(['_method' => 'PUT']);
        // }
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
                'description' => 'required|string|max:255',
                'price' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10048',
                'is_active' => 'required|boolean',
                'outlet_ids' => 'required|array',
                'outlet_ids.*' => 'exists:outlets,id',
                'quantity' => 'required|numeric',
                'min_stock' => 'required|numeric',
            ]);

            DB::beginTransaction();
            // Handle image update
            if ($request->hasFile('image')) {
                // Delete old image
                // if ($product->image) {
                //     Storage::disk('public')->delete($product->image);
                // }
                // Store new image
                $imagePath = $request->file('image')->store('products', 'public');
            } else {
                $imagePath = $product->image;
            }

            // Update product
            $product->update([
                'name' => $request->name,
                'sku' => $request->sku,
                'description' => $request->description,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'image' => $imagePath,
                'is_active' => $request->is_active,
            ]);

            foreach ($request->outlet_ids as $outletId) {
                Inventory::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'outlet_id' => $outletId // Cari berdasarkan kombinasi ini
                    ],
                    [
                        'quantity' => $request->quantity,
                        'min_stock' => $request->min_stock
                    ]
                );
            }

            // Hapus outlet yang tidak ada di request
            Inventory::where('product_id', $product->id)
                ->whereNotIn('outlet_id', $request->outlet_ids)
                ->delete();

            DB::commit();

            return $this->successResponse($product, 'Product updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->validator->errors());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();
            Inventory::where('product_id', $product->id)->delete();
            $product->delete();
            Storage::disk('public')->delete($product->image);
            DB::commit();
            return $this->successResponse(null, 'Product deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->errorResponse($th->getMessage());
        }
    }

    public function getOutletProducts(Request $request, $outletId)
{
    try {
        $user = $request->user(); // Dapatkan user yang sedang login
        $outlet = Outlet::findOrFail($outletId); // Gunakan outletId dari parameter, bukan dari user

        // Cek apakah user adalah kasir
        $isCashier = strtolower($user->role) === 'kasir';

        $products = $outlet->products()
            ->with(['category', 'outlets'])
            ->when($isCashier, function ($query) {
                $query->where('is_active', true); // Hanya produk aktif untuk kasir
            })
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
                    'min_stock' => $product->pivot->min_stock ?? null,
                    'quantity' => $product->pivot->quantity ?? 0,
                    'outlets' => $product->outlets->map(function ($outlet) {
                        return [
                            'id' => $outlet->id,
                            'name' => $outlet->name,
                        ];
                    }),
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
            $user = $request->user(); // Dapatkan user saat ini
            $outlet = Outlet::findOrFail($user->outlet_id);

            // Cek apakah user adalah kasir
            $isCashier = $user->role === 'kasir';
            $products = $outlet->products()
                ->with(['category'])
                ->withPivot(['quantity', 'min_stock'])
                ->when($isCashier, function ($query) {
                    return $query->where('is_active', true); // Hanya produk aktif untuk kasir
                })
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
