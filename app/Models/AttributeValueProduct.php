<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValueProduct extends Model
{
    use HasFactory;
    protected $table = "attribute_value_products";
    protected $fillable = ['id', 'product_id', 'attribute_value_id', 'quantity', 'price'];
    public function product(){
        $this ->hasMany(Product::class);
    }
    public function attributeValue(){
        $this ->belongsTo(AttributeValue::class,'attribute_value_id',);
    }
    public function orderItem(){
        $this ->hasMany(OrderItem::class);
    }
    // public function carts(){
    //     $this ->belongsTo(Cart::class,'id');
    // }
    public function products(){
        $this ->belongsTo(Product::class,'product_id');
    }
}
