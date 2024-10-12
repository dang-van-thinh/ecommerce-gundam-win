<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherUsage extends Model
{
    use HasFactory;

    protected $table = 'voucher_usages';
    protected $fillable = [
        'user_id',
        'vourcher_id',
        'vourcher_code',
        'start_date',
        'end_date',
        'status', 
    ];

    // nhiều vourcher_usages thuộc về 1 vourcher
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
     // nhiều vourcher_usages thuộc về 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}