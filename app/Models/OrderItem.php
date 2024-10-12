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
        'attribute_value_products_id',
        'product_name',
        'product_price',
        'quantity',
        'total_price',
        'updated_at'
    ];
    public $timestamps = false;
    public function order() {
        $this->belongsTo(Order::class, 'order_id');
    }
    
    public function attributeValueProduct(){
        $this->belongsTo(AttributeValueProduct::class, 'attribute_value_products_id ');
    }

}
