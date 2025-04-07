<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'outlet_id',
        'min_stock',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function inventoryHistories()
    {
        return $this->hasMany(InventoryHistory::class);
    }

    public function lastStock()
    {
        return $this->hasOne(InventoryHistory::class, 'product_id', 'product_id')
            ->join('inventories', function ($join) {
                $join->on('inventories.product_id', '=', 'inventory_histories.product_id')
                    ->on('inventories.outlet_id', '=', 'inventory_histories.outlet_id');
            })
            ->latest('inventory_histories.created_at');
    }
}
