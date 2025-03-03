<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'tags', 'summary', 'slug', 'description', 'photo', 'quote', 'post_cat_id', 'post_tag_id', 'added_by', 'status'];


    public function cat_info()
    {
        return $this->belongsTo(\App\Models\PostCategory::class, 'post_cat_id', 'id');
    }

    public function tag_info()
    {
        return $this->hasOne('App\Models\PostTag', 'id', 'post_tag_id');
    }

    public function author_info()
    {
        return $this->belongsTo(Doctor::class, 'added_by', 'id');
    }
    public static function getAllPost()
    {
        return Post::with(['cat_info', 'author_info'])->orderBy('id', 'DESC')->paginate(10);
    }
    // public function get_comments(){
    //     return $this->hasMany('App\Models\PostComment','post_id','id');
    // }
    public static function getPostBySlug($slug)
    {
        return Post::with(['tag_info', 'author_info'])->where('slug', $slug)->where('status', 'active')->first();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id')->whereNull('parent_id')->where('status', 'active')->latest();
    }
    public function allComments()
    {
        return $this->hasMany(PostComment::class)->where('status', 'active');
    }

    public static function getBlogByTag($slug)
    {
        // dd($slug);
        return Post::where('tags', $slug)->paginate(8);
    }

    public static function countActivePost()
    {
        $data = Post::where('status', 'active')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class);
    }

    // Kiểm tra xem user hoặc doctor đã like bài viết chưa
    public function isLikedBy($userOrDoctor)
    {
        if (!$userOrDoctor) {
            return false;
        }

        return $this->likes()
            ->where(function ($query) use ($userOrDoctor) {
                if ($userOrDoctor instanceof \App\Models\User) {
                    $query->where('user_id', $userOrDoctor->id);
                } elseif ($userOrDoctor instanceof \App\Models\Doctor) {
                    $query->where('doctor_id', $userOrDoctor->id);
                }
            })
            ->exists();
    }
}
