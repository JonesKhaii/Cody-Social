<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    protected $fillable = ['user_id', 'doctor_id', 'post_id', 'comment', 'replied_comment', 'parent_id', 'status'];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    // Quan hệ với Doctor
    public function doctor()
    {
        return $this->belongsTo('App\Models\Doctor', 'doctor_id', 'id');
    }

    // Trả về thông tin người viết bình luận (user hoặc doctor)
    public function getAuthorInfoAttribute()
    {
        return $this->user ?? $this->doctor;
    }

    // Trả về avatar người viết bình luận
    public function getAuthorPhotoAttribute()
    {
        return $this->author_info->photo ?? 'images/default-avatar.png';
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function replies()
    {
        return $this->hasMany(PostComment::class, 'parent_id')->where('status', 'active');
    }
}
