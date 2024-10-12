<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "oders";

    protected $filltable = [
        'id',
        'address_user_id',
        'total_amount',
        'status','payment_method ',
        'confirmation_status ',
        'note',
        'discount_amount',
        'created_at ',
        'updated_at '
    ];
    public $timestamps = false;
    public function orderItems(){
        $this->haMany(OrderItem::class);
    }

    public function refund(){
        $this->hasOne(Refund::class);
    }

    public function addressUser(){
        $this->belongsTo(AddressUser::class, 'address_user_id');
    }
}
