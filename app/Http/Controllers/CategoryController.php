<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostCategory;

class CategoryController extends Controller
{
    public function show($slug)
    {
        // Lấy danh mục theo slug
        $category = PostCategory::where('slug', $slug)->firstOrFail();

        // Lấy bài viết thuộc danh mục đó, phân trang mỗi trang 8 bài
        $posts = Post::where('post_cat_id', $category->id)
            ->latest()
            ->paginate(8);

        return view('pages.posts-category', compact('category', 'posts'));
    }
}
