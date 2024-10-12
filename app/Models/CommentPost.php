<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentPost extends Model
{
    use HasFactory;
    protected $table = "comment_posts";
    protected $fillable = ['id', 'article_id ','user_id','parent_comment_id','comment','created_at', 'updated_at'];
    public $timestamps = false;

    public function article(){
        return $this->belongsTo(Article::class,'article_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
