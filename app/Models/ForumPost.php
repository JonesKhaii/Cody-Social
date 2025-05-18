<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumPost extends Model
{
    protected $fillable = [
        'content',
        'thread_id',
        'user_id',
        'parent_id'
    ];

    // Quan hệ với Thread
    public function thread()
    {
        return $this->belongsTo(ForumThread::class, 'thread_id');
    }

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với Post cha
    public function parent()
    {
        return $this->belongsTo(ForumPost::class, 'parent_id');
    }

    // Quan hệ với các Post con (trả lời)
    public function replies()
    {
        return $this->hasMany(ForumPost::class, 'parent_id');
    }
}
