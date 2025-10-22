<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RawMaterialPurchase extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'purchase_number',
        'outlet_id',
        'purchase_date',
        'total_amount',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'total_amount' => 'decimal:2',
    ];

    // Relationships
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(RawMaterialPurchaseItem::class, 'purchase_id');
    }
}
