<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{


    public function index()
    {

        $categories = PostCategory::all();

        return view('doctor.profile', compact('categories'));
    }

    public function detail($slug)
    {
        $post = Post::where('slug', $slug)->where('status', 'active')->firstOrFail();
        // $post = Post::where('slug', $slug)->firstOrFail();

        // Lấy các bình luận liên quan đến bài viết
        $comments = $post->comments()->with('author_info', 'replies')->get();

        // Lấy các bài viết gần đây
        $recent_posts = Post::latest()->take(5)->get();

        // Lấy danh mục bài viết
        $categories = PostCategory::select('post_categories.id', 'post_categories.title', 'post_categories.slug')
            ->withCount('posts') // Tính số bài viết trong từng danh mục
            ->where('status', 'active') // Chỉ lấy danh mục đang hoạt động
            ->orderBy('title') // Sắp xếp theo tên danh mục
            ->get();


        return view('pages.post-detail', compact('post', 'comments', 'recent_posts', 'categories'));
    }

    public function create()
    {
        $categories = PostCategory::where('status', 'active')->get();
        return view('doctor.profile', compact('categories'));
    }

    public function store(Request $request)
    {
        $doctor = auth()->guard('doctor')->user();

        if (!$doctor) {
            return redirect()->back()->with('error', 'Bạn không có quyền đăng bài.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'description' => 'required|string',
            'post_cat_id' => 'required|exists:post_categories,id',
            'image' => 'required|image|mimes:webp,jpeg,png,jpg,gif|max:2048',
        ]);

        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            $imageUrl = app(ImageController::class)->uploadImage($request);
        } else {
            $imageUrl = null;
        }

        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->summary = $request->summary;
        $post->description = $request->description;
        $post->post_cat_id = $request->post_cat_id;
        $post->photo = $imageUrl;
        $post->status = 'active';
        $post->added_by = $doctor->id;
        $post->save();

        // Load lại danh mục bài viết
        $categories = PostCategory::where('status', 'active')->get();

        return redirect()->back()->with('success', 'Bài viết đã được tạo thành công!');
    }

    // public function show($slug)
    // {
    //     $post = Post::where('slug', $slug)
    //         ->with([
    //             'comments' => function ($query) {
    //                 $query->where('status', 'active')
    //                     ->select('id', 'user_id', 'post_id', 'comment', 'parent_id', 'created_at');
    //             },
    //             'comments.author_info:id,name,photo',
    //             'comments.replies' => function ($query) {
    //                 $query->where('status', 'active')
    //                     ->select('id', 'user_id', 'post_id', 'comment', 'parent_id', 'created_at');
    //             },
    //             'comments.replies.author_info:id,name,photo'
    //         ])
    //         ->withCount('comments')
    //         ->firstOrFail();

    //     return view('posts.show', compact('post'));
    // }


    public function update(Request $request, $id)
    {
        // Validate dữ liệu nhập vào
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'description' => 'required|string',
            'post_cat_id' => 'required|exists:post_categories,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate ảnh nếu có
        ]);

        // Lấy bài viết cần chỉnh sửa
        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->summary = $request->summary;
        $post->description = $request->description;
        $post->post_cat_id = $request->post_cat_id;

        // Kiểm tra xem người dùng có upload ảnh mới hay không
        if ($request->hasFile('photo')) {
            // Nếu có ảnh mới, tải ảnh lên S3 và lấy URL của ảnh
            $imageUrl = app(ImageController::class)->uploadImage($request);
            $post->photo = $imageUrl; // Cập nhật ảnh mới vào bài viết
        }

        // Lưu bài viết vào CSDL
        $post->save();

        // Trả về thông báo thành công
        return redirect()->back()->with('success', 'Bài viết đã được cập nhật!');
    }

    public function search(Request $request)
    {
        $query = trim($request->query('query'));

        // Nếu từ khóa quá ngắn, không cần truy vấn database
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Tối ưu truy vấn tìm kiếm
        $posts = \App\Models\Post::select('id', 'title', 'summary', 'slug')
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('summary', 'LIKE', "%{$query}%");
            })
            ->orderByDesc('created_at')
            ->limit(10) // Dùng limit thay vì take
            ->get();

        return response()->json($posts);
    }
}
