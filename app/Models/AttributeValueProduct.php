<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValueProduct extends Model
{
    use HasFactory;
    protected $table = "attribute_value_products";
    protected $fillable = ['id', 'product_id', 'attribute_value_id', 'quantity', 'price'];
    public function attributeValue(){
        $this ->belongsTo(AttributeValue::class,'attribute_value_id',);
    }
    public function orderItem(){
        $this ->hasMany(OrderItem::class);
    }
    public function carts(){
        $this ->hasMany(Cart::class,);
    }
    public function product(){
        $this ->belongsTo(Product::class,'product_id');
    }
}
