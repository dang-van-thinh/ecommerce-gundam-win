<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
        "message",
        "title",
        "read_at",
        "type",
        "redirect_url",
        "user_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
