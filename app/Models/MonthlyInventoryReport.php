<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyInventoryReport extends Model
{
    protected $fillable = [
        'outlet_id',
        'report_date',
        'product_id',
        'stock_value',
        'stock_quantity',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    //
}
