<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = ['id', 'category_product_id', 'name', 'description', 'image', 'status', 'love', 'created_at', 'updated_at'];
    public $timestamps = false;
    public function attributeValueProduct(){
        return $this->hasMany(AttributeValueProduct::class);
    }
    public function productImage(){
        return $this->hasMany(ProductImage::class);
    }
    public function categoryProduct(){
        return $this->belongsTo(CategoryProduct::class,'category_product_id');
    }
    public function feedback(){
        return $this->hasMany(Feedback::class);
   }
}
