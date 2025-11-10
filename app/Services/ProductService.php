<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Inventory;
use App\Models\RawMaterial;
use App\Models\ProductRecipe;
use App\Models\RawMaterialStock;
use Illuminate\Support\Facades\Log;
use App\Models\RawMaterialStockHistory;

class ProductService
{
    private function deductRawMaterialsForProduction($productId, $outletId, $productQuantity, $userId, $notes = null)
    {
        // Ambil semua resep produk
        $recipes = ProductRecipe::where('product_id', $productId)
            ->with('rawMaterial')
            ->get();

        if ($recipes->isEmpty()) {
            return true; // Tidak ada resep, skip
        }

        $insufficientMaterials = [];
        
        foreach ($recipes as $recipe) {
            // Quantity dalam resep sudah dalam satuan yang sama dengan unit bahan baku
            // Contoh: jika unit = kilogram, maka quantity = 0.8 artinya 0.8 kg
            $requiredQuantity = $recipe->quantity * $productQuantity;
            
            // Cek stok bahan baku di outlet ini
            $stock = RawMaterialStock::where('outlet_id', $outletId)
                ->where('raw_material_id', $recipe->raw_material_id)
                ->first();
            
            $currentStock = $stock ? floatval($stock->current_stock) : 0;
            
            // Debug log (bisa dihapus setelah testing)
            \Log::info('Stock Check', [
                'material' => $recipe->rawMaterial->name,
                'required' => $requiredQuantity,
                'available' => $currentStock,
                'unit' => $recipe->rawMaterial->unit
            ]);
            
            if ($currentStock < $requiredQuantity) {
                $insufficientMaterials[] = [
                    'name' => $recipe->rawMaterial->name,
                    'code' => $recipe->rawMaterial->code,
                    'required' => $requiredQuantity,
                    'available' => $currentStock,
                    'shortage' => $requiredQuantity - $currentStock,
                    'unit' => $recipe->rawMaterial->unit
                ];
            }
        }

        // Jika ada bahan baku yang kurang, throw exception
        if (!empty($insufficientMaterials)) {
            $errorMessage = "Stok bahan baku tidak mencukupi untuk produksi {$productQuantity} unit:\n\n";
            foreach ($insufficientMaterials as $material) {
                $errorMessage .= sprintf(
                    "• %s (%s)\n  Dibutuhkan: %s %s\n  Tersedia: %s %s\n  Kurang: %s %s\n\n",
                    $material['name'],
                    $material['code'],
                    number_format($material['required'], 2),
                    $material['unit'],
                    number_format($material['available'], 2),
                    $material['unit'],
                    number_format($material['shortage'], 2),
                    $material['unit']
                );
            }
            throw new \Exception($errorMessage);
        }

        // Kurangi stok bahan baku
        foreach ($recipes as $recipe) {
            $requiredQuantity = $recipe->quantity * $productQuantity;
            
            // Get or create stock
            $stock = RawMaterialStock::firstOrCreate(
                [
                    'outlet_id' => $outletId,
                    'raw_material_id' => $recipe->raw_material_id
                ],
                [
                    'current_stock' => 0,
                    'total_value' => 0
                ]
            );

            $stockBefore = floatval($stock->current_stock);
            $stockAfter = $stockBefore - $requiredQuantity;

            // Update stock
            $stock->update([
                'current_stock' => $stockAfter
            ]);

            // Create history
            RawMaterialStockHistory::create([
                'outlet_id' => $outletId,
                'raw_material_id' => $recipe->raw_material_id,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'quantity_change' => -$requiredQuantity,
                'type' => 'production',
                'notes' => $notes ?? "Produksi {$productQuantity} unit produk",
                'user_id' => $userId,
                'product_id' => $productId
            ]);
        }

        return true;
    }

