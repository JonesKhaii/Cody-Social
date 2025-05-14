<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Doctor;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

        $posts = Post::select('id', 'title', 'slug', 'summary', 'photo', 'post_cat_id', 'post_tag_id', 'added_by', 'created_at')
            ->where('status', 'active')
            ->with([
                'cat_info:id,name as title',
                'doctor:id,name,photo',
                'user:id,name,photo'
            ])
            ->withCount(['comments'])
            ->paginate(6);


        $topViewedPosts = Post::select('id', 'title', 'slug', 'summary', 'photo', 'views', 'post_cat_id', 'post_tag_id', 'added_by', 'created_at')
            ->where('status', 'active')
            ->with([
                'cat_info:id,name as title',
                'doctor:id,name,photo',
                'user:id,name,photo'
            ])
            ->orderByDesc('views')
            ->limit(5)
            ->get();



        $topDoctors = Doctor::with('specializations:id,name')
            ->select('id', 'name', 'photo', 'rating')
            ->where('status', true)
            ->orderByDesc('rating')
            ->limit(4)
            ->get();

        $categories = Category::select('id', 'name as title', 'slug')
            ->where('status', 'active')
            ->where('type', 'other')
            ->orderBy('name')
            ->get();

        // $popularCategories = Category::select('categories.id', 'categories.name as title', 'categories.slug', 'categories.photo')
        //     ->leftJoin('posts', function ($join) {
        //         $join->on('categories.id', '=', 'posts.post_cat_id')
        //             ->where('posts.status', 'active');
        //     })
        //     ->where('categories.type', 'post')
        //     ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.photo')
        //     ->orderByRaw('COUNT(posts.id) DESC')
        //     ->limit(5)
        //     ->get();
        $popularCategories = Category::select('categories.id', 'categories.name as title', 'categories.slug', 'categories.photo')
            ->leftJoin('posts', function ($join) {
                $join->on('categories.id', '=', 'posts.post_cat_id')
                    ->where('posts.status', 'active');
            })
            ->where('categories.type', 'post')
            ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.photo')
            ->orderByRaw('COUNT(posts.id) DESC')
            ->limit(5)
            ->get();
        return view('index', compact('posts', 'topDoctors', 'categories', 'popularCategories', 'topViewedPosts'));
    }

    public function filterPosts(Request $request)
    {
        $categoryTitle = $request->input('category');

        // Lấy bài viết theo danh mục dựa trên tên danh mục (title)
        $posts = Post::select('id', 'title', 'slug', 'summary', 'photo', 'post_cat_id', 'post_tag_id', 'added_by', 'created_at')
            ->where('status', 'active')
            ->whereHas('cat_info', function ($query) use ($categoryTitle) {
                $query->where('name', $categoryTitle);
            })
            ->with([
                'cat_info:id,name',
                'tag_info:id,title',
                'author_info:id,name,photo',
            ])
            ->latest()
            ->paginate(6);

        $html = view('partials.posts', compact('posts'))->render();

        return response()->json(['html' => $html]);
    }
}
