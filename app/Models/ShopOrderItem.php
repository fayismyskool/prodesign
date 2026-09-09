<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShopOrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_order_id',
        'product_id',
        'product_title',
        'product_image',
        'unit_price',
        'quantity',
        'total_price',
    ];

    public function order()
    {
        return $this->belongsTo(ShopOrder::class, 'shop_order_id');
    }
}
