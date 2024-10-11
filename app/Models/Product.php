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
         $this->hasMany(AttributeValueProduct::class);
    }
    public function ProductImage(){
         $this->hasMany(ProductImage::class);
    }
    public function categoryProduct(){
        $this->belongsTo(CategoryProduct::class,'category_product_id');
    }
    public function feedback(){
        $this->hasMany(Feedback::class);
   }
}
