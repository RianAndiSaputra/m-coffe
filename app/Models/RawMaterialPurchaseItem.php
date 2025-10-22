<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawMaterialPurchaseItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'raw_material_id',
        'quantity',
        'unit_cost',
        'total_cost',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
        'unit_cost' => 'decimal:2',
        'total_cost' => 'decimal:2',
    ];

    // Relationships
    public function purchase()
    {
        return $this->belongsTo(RawMaterialPurchase::class, 'purchase_id');
    }

    public function rawMaterial()
    {
        return $this->belongsTo(RawMaterial::class);
    }
}