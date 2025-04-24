<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ImageController;

class PostController extends Controller
{


    public function index()
    {

        $categories = PostCategory::all();

        return view('doctor.profile', compact('categories'));
    }

    public function detail($slug)
    {
        $post = Post::with(['user', 'doctor'])->where('slug', $slug)->where('status', 'active')->firstOrFail();

        // $post = Post::where('slug', $slug)->firstOrFail();

        if (!session()->has('viewed_post_' . $post->id)) {
            $post->increment('views');
            session()->put('viewed_post_' . $post->id, true);
        }

        // dd($post->views);

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
        // dd('Request nhận thành công'); // Nếu không thấy dòng này, request không chạy vào store()

        $doctor = auth()->guard('doctor')->user();
        // dd($doctor); // Nếu không thấy dòng này, có thể lỗi do authentication

        if (!$doctor) {
            return redirect()->back()->with('error', 'Bạn không có quyền đăng bài.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'description' => 'required|string',
            'post_cat_id' => 'required|exists:post_categories,id',
            'photo' => 'required|image|mimes:webp,jpeg,png,jpg,gif|max:2048',
        ]);

        // dd('Dữ liệu hợp lệ, tiếp tục xử lý');

        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->summary = $request->summary;
        $post->description = $request->description;
        $post->post_cat_id = $request->post_cat_id;
        $post->status = 'active';
        $post->added_by = $doctor->id;

        // dd('Dữ liệu hợp lệ, tiếp tục xử lý');

        if ($request->hasFile('photo')) {
            // dd('File ảnh đã được nhận, tiếp tục upload'); // Nếu không thấy dòng này, `$request->hasFile('image')` trả về false
            $imageUrl = app(ImageController::class)->uploadImage($request);
            // dd($imageUrl);
        } else {
            dd('Không có ảnh nào được gửi');
            $imageUrl = null;
        }


        // dd('Ảnh upload xong, tiếp tục lưu bài viết');

        $post->photo = $imageUrl;

        try {
            $post->save();
            // dd('Bài viết đã được lưu thành công!');
        } catch (\Exception $e) {
            dd($e->getMessage()); // Hiển thị lỗi SQL hoặc lỗi khác
        }

        return redirect()->back()->with('success', 'Bài viết đã được tạo thành công!');
    }





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
            // Xóa ảnh cũ trên S3 trước khi upload ảnh mới
            if ($post->photo) {
                $oldImagePath = str_replace(Storage::disk('s3')->url(''), '', $post->photo);
                Storage::disk('s3')->delete($oldImagePath);
            }

            // Upload ảnh mới
            $imageUrl = app(ImageController::class)->uploadImage($request);
            $post->photo = $imageUrl;
        }

        // Lưu bài viết vào CSDL
        $post->save();

        // Trả về thông báo thành công
        return redirect()->back()->with('success', 'Bài viết đã được cập nhật!');
    }

    public function searchResult(Request $request)
    {
        $q = $request->input('query');

        $posts = Post::with(['user', 'doctor']) // Eager load cả hai quan hệ
            ->where('title', 'LIKE', "%{$q}%")
            ->orWhere('summary', 'LIKE', "%{$q}%")
            ->paginate(10);

        return view('search-result', compact('posts', 'q'));
    }



    public function destroy($id)
    {
        try {
            // Tìm bài viết hoặc trả về lỗi 404
            $post = Post::findOrFail($id);

            // Xóa ảnh trên S3 nếu tồn tại và không rỗng
            if (!empty($post->photo) && Storage::disk('s3')->exists($post->photo)) {
                Storage::disk('s3')->delete($post->photo);
            }

            // Xóa bài viết
            $post->delete();

            // Trả về phản hồi JSON thành công
            return response()->json([
                'success' => true,
                'message' => 'Bài viết đã được xóa thành công!'
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Xử lý lỗi nếu bài viết không tồn tại
            return response()->json([
                'success' => false,
                'message' => 'Bài viết không tồn tại!'
            ], 404);
        } catch (\Exception $e) {
            // Xử lý lỗi không xác định
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa bài viết: ' . $e->getMessage()
            ], 500);
        }
    }
}
