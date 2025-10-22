<?php

namespace Database\Seeders;

use App\Models\RawMaterial;
use App\Models\RawMaterialStock;
use App\Models\RawMaterialPurchase;
use App\Models\RawMaterialPurchaseItem;
use App\Models\Outlet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class RawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data raw materials
        $rawMaterials = [
            [
                'name' => 'Tepung Terigu',
                'code' => 'RM-001',
                'unit' => 'kilogram',
                'cost_per_unit' => 12000,
                'min_stock' => 50,
                'description' => 'Tepung terigu protein sedang untuk pembuatan roti dan kue',
                'is_active' => true,
            ],
            [
                'name' => 'Gula Pasir',
                'code' => 'RM-002',
                'unit' => 'kilogram',
                'cost_per_unit' => 15000,
                'min_stock' => 30,
                'description' => 'Gula pasir putih untuk pemanis',
                'is_active' => true,
            ],
            [
                'name' => 'Susu Cair',
                'code' => 'RM-003',
                'unit' => 'liter',
                'cost_per_unit' => 18000,
                'min_stock' => 20,
                'description' => 'Susu cair UHT full cream',
                'is_active' => true,
            ],
            [
                'name' => 'Telur Ayam',
                'code' => 'RM-004',
                'unit' => 'kilogram',
                'cost_per_unit' => 28000,
                'min_stock' => 15,
                'description' => 'Telur ayam negeri segar',
                'is_active' => true,
            ],
            [
                'name' => 'Mentega',
                'code' => 'RM-005',
                'unit' => 'kilogram',
                'cost_per_unit' => 45000,
                'min_stock' => 10,
                'description' => 'Mentega tawar untuk baking',
                'is_active' => true,
            ],
            [
                'name' => 'Cokelat Bubuk',
                'code' => 'RM-006',
                'unit' => 'kilogram',
                'cost_per_unit' => 65000,
                'min_stock' => 5,
                'description' => 'Cokelat bubuk premium untuk minuman dan topping',
                'is_active' => true,
            ],
            [
                'name' => 'Kopi Arabika',
                'code' => 'RM-007',
                'unit' => 'kilogram',
                'cost_per_unit' => 120000,
                'min_stock' => 10,
                'description' => 'Biji kopi arabika premium',
                'is_active' => true,
            ],
            [
                'name' => 'Garam',
                'code' => 'RM-008',
                'unit' => 'kilogram',
                'cost_per_unit' => 5000,
                'min_stock' => 5,
                'description' => 'Garam halus untuk masakan',
                'is_active' => true,
            ],
            [
                'name' => 'Vanili',
                'code' => 'RM-009',
                'unit' => 'botol',
                'cost_per_unit' => 25000,
                'min_stock' => 3,
                'description' => 'Vanili ekstrak untuk aroma',
                'is_active' => true,
            ],
            [
                'name' => 'Baking Powder',
                'code' => 'RM-010',
                'unit' => 'kaleng',
                'cost_per_unit' => 30000,
                'min_stock' => 5,
                'description' => 'Baking powder untuk pengembang kue',
                'is_active' => true,
            ],
        ];

        // Insert raw materials
        foreach ($rawMaterials as $material) {
            RawMaterial::create($material);
        }

        // Ambil outlet dan user pertama (sesuaikan dengan data Anda)
        $outlet = Outlet::first();
        $user = User::first();

        if (!$outlet || !$user) {
            $this->command->warn('Outlet atau User tidak ditemukan. Pastikan seeder Outlet dan User sudah dijalankan terlebih dahulu.');
            return;
        }

        // Create stock untuk setiap raw material di outlet
        $materials = RawMaterial::all();
        foreach ($materials as $material) {
            $currentStock = rand(50, 200);
            $totalValue = $currentStock * $material->cost_per_unit;

            RawMaterialStock::create([
                'outlet_id' => $outlet->id,
                'raw_material_id' => $material->id,
                'current_stock' => $currentStock,
                'total_value' => $totalValue,
            ]);
        }

        // Create sample purchases
        for ($i = 1; $i <= 3; $i++) {
            $purchaseDate = Carbon::now()->subDays(rand(1, 30));
            
            $purchase = RawMaterialPurchase::create([
                'purchase_number' => 'PUR-' . date('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'outlet_id' => $outlet->id,
                'purchase_date' => $purchaseDate,
                'total_amount' => 0, // akan diupdate setelah item dibuat
                'notes' => 'Pembelian bahan baku periode ' . $purchaseDate->format('F Y'),
                'created_by' => $user->id,
            ]);

            // Create purchase items (3-5 items per purchase)
            $itemCount = rand(3, 5);
            $totalAmount = 0;
            $selectedMaterials = $materials->random($itemCount);

            foreach ($selectedMaterials as $material) {
                $quantity = rand(10, 50);
                $unitCost = $material->cost_per_unit;
                $totalCost = $quantity * $unitCost;
                $totalAmount += $totalCost;

                RawMaterialPurchaseItem::create([
                    'purchase_id' => $purchase->id,
                    'raw_material_id' => $material->id,
                    'quantity' => $quantity,
                    'unit_cost' => $unitCost,
                    'total_cost' => $totalCost,
                ]);
            }

            // Update total amount
            $purchase->update(['total_amount' => $totalAmount]);
        }

        $this->command->info('Raw material data berhasil di-seed!');
    }
}