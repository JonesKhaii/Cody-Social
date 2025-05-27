<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{

    public function allCategories()
    {
        // Cache 15 phút - simple mà hiệu quả
        $categoriesWithPosts = Cache::remember('all_categories_simple', 15 * 60, function () {

            // Lấy categories có bài viết (1 query)
            $categories = Category::select('id', 'name', 'slug', 'photo', 'summary')
                ->whereHas('posts', function ($query) {
                    $query->where('status', 'active');
                })
                ->where('status', 'active')
                ->whereNull('parent_id')
                ->orderBy('id')
                ->get();

            // Lấy tất cả posts cần thiết (1 query thay vì N queries)
            $categoryIds = $categories->pluck('id');

            $allPosts = Post::select('id', 'title', 'slug', 'photo', 'summary', 'description', 'post_cat_id', 'created_at', 'views')
                ->whereIn('post_cat_id', $categoryIds)
                ->where('status', 'active')
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('post_cat_id');

            // Gán posts cho từng category
            foreach ($categories as $category) {
                $categoryPosts = $allPosts->get($category->id, collect([]));
                $category->post_count = $categoryPosts->count();
                $category->loaded_posts = $categoryPosts->take(5);
            }

            // Lọc categories có posts
            return $categories->filter(function ($category) {
                return $category->loaded_posts->isNotEmpty();
            });
        });

        return view('pages.categories', compact('categoriesWithPosts'));
    }


    public function clearCache()
    {
        Cache::forget('all_categories_simple');
        return back()->with('success', 'Cache đã được xóa!');
    }

    public function show($slug)
    {

        $category = Category::where('slug', $slug)->firstOrFail();

        // Lấy bài viết thuộc danh mục đó, phân trang mỗi trang 8 bài
        $posts = Post::where('post_cat_id', $category->id)
            ->latest()
            ->paginate(12);

        return view('pages.posts-category', compact('category', 'posts'));
    }
}
