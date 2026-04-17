<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'quantity',
        'rate',
        'gst_percent',
        'gst_amount',
        'total_amount',
    ];

    public function stock()
    {
        return $this->hasOne(Stock::class, 'product_code', 'product_code');
    }
}
