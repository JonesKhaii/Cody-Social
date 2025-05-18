<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Post;
use App\Models\ForumThread;
use App\Models\ForumStats;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'slug', 'type', 'parent_id', 'icon', 'status', 'display_order', 'summary', 'photo'];

    public function posts()
    {
        return $this->hasMany(Post::class, 'post_cat_id', 'id')
            ->where('status', 'active');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }


    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }


    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public static function getPostCategories()
    {
        return self::ofType('post')
            ->active()
            ->parents()
            ->with(['children' => function ($query) {
                $query->active()->ofType('post');
            }])
            ->orderBy('name', 'asc')
            ->get();
    }

    public static function getCategoryBySlug($slug, $type = 'post')
    {
        return self::where('slug', $slug)
            ->where('type', $type)
            ->first();
    }

    public static function getCategoriesWithPostCount($type = 'post')
    {
        return self::select(
            'categories.*',
            DB::raw('(SELECT COUNT(*) FROM posts WHERE categories.id = posts.post_cat_id) as posts_count')
        )
            ->where('status', 'active')
            ->where('type', $type)
            ->havingRaw('posts_count > 0')
            ->orderBy('name', 'asc')
            ->get();
    }


    public function forumThreads()
    {
        return $this->hasMany(ForumThread::class, 'category_id');
    }

    public function forumStats()
    {
        return $this->hasOne(ForumStats::class, 'category_id');
    }
}
