<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    
    protected $table = "feedback";

    protected $filltable = [
        'id',
        'product_id',
        'user_id',
        'parent_feedback_id',
        'rating ',
        'comment ',
        'file_path ',
        'created_at',
        'updated_at '
    ];
    public $timestamps = false;

    public function product(){
        $this->belongsTo(Product::class,'product_id');
    }

    public function user(){
        $this->belongsTo(User::class,'user_id');
    }

}
