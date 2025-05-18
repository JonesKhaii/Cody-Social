<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumStats extends Model
{
    protected $primaryKey = 'category_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'category_id',
        'thread_count',
        'post_count',
        'last_thread_id',
        'last_post_id',
        'last_posted_at',
        'last_posted_by'
    ];

    // Quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Quan hệ với Thread cuối cùng
    public function lastThread()
    {
        return $this->belongsTo(ForumThread::class, 'last_thread_id');
    }

    // Quan hệ với Post cuối cùng
    public function lastPost()
    {
        return $this->belongsTo(ForumPost::class, 'last_post_id');
    }

    // Quan hệ với User đăng bài cuối
    public function lastPoster()
    {
        return $this->belongsTo(User::class, 'last_posted_by');
    }
}
