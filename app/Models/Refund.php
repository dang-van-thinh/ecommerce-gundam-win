<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $table = "refunds";

    protected $filltable = ['order_id', 'reason', 'descripton','image','status'];

    public function order(){
        $this->hasOne(Order::class);
    }
}
