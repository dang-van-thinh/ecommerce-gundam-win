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
        'feedback_status',
    ];
    public function order()
    {
        return  $this->belongsTo(Order::class, 'order_id');
    }

    public function productVariant()
    {
        return  $this->belongsTo(ProductVariant::class);
    }
    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'user_id');
    }
}
