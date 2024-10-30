<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = [
        'id',
        'address_user_id',
        'total_amount',
        'status',
        'payment_method',
        'confirm_status',
        'note',
        'discount_amount',
        'created_at',
        'updated_at'
    ];


    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function refund()
    {
        return $this->hasOne(Refund::class, 'order_id');
    }

    public function addressUser()
    {
        return $this->belongsTo(AddressUser::class, 'address_user_id');
    }
}