    public function handleRecipeChangesWithStockAdjustment($product, $newRecipes, $outletIds, $userId)
    {
        $oldRecipes = ProductRecipe::where('product_id', $product->id)->get()->keyBy('id');
        $recipeIds = [];
        $stockAdjustments = [];

        foreach ($newRecipes as $recipeData) {
            // Hapus resep
            if (isset($recipeData['is_deleted']) && $recipeData['is_deleted']) {
                if (isset($recipeData['id'])) {
                    ProductRecipe::where('id', $recipeData['id'])
                        ->where('product_id', $product->id)
                        ->delete();
                }
                continue;
            }

            // Cegah duplikat bahan baku
            $query = ProductRecipe::where('product_id', $product->id)
                ->where('raw_material_id', $recipeData['raw_material_id']);
            if (isset($recipeData['id'])) {
                $query->where('id', '!=', $recipeData['id']);
            }

            if ($query->exists()) {
                throw new \Exception("Bahan baku ID {$recipeData['raw_material_id']} sudah ada di resep ini.");
            }

            $newQuantity = floatval($recipeData['quantity']);

            // Update / buat resep baru
            if (isset($recipeData['id'])) {
                $oldRecipe = $oldRecipes->get($recipeData['id']);
                if ($oldRecipe) {
                    $oldQuantity = floatval($oldRecipe->quantity);
                    $quantityDiff = $newQuantity - $oldQuantity;

                    if (abs($quantityDiff) > 0.001) {
                        $this->applyQuantityDiffToStockAdjustments(
                            $product,
                            $outletIds,
                            $recipeData['raw_material_id'],
                            $quantityDiff,
                            $stockAdjustments
                        );
                    }

                    $oldRecipe->update([
                        'raw_material_id' => $recipeData['raw_material_id'],
                        'quantity' => $newQuantity,
                        'notes' => $recipeData['notes'] ?? null,
                    ]);
                    $recipeIds[] = $oldRecipe->id;
                }
            } else {
                $this->applyNewRecipeStockAdjustment($product, $outletIds, $recipeData, $stockAdjustments);
                $recipe = ProductRecipe::create([
                    'product_id' => $product->id,
                    'raw_material_id' => $recipeData['raw_material_id'],
                    'quantity' => $newQuantity,
                    'notes' => $recipeData['notes'] ?? null,
                ]);
                $recipeIds[] = $recipe->id;
            }
        }

        // Hapus resep yang tidak ada di request
        if (!empty($recipeIds)) {
            ProductRecipe::where('product_id', $product->id)
                ->whereNotIn('id', $recipeIds)
                ->delete();
        } else {
            ProductRecipe::where('product_id', $product->id)->delete();
        }

        // Apply semua penyesuaian stok
        foreach ($stockAdjustments as $outletId => $materials) {
            foreach ($materials as $rawMaterialId => $quantityChange) {
                if (abs($quantityChange) < 0.001) continue;
                $this->adjustRawMaterialStock(
                    $rawMaterialId,
                    $outletId,
                    $quantityChange,
                    $userId,
                    $product,
                    $quantityChange < 0 ? 'Adjustment: Resep diubah (kurang quantity)' : 'Adjustment: Resep diubah (tambah quantity)'
                );
            }
        }

        $this->updateProductCost($product->id);
    }

    /**
     * Tambahan helper internal untuk kalkulasi stock adjustment saat quantity berubah
     */
    private function applyQuantityDiffToStockAdjustments($product, $outletIds, $rawMaterialId, $quantityDiff, &$stockAdjustments)
    {
        $inventories = Inventory::where('product_id', $product->id)
            ->whereIn('outlet_id', $outletIds)
            ->get();

        foreach ($inventories as $inventory) {
            $stockChange = $quantityDiff * floatval($inventory->quantity);
            $stockAdjustments[$inventory->outlet_id][$rawMaterialId] =
                ($stockAdjustments[$inventory->outlet_id][$rawMaterialId] ?? 0) + $stockChange;
        }
    }

    /**
     * Helper untuk stok adjustment resep baru
     */
    private function applyNewRecipeStockAdjustment($product, $outletIds, $recipeData, &$stockAdjustments)
    {
        $inventories = Inventory::where('product_id', $product->id)
            ->whereIn('outlet_id', $outletIds)
            ->get();

        foreach ($inventories as $inventory) {
            if (floatval($inventory->quantity) > 0) {
                $stockChange = floatval($recipeData['quantity']) * floatval($inventory->quantity);
                $stockAdjustments[$inventory->outlet_id][$recipeData['raw_material_id']] =
                    ($stockAdjustments[$inventory->outlet_id][$recipeData['raw_material_id']] ?? 0) + $stockChange;
            }
        }
    }

    /**
     * Adjust stok bahan baku (positif = kurangi, negatif = tambah)
     */
    public function adjustRawMaterialStock($rawMaterialId, $outletId, $quantityChange, $userId, $product, $notes)
    {
        $stock = RawMaterialStock::firstOrCreate(
            ['outlet_id' => $outletId, 'raw_material_id' => $rawMaterialId],
            ['current_stock' => 0, 'total_value' => 0]
        );

        $stockBefore = floatval($stock->current_stock);
        $stockAfter = $stockBefore - $quantityChange;

        if ($quantityChange > 0 && $stockAfter < 0) {
            $rawMaterial = RawMaterial::find($rawMaterialId);
            throw new \Exception("Stok '{$rawMaterial->name}' tidak cukup. Dibutuhkan: {$quantityChange}, Tersedia: {$stockBefore}");
        }

        $stock->update(['current_stock' => $stockAfter]);

        RawMaterialStockHistory::create([
            'outlet_id' => $outletId,
            'raw_material_id' => $rawMaterialId,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'quantity_change' => -$quantityChange,
            'type' => 'adjustment',
            'notes' => $notes . " (Produk: {$product->name})",
            'user_id' => $userId,
            'product_id' => $product->id,
        ]);
    }

    private function updateProductCost($productId)
    {
        $product = Product::with('recipes.rawMaterial')->find($productId);
        
        if (!$product || $product->recipes->isEmpty()) {
            return;
        }

        $totalCost = 0;
        foreach ($product->recipes as $recipe) {
            $totalCost += (floatval($recipe->quantity) * floatval($recipe->rawMaterial->cost_per_unit));
        }

        // Opsional: simpan total cost ke product table jika ada kolom 'cost'
        // $product->update(['cost' => $totalCost]);
    }
}