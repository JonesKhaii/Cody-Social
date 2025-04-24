<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class PostCategory extends Model
{
    protected $fillable = ['title', 'slug', 'status', 'photo', 'parent_id'];

    public function post()
    {
        return $this->hasMany('App\Models\Post', 'post_cat_id', 'id')->where('status', 'active');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'post_cat_id', 'id');
    }

    // Thêm quan hệ danh mục cha-con
    public function children()
    {
        return $this->hasMany(PostCategory::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(PostCategory::class, 'parent_id');
    }

    // Thêm quan hệ bài viết nổi bật
    public function featured_posts()
    {
        return $this->hasMany(Post::class, 'post_cat_id')
            ->where('status', 'active')
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc');
    }

    public static function getBlogByCategory($slug)
    {
        return PostCategory::with('post')->where('slug', $slug)->first();
    }

    // Thêm phương thức lấy danh mục cha
    public static function getParentCategories()
    {
        return self::where('status', 'active')
            ->whereNull('parent_id')
            ->with(['children' => function ($query) {
                $query->where('status', 'active');
            }])
            ->orderBy('title')
            ->get();
    }
}
