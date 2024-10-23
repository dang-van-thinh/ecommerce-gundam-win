<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageArticle extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'image_articles';
    protected $fillable = [
        'image_url',
    ];

}
