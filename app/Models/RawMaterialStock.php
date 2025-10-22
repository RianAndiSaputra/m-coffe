<?php

namespace App\Models;

use App\Models\Outlet;
use App\Models\RawMaterial;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RawMaterialStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'outlet_id',
        'raw_material_id',
        'current_stock',
        'total_value',
    ];

    protected $casts = [
        'current_stock' => 'decimal:2',
        'total_value' => 'decimal:2',
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
}