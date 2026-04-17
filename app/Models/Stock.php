<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'total_purchased_qty',
        'total_sold_qty',
        'current_stock',
    ];

    public function purchaseProducts()
    {
        return $this->hasMany(PurchaseProduct::class, 'product_code', 'product_code');
    }
    public function sellProducts()
    {
        return $this->hasMany(SellProduct::class, 'product_code', 'product_code');
    }
}
