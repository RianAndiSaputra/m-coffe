<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'inventories')
            ->withPivot('quantity'); // Ambil kolom quantity dari tabel pivot
    }
    
    public function kasir()
    {
        return $this->hasOne(User::class, 'outlet_id', 'id')->where('role', 'kasir');
    }

    public function manajer()
    {
        return $this->hasOne(User::class, 'outlet_id', 'id')->where('role', 'manajer');
    }
    
    

}
