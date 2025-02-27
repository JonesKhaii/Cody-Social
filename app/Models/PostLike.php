<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    use HasFactory;

    protected $fillable = ['post_id', 'user_id', 'doctor_id'];

    // Quan hệ với bài viết
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    // Quan hệ với user (nếu có)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với doctor (nếu có)
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
