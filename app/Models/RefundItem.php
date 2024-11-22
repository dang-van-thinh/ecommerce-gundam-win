<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundItem extends Model
{
    use HasFactory;

    protected $table = "refund_items";

    protected $fillable = [
        'refund_id',
        'product_id',
        'quantity',
        'reason',
        'description',
        'img',
    ];
}
