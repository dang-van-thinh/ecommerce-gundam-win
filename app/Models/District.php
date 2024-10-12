<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = [
        'province_id',
        'name',
    ];
    public function addressUsers()
    {
        return $this->hasMany(AddressUser::class);
    }
    public function wards()
    {
        return $this->hasMany(Ward::class);
    }
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}
