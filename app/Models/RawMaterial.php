<?php

namespace App\Models;

use App\Models\RawMaterialStock;
use App\Models\RawMaterialPurchaseItem;
use App\Models\RawMaterialStockHistory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RawMaterial extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'unit',
        'cost_per_unit',
        'min_stock',
        'description',
        'is_active',
    ];

    protected $casts = [
        'cost_per_unit' => 'decimal:2',
        'min_stock' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function stocks()
    {
        return $this->hasMany(RawMaterialStock::class);
    }

    public function stockHistories()
    {
        return $this->hasMany(RawMaterialStockHistory::class);
    }

    public function purchaseItems()
    {
        return $this->hasMany(RawMaterialPurchaseItem::class);
    }

    public function productRecipes()
    {
        return $this->hasMany(ProductRecipe::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    // Methods
    public function getCurrentStock($outletId)
    {
        $stock = $this->stocks()->where('outlet_id', $outletId)->first();
        return $stock ? $stock->current_stock : 0;
    }

    public function isBelowMinStock($outletId)
    {
        $currentStock = $this->getCurrentStock($outletId);
        return $currentStock < $this->min_stock;
    }
}