<?php

namespace Database\Seeders;

use App\Models\Outlet;
use App\Models\RawMaterial;
use Illuminate\Database\Seeder;
use App\Models\RawMaterialStock;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RawMaterialStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outlet = Outlet::first();

        if (!$outlet) {
            $this->command->warn('Outlet tidak ditemukan. Pastikan seeder Outlet sudah dijalankan terlebih dahulu.');
            return;
        }

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

        $this->command->info('Raw material stocks berhasil di-seed!');
    }
}
