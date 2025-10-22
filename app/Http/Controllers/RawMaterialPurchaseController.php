<?php

namespace App\Http\Controllers;

use App\Models\RawMaterial;
use App\Models\RawMaterialPurchase;
use App\Models\RawMaterialPurchaseItem;
use App\Models\RawMaterialStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Exception;

class RawMaterialPurchaseController extends Controller
{
    public function index()
    {
        try {
            $purchases = RawMaterialPurchase::with([
                'outlet',
                'createdBy',
                'items.rawMaterial'
            ])->get();

            return response()->json([
                'success' => true,
                'message' => 'Purchases retrieved successfully',
                'data' => $purchases
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve purchases',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'outlet_id' => 'required|exists:outlets,id',
                'purchase_date' => 'required|date',
                'notes' => 'nullable|string',
                'created_by' => 'required|exists:users,id',
                'items' => 'required|array|min:1',
                'items.*.raw_material_id' => 'required|exists:raw_materials,id',
                'items.*.quantity' => 'required|numeric|min:0.01',
                'items.*.unit_cost' => 'required|numeric|min:0'
            ]);

            DB::beginTransaction();

            // Generate purchase number dengan prefix RMP (Raw Material Purchase)
            $lastPurchase = RawMaterialPurchase::whereDate('created_at', today())->count();
            $purchaseNumber = 'RMP-' . date('Ymd') . '-' . sprintf('%04d', $lastPurchase + 1);

            // Avoid duplicate purchase number
            while (RawMaterialPurchase::where('purchase_number', $purchaseNumber)->exists()) {
                $lastPurchase++;
                $purchaseNumber = 'RMP-' . date('Ymd') . '-' . sprintf('%04d', $lastPurchase + 1);
            }

            $purchase = RawMaterialPurchase::create([
                'purchase_number' => $purchaseNumber,
                'outlet_id' => $validated['outlet_id'],
                'purchase_date' => $validated['purchase_date'],
                'total_amount' => 0,
                'notes' => $validated['notes'] ?? null,
                'created_by' => $validated['created_by'],
            ]);

            $totalAmount = 0;

            foreach ($validated['items'] as $item) {
                $itemTotal = $item['quantity'] * $item['unit_cost'];
                $totalAmount += $itemTotal;

                // Create purchase item
                RawMaterialPurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'raw_material_id' => $item['raw_material_id'],
                    'quantity' => $item['quantity'],
                    'unit_cost' => $item['unit_cost'],
                    'total_cost' => $itemTotal
                ]);

                // Update cost_per_unit dengan weighted average method
                $this->updateRawMaterialCost(
                    $item['raw_material_id'],
                    $validated['outlet_id'],
                    $item['quantity'],
                    $item['unit_cost']
                );

                // Update stock di outlet
                $this->updateStock(
                    $item['raw_material_id'],
                    $validated['outlet_id'],
                    $item['quantity'],
                    'in',
                    "Purchase #{$purchaseNumber}"
                );
            }

