<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Doctor;
use App\Models\PostCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Lấy danh sách bài viết mới nhất, chỉ lấy các cột cần thiết
        $posts = Post::select('id', 'title', 'slug', 'summary', 'photo', 'post_cat_id', 'post_tag_id', 'added_by', 'created_at')
            ->where('status', 'active')
            ->with([
                'cat_info:id,title', // Lấy tiêu đề danh mục bài viết
                'tag_info:id,title', // Lấy tên các tag liên kết với bài viết
                'author_info:id,name', // Lấy thông tin tác giả (name)
            ])
            ->latest()
            ->paginate(6); // Phân trang (6 bài viết mỗi trang)



        $topDoctors = Doctor::select('id', 'name', 'specialization as field', 'photo')
            ->where('status', true) // Chỉ lấy bác sĩ đang hoạt động
            ->orderByDesc('rating') // Lấy bác sĩ có rating cao nhất
            ->limit(4) // Giới hạn số lượng
            ->get();

        $categories = PostCategory::select('id', 'title', 'slug')
            ->where('status', 'active') // Chỉ lấy danh mục đang hoạt động
            ->orderBy('title') // Sắp xếp theo tên danh mục
            ->get();

        // Lấy danh mục phổ biến (đếm số lượng bài viết mỗi danh mục)
        $popularCategories = PostCategory::select('post_categories.id', 'post_categories.title', 'post_categories.slug', 'post_categories.photo')
            ->leftJoin('posts', function ($join) {
                $join->on('post_categories.id', '=', 'posts.post_cat_id')
                    ->where('posts.status', 'active');
            })
            ->groupBy('post_categories.id', 'post_categories.title', 'post_categories.slug', 'post_categories.photo')
            ->orderByRaw('COUNT(posts.id) DESC')
            ->limit(5)
            ->get();

        return view('index', compact('posts', 'topDoctors', 'categories', 'popularCategories'));
    }

    public function filterPosts(Request $request)
    {
        $categoryTitle = $request->input('category');

        // Lấy bài viết theo danh mục dựa trên tên danh mục (title)
        $posts = Post::select('id', 'title', 'slug', 'summary', 'photo', 'post_cat_id', 'post_tag_id', 'added_by', 'created_at')
            ->where('status', 'active')
            ->whereHas('cat_info', function ($query) use ($categoryTitle) {
                $query->where('title', $categoryTitle);
            })
            ->with([
                'cat_info:id,title',
                'tag_info:id,title',
                'author_info:id,name',
            ])
            ->latest()
            ->paginate(6);

        // Nếu bạn dùng view partial để render danh sách bài viết, bạn có thể trả về HTML render từ view đó:
        $html = view('partials.posts', compact('posts'))->render();

        return response()->json(['html' => $html]);
    }
}
