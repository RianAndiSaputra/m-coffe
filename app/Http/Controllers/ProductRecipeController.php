<?php

namespace App\Http\Controllers;

use App\Models\ProductRecipe;
use App\Models\Product;
use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class ProductRecipeController extends Controller
{
    public function index()
    {
        try {
            $productRecipes = ProductRecipe::with(['product', 'rawMaterial'])->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Product recipes retrieved successfully',
                'data' => $productRecipes
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve product recipes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => 'required|exists:products,id',
                'recipes' => 'required|array|min:1',
                'recipes.*.raw_material_id' => 'required|exists:raw_materials,id|distinct',
                'recipes.*.quantity' => 'required|numeric|min:0.01',
                'recipes.*.notes' => 'nullable|string'
            ]);

            DB::beginTransaction();

            $product = Product::findOrFail($validated['product_id']);
            $createdRecipes = [];

            foreach ($validated['recipes'] as $recipe) {
                // Check if already exists
                $exists = ProductRecipe::where('product_id', $validated['product_id'])
                    ->where('raw_material_id', $recipe['raw_material_id'])
                    ->exists();

                if ($exists) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Duplicate recipe found',
                        'error' => "Recipe with raw material ID {$recipe['raw_material_id']} already exists for this product"
                    ], 422);
                }

                $createdRecipe = ProductRecipe::create([
                    'product_id' => $validated['product_id'],
                    'raw_material_id' => $recipe['raw_material_id'],
                    'quantity' => $recipe['quantity'],
                    'notes' => $recipe['notes'] ?? null
                ]);

                $createdRecipes[] = $createdRecipe->load('rawMaterial');
            }

            // Update product cost setelah semua recipe ditambahkan
            $this->updateProductCost($validated['product_id']);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product recipes created successfully',
                'data' => [
                    'product' => $product->fresh(),
                    'recipes' => $createdRecipes,
                    'total_recipes' => count($createdRecipes)
                ]
            ], 201);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create product recipes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $productRecipe = ProductRecipe::with(['product', 'rawMaterial'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Product recipe retrieved successfully',
                'data' => $productRecipe
            ], 200);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product recipe not found',
                'error' => "Product recipe with ID {$id} does not exist"
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve product recipe',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $productRecipe = ProductRecipe::findOrFail($id);

            $validated = $request->validate([
                'product_id' => 'sometimes|required|exists:products,id',
                'raw_material_id' => 'sometimes|required|exists:raw_materials,id',
                'quantity' => 'sometimes|required|numeric|min:0.01',
                'notes' => 'nullable|string'
            ]);

            // If product_id or raw_material_id is being updated, check for duplicate
            if ($request->has('product_id') || $request->has('raw_material_id')) {
                $productId = $request->get('product_id', $productRecipe->product_id);
                $rawMaterialId = $request->get('raw_material_id', $productRecipe->raw_material_id);

                $exists = ProductRecipe::where('product_id', $productId)
                    ->where('raw_material_id', $rawMaterialId)
                    ->where('id', '!=', $id)
                    ->exists();

                if ($exists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Recipe already exists',
                        'error' => 'Recipe for this product and raw material combination already exists'
                    ], 422);
                }
            }

            DB::beginTransaction();
            
            $oldProductId = $productRecipe->product_id;
            $productRecipe->update($validated);
            
            // Update product cost untuk produk lama (jika product_id berubah)
            if ($request->has('product_id') && $oldProductId != $validated['product_id']) {
                $this->updateProductCost($oldProductId);
            }
            
            // Update product cost untuk produk baru/current
            $this->updateProductCost($productRecipe->product_id);
            
            $productRecipe->load(['product', 'rawMaterial']);
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product recipe updated successfully',
                'data' => $productRecipe
            ], 200);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product recipe not found',
                'error' => "Product recipe with ID {$id} does not exist"
            ], 404);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product recipe',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $productRecipe = ProductRecipe::findOrFail($id);
            $productId = $productRecipe->product_id;
            
            DB::beginTransaction();
            
            $productRecipe->delete();
            
            // Update product cost setelah recipe dihapus
            $this->updateProductCost($productId);
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product recipe deleted successfully'
            ], 200);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product recipe not found',
                'error' => "Product recipe with ID {$id} does not exist"
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete product recipe',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getByProduct($productId)
    {
        try {
            $product = Product::findOrFail($productId);
            
            $recipes = ProductRecipe::with(['rawMaterial'])
                ->where('product_id', $productId)
                ->get();
            
            // Calculate total recipe cost
            $totalCost = 0;
            $recipeDetails = $recipes->map(function ($recipe) use (&$totalCost) {
                $itemCost = $recipe->quantity * $recipe->rawMaterial->cost_per_unit;
                $totalCost += $itemCost;
                
                return [
                    'id' => $recipe->id,
                    'raw_material' => [
                        'id' => $recipe->rawMaterial->id,
                        'name' => $recipe->rawMaterial->name,
                        'code' => $recipe->rawMaterial->code,
                        'unit' => $recipe->rawMaterial->unit,
                        'cost_per_unit' => $recipe->rawMaterial->cost_per_unit
                    ],
                    'quantity' => $recipe->quantity,
                    'notes' => $recipe->notes,
                    'item_cost' => round($itemCost, 2)
                ];
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Product recipes retrieved successfully',
                'data' => [
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'code' => $product->code,
                        'price' => $product->price
                    ],
                    'recipes' => $recipeDetails,
                    'summary' => [
                        'total_recipes' => $recipes->count(),
                        'total_recipe_cost' => round($totalCost, 2),
                        'selling_price' => $product->price,
                        'gross_profit' => round($product->price - $totalCost, 2),
                        'profit_margin_percentage' => $product->price > 0 
                            ? round((($product->price - $totalCost) / $product->price) * 100, 2) 
                            : 0
                    ]
                ]
            ], 200);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
                'error' => "Product with ID {$productId} does not exist"
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve product recipes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getByRawMaterial($rawMaterialId)
    {
        try {
            $rawMaterial = RawMaterial::findOrFail($rawMaterialId);
            
            $recipes = ProductRecipe::with(['product'])
                ->where('raw_material_id', $rawMaterialId)
                ->get();
            
            $productDetails = $recipes->map(function ($recipe) use ($rawMaterial) {
                $itemCost = $recipe->quantity * $rawMaterial->cost_per_unit;
                
                return [
                    'recipe_id' => $recipe->id,
                    'product' => [
                        'id' => $recipe->product->id,
                        'name' => $recipe->product->name,
                        'code' => $recipe->product->code,
                        'price' => $recipe->product->price
                    ],
                    'quantity_used' => $recipe->quantity,
                    'cost_per_product' => round($itemCost, 2),
                    'notes' => $recipe->notes
                ];
            });
            
            return response()->json([
                'success' => true,
                'message' => 'Raw material usage retrieved successfully',
                'data' => [
                    'raw_material' => [
                        'id' => $rawMaterial->id,
                        'name' => $rawMaterial->name,
                        'code' => $rawMaterial->code,
                        'unit' => $rawMaterial->unit,
                        'cost_per_unit' => $rawMaterial->cost_per_unit
                    ],
                    'products_using' => $productDetails,
                    'summary' => [
                        'total_products_using' => $recipes->count(),
                        'total_quantity_in_recipes' => $recipes->sum('quantity')
                    ]
                ]
            ], 200);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Raw material not found',
                'error' => "Raw material with ID {$rawMaterialId} does not exist"
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve raw material recipes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function updateProductCost($productId)
    {
        $product = Product::find($productId);
        
        if (!$product) {
            return;
        }

        // Hitung total cost dari semua recipe
        $totalCost = ProductRecipe::where('product_id', $productId)
            ->with('rawMaterial')
            ->get()
            ->sum(function ($recipe) {
                return $recipe->quantity * $recipe->rawMaterial->cost_per_unit;
            });

        // Update product cost (jika ada field cost di products table)
        // Uncomment jika table products punya field 'cost'
        // $product->update(['cost' => $totalCost]);
    }
}