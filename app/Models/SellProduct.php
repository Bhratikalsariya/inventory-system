<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'quantity',
        'selling_price',
        'gst_percent',
        'gst_amount',
        'total_amount',
    ];
}
