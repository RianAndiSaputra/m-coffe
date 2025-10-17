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
                'raw_material_id' => 'required|exists:raw_materials,id',
                'quantity' => 'required|numeric|min:0',
                'notes' => 'nullable|string'
            ]);

            // Check if the combination already exists
            $exists = ProductRecipe::where('product_id', $validated['product_id'])
                ->where('raw_material_id', $validated['raw_material_id'])
                ->exists();

            if ($exists) {
                return response()->json([
                    'success' => false,
                    'message' => 'Recipe already exists',
                    'error' => 'Recipe for this product and raw material combination already exists'
                ], 422);
            }

            DB::beginTransaction();
            
            $productRecipe = ProductRecipe::create($validated);
            $productRecipe->load(['product', 'rawMaterial']);
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product recipe created successfully',
                'data' => $productRecipe
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
                'message' => 'Failed to create product recipe',
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
                'quantity' => 'sometimes|required|numeric|min:0',
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
            
            $productRecipe->update($validated);
            $productRecipe->load(['product', 'rawMaterial']);
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Product recipe updated successfully',
                'data' => $productRecipe->fresh(['product', 'rawMaterial'])
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
            
            DB::beginTransaction();
            
            $productRecipe->delete();
            
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
            // Verify product exists
            $product = Product::findOrFail($productId);
            
            $recipes = ProductRecipe::with(['product', 'rawMaterial'])
                ->where('product_id', $productId)
                ->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Product recipes retrieved successfully',
                'data' => [
                    'product' => $product,
                    'recipes' => $recipes,
                    'total_recipes' => $recipes->count()
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
            // Verify raw material exists
            $rawMaterial = RawMaterial::findOrFail($rawMaterialId);
            
            $recipes = ProductRecipe::with(['product', 'rawMaterial'])
                ->where('raw_material_id', $rawMaterialId)
                ->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Raw material recipes retrieved successfully',
                'data' => [
                    'raw_material' => $rawMaterial,
                    'recipes' => $recipes,
                    'total_products_using' => $recipes->count()
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
}