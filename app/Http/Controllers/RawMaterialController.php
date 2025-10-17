<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class RawMaterialController extends Controller
{
    public function index()
    {
        try {
            $rawMaterials = RawMaterial::with(['stocks', 'productRecipes'])->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Raw materials retrieved successfully',
                'data' => $rawMaterials
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve raw materials',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'code' => 'required|string|unique:raw_materials,code',
                'unit' => 'required|in:gram,milliliter,kilogram,liter,piece,sachet,pack,botol,kaleng',
                'cost_per_unit' => 'required|numeric|min:0',
                'min_stock' => 'required|numeric|min:0',
                'description' => 'nullable|string',
                'is_active' => 'boolean'
            ]);

            DB::beginTransaction();
            
            $rawMaterial = RawMaterial::create($validated);
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Raw material created successfully',
                'data' => $rawMaterial
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
                'message' => 'Failed to create raw material',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $rawMaterial = RawMaterial::with(['stocks', 'productRecipes'])->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Raw material retrieved successfully',
                'data' => $rawMaterial
            ], 200);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Raw material not found',
                'error' => "Raw material with ID {$id} does not exist"
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve raw material',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $rawMaterial = RawMaterial::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'code' => 'sometimes|required|string|unique:raw_materials,code,' . $rawMaterial->id,
                'unit' => 'sometimes|required|in:gram,milliliter,kilogram,liter,piece,sachet,pack,botol,kaleng',
                'cost_per_unit' => 'sometimes|required|numeric|min:0',
                'min_stock' => 'sometimes|required|numeric|min:0',
                'description' => 'nullable|string',
                'is_active' => 'sometimes|boolean'
            ]);

            DB::beginTransaction();
            
            $rawMaterial->update($validated);
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Raw material updated successfully',
                'data' => $rawMaterial->fresh()
            ], 200);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Raw material not found',
                'error' => "Raw material with ID {$id} does not exist"
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
                'message' => 'Failed to update raw material',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $rawMaterial = RawMaterial::findOrFail($id);

            if ($rawMaterial->productRecipes()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete raw material',
                    'error' => 'This raw material is being used in product recipes'
                ], 409);
            }

            DB::beginTransaction();
            
            $rawMaterial->delete();
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Raw material deleted successfully'
            ], 200);
            
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Raw material not found',
                'error' => "Raw material with ID {$id} does not exist"
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete raw material',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}