            $purchase->update(['total_amount' => $totalAmount]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase created successfully',
                'data' => $purchase->load(['outlet', 'createdBy', 'items.rawMaterial'])
            ], 201);

        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create purchase',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $purchase = RawMaterialPurchase::with(['outlet', 'createdBy', 'items.rawMaterial'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Purchase retrieved successfully',
                'data' => $purchase
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Purchase not found',
                'error' => "Purchase with ID {$id} does not exist"
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve purchase',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $purchase = RawMaterialPurchase::findOrFail($id);

            $validated = $request->validate([
                'purchase_date' => 'sometimes|required|date',
                'notes' => 'nullable|string',
                'items' => 'sometimes|array|min:1',
                'items.*.raw_material_id' => 'required_with:items|exists:raw_materials,id',
                'items.*.quantity' => 'required_with:items|numeric|min:0.01',
                'items.*.unit_cost' => 'required_with:items|numeric|min:0'
            ]);

            DB::beginTransaction();

            $updateData = [];
            if (isset($validated['purchase_date'])) {
                $updateData['purchase_date'] = $validated['purchase_date'];
            }
            if (array_key_exists('notes', $validated)) {
                $updateData['notes'] = $validated['notes'];
            }

            if (!empty($updateData)) {
                $purchase->update($updateData);
            }

            // Update items if provided
            if (isset($validated['items'])) {
                // Kembalikan stok dari items lama
                foreach ($purchase->items as $oldItem) {
                    $this->updateStock(
                        $oldItem->raw_material_id,
                        $purchase->outlet_id,
                        $oldItem->quantity,
                        'out',
                        "Reversal - Update Purchase #{$purchase->purchase_number}"
                    );
                }

                // Hapus items lama
                $purchase->items()->delete();

                // Buat items baru dan update stok
                $totalAmount = 0;
                foreach ($validated['items'] as $item) {
                    $itemTotal = $item['quantity'] * $item['unit_cost'];
                    $totalAmount += $itemTotal;

                    RawMaterialPurchaseItem::create([
                        'purchase_id' => $purchase->id,
                        'raw_material_id' => $item['raw_material_id'],
                        'quantity' => $item['quantity'],
                        'unit_cost' => $item['unit_cost'],
                        'total_cost' => $itemTotal
                    ]);

                    // Update cost_per_unit
                    $this->updateRawMaterialCost(
                        $item['raw_material_id'],
                        $purchase->outlet_id,
                        $item['quantity'],
                        $item['unit_cost']
                    );

                    // Update stok dengan items baru
                    $this->updateStock(
                        $item['raw_material_id'],
                        $purchase->outlet_id,
                        $item['quantity'],
                        'in',
                        "Update Purchase #{$purchase->purchase_number}"
                    );
                }

                $purchase->update(['total_amount' => $totalAmount]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase updated successfully',
                'data' => $purchase->fresh(['outlet', 'createdBy', 'items.rawMaterial'])
            ], 200);

        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Purchase not found',
                'error' => "Purchase with ID {$id} does not exist"
            ], 404);
        } catch (ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update purchase',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $purchase = RawMaterialPurchase::findOrFail($id);

            DB::beginTransaction();

            // Kembalikan stok sebelum hapus
            foreach ($purchase->items as $item) {
                $this->updateStock(
                    $item->raw_material_id,
                    $purchase->outlet_id,
                    $item->quantity,
                    'out',
                    "Delete Purchase #{$purchase->purchase_number}"
                );
            }

            $purchase->items()->delete();
            $purchase->delete();
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Purchase deleted successfully'
            ], 200);
        } catch (ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Purchase not found',
                'error' => "Purchase with ID {$id} does not exist"
            ], 404);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete purchase',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update cost_per_unit menggunakan Weighted Average Method
     */
    private function updateRawMaterialCost($rawMaterialId, $outletId, $newQuantity, $newUnitCost)
    {
        $rawMaterial = RawMaterial::findOrFail($rawMaterialId);
        
        // Dapatkan stok saat ini di outlet
        $stock = RawMaterialStock::where('raw_material_id', $rawMaterialId)
            ->where('outlet_id', $outletId)
            ->first();

        $currentStock = $stock ? $stock->current_stock : 0;
        $currentTotalValue = $stock ? $stock->total_value : 0;

        // Hitung total value baru
        $newTotalValue = ($newQuantity * $newUnitCost);
        
        // Hitung weighted average cost
        // Formula: (Current Total Value + New Total Value) / (Current Stock + New Quantity)
        $totalStock = $currentStock + $newQuantity;
        
        if ($totalStock > 0) {
            $newWeightedCost = ($currentTotalValue + $newTotalValue) / $totalStock;
            
            $rawMaterial->update([
                'cost_per_unit' => round($newWeightedCost, 2)
            ]);
        }
    }

    /**
     * Update stok raw material di outlet
     */
    private function updateStock($rawMaterialId, $outletId, $quantity, $type = 'in', $reference = null)
    {
        $rawMaterial = RawMaterial::findOrFail($rawMaterialId);
        
        $stock = RawMaterialStock::firstOrCreate(
            [
                'raw_material_id' => $rawMaterialId,
                'outlet_id' => $outletId
            ],
            [
                'current_stock' => 0,
                'total_value' => 0
            ]
        );

        if ($type === 'in') {
            // Tambah stok
            $newStock = $stock->current_stock + $quantity;
            $addedValue = $quantity * $rawMaterial->cost_per_unit;
            $newTotalValue = $stock->total_value + $addedValue;
            
            $stock->update([
                'current_stock' => $newStock,
                'total_value' => $newTotalValue
            ]);
        } else {
            // Kurangi stok
            $newStock = $stock->current_stock - $quantity;
            
            // Hitung proporsi value yang dikurangi
            if ($stock->current_stock > 0) {
                $valuePerUnit = $stock->total_value / $stock->current_stock;
                $reducedValue = $quantity * $valuePerUnit;
                $newTotalValue = max(0, $stock->total_value - $reducedValue);
            } else {
                $newTotalValue = 0;
            }
            
            $stock->update([
                'current_stock' => max(0, $newStock),
                'total_value' => $newTotalValue
            ]);
        }

        // Opsional: Buat history untuk tracking
        // RawMaterialStockHistory::create([
        //     'raw_material_id' => $rawMaterialId,
        //     'outlet_id' => $outletId,
        //     'type' => $type,
        //     'quantity' => $quantity,
        //     'reference' => $reference,
        //     'stock_before' => $stock->current_stock - ($type === 'in' ? $quantity : -$quantity),
        //     'stock_after' => $stock->current_stock,
        //     'value_before' => $stock->total_value - ($type === 'in' ? $addedValue : -$reducedValue),
        //     'value_after' => $stock->total_value,
        // ]);
    }
}