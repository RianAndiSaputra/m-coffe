<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Outlet;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\RawMaterial;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\OutletSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\CategorySeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        
        $this->call([
            OutletSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            RawMaterialSeeder::class,
            RawMaterialPurchaseSeeder::class,
            RawMaterialStockSeeder::class,
        ]);

    }
}
