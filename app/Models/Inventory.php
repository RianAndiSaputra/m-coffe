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
}
