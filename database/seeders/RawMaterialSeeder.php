<?php

namespace Database\Seeders;

use App\Models\RawMaterial;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RawMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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

        foreach ($rawMaterials as $material) {
            RawMaterial::create($material);
        }

        $this->command->info('Raw materials berhasil di-seed!');
    }
}
