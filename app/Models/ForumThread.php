<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ForumThread extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'user_id',
        'is_sticky',
        'is_locked'
    ];

    // Quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    // Quan hệ với User (người tạo thread)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với User (người bình luận cuối cùng)
    public function lastPoster()
    {
        return $this->belongsTo(User::class, 'last_posted_by');
    }

    // Quan hệ với các bài viết
    public function posts()
    {
        return $this->hasMany(ForumPost::class, 'thread_id');
    }

    // Helper method để tạo slug
    public static function createSlug($title)
    {
        $slug = Str::slug($title);
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }


    public function getUrlAttribute()
    {
        if ($this->category) {
            return route('forum.threads.show', [$this->category->slug, $this->slug]);
        }

        // Fallback URL nếu category không tồn tại
        return route('forum.index');
    }
}
