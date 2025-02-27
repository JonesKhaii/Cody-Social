<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Post;

class Comment extends Model
{
    use HasFactory;
    protected $table = "post_comments";

    protected $fillable = ['user_id', 'doctor_id', 'post_id', 'comment', 'status', 'parent_id', 'replied_comment'];

    // public function author_info()
    // {
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }


    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withDefault();
    }

    // Quan hệ với Doctor (có thể null)
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id')->withDefault();
    }
    public function author_info()
    {
        return $this->user_id ? $this->user() : $this->doctor();
    }
    // Quan hệ với bài viết
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    // Quan hệ với bình luận cha
    public function parent()
    {
        return $this->belongsTo(PostComment::class, 'parent_id', 'id');
    }

    // Quan hệ với các bình luận con (replies)
    public function replies()
    {
        return $this->hasMany(PostComment::class, 'parent_id', 'id');
    }
}
