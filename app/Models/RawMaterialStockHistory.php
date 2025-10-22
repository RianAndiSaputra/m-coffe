<?php

namespace App\Models;

use App\Models\User;
use App\Models\Order;
use App\Models\Outlet;
use App\Models\Product;
use App\Models\RawMaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RawMaterialStockHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'raw_material_id',
        'stock_before',
        'stock_after',
        'quantity_change',
        'type',
        'notes',
        'user_id',
        'product_id',
        'order_id',
    ];

    protected $casts = [
        'stock_before' => 'decimal:2',
        'stock_after' => 'decimal:2',
        'quantity_change' => 'decimal:2',
    ];

    // Relationships
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Scopes
    // public function scopePurchase($query)
    // {
    //     return $query->where('type', 'purchase');
    // }

    // public function scopeProduction($query)
    // {
    //     return $query->where('type', 'production');
    // }

    // public function scopeAdjustment($query)
    // {
    //     return $query->where('type', 'adjustment');
    // }
}