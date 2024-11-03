<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = "order_items";

    protected $filltable = [
        'id',
        'order_id',
        'product_variant_id',
        'product_name',
        'product_price',
        'quantity',
        'total_price',
    ];
    public function order()
    {
        return  $this->belongsTo(Order::class, 'order_id');
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }

    public function productVariant()
    {
        return  $this->belongsTo(ProductVariant::class);
    }
}
