<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentPost extends Model
{
    use HasFactory;

    protected $table = "comment_posts";

    // Chỉ cần những trường bạn muốn cho phép gán
    protected $fillable = ['article_id', 'user_id', 'parent_comment_id', 'comment', 'created_at', 'updated_at'];

    // Để Laravel tự động quản lý timestamps
    public $timestamps = true;

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function replies()
    {
        return $this->hasMany(CommentPost::class, 'parent_comment_id');
    }
    public function parent()
{
    return $this->belongsTo(CommentPost::class, 'parent_comment_id');
}

}
