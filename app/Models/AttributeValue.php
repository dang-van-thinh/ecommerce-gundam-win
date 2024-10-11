<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;
    protected $table = "attribute_values";
    protected $fillable = ['id', 'attribute_id', 'name'];
    public function attribute(){
        return $this->belongsTo(Attribute::class,'attribute_id');
    }
    public function attributeValueProduct(){
        return $this->hasMany(AttributeValueProduct::class);
    }
}
