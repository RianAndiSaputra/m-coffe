<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\RawMaterial;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use App\Models\RawMaterialPurchase;
use Illuminate\Foundation\Auth\User;
use App\Models\RawMaterialPurchaseItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RawMaterialPurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outlet = Outlet::first();
        $user = User::first();

        if (!$outlet || !$user) {
            $this->command->warn('Outlet atau User tidak ditemukan. Pastikan seeder Outlet dan User sudah dijalankan terlebih dahulu.');
            return;
        }

        $materials = RawMaterial::all();

        // Create 3 sample purchases
        for ($i = 1; $i <= 3; $i++) {
            $purchaseDate = Carbon::now()->subDays(rand(1, 30));
            
            $purchase = RawMaterialPurchase::create([
                'purchase_number' => 'PUR-' . date('Ymd') . '-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                'outlet_id' => $outlet->id,
                'purchase_date' => $purchaseDate,
                'total_amount' => 0,
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

        $this->command->info('Raw material purchases berhasil di-seed!');
    }
}
