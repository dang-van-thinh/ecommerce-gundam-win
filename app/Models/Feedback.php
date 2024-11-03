<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;


    protected $table = "feedbacks";

    protected $filltable = [
        'id',
        'product_id',
        'user_id',
        'parent_feedback_id',
        'rating ',
        'comment ',
        'file_path ',
        'created_at',
        'has_edited',
        'updated_at '
    ];

    public function product(){
       return $this->belongsTo(Product::class,'product_id');
    }

    public function user(){
       return $this->belongsTo(User::class,'user_id');
    }

}
