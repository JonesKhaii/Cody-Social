<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use App\Models\Post;
use App\Models\Category; // Thay đổi import PostCategory thành Category
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\ImageController;

class PostController extends Controller
{
    public function index()
    {
        // Thay đổi để sử dụng model Category với type = post
        $categories = Category::where('type', 'post')->get();

        return view('doctor.profile', compact('categories'));
    }

    // public function detail($slug)
    // {
    //     // Cache key dựa trên slug
    //     $cacheKey = 'post_detail_' . $slug;

    //     // Cache view đã render
    //     if (Cache::has($cacheKey) && !auth()->check() && !auth()->guard('doctor')->check()) {
    //         return Cache::get($cacheKey);
    //     }

    //     // Eager load tất cả các quan hệ cần thiết
    //     $post = Post::with([
    //         'comments' => function ($query) {
    //             $query->whereNull('parent_id')
    //                 ->where('status', 'active')
    //                 ->latest();
    //         },
    //         'comments.replies',
    //         'comments.user:id,name,photo',
    //         'comments.doctor:id,name,photo',
    //         'comments.replies.user:id,name,photo',
    //         'comments.replies.doctor:id,name,photo',
    //         'cat_info:id,name as title,slug', 
    //         'user:id,name,photo',
    //         'doctor:id,name,photo,specialization,short_bio,bio',
    //         'likes'
    //     ])
    //         ->where('slug', $slug)
    //         ->where('status', 'active')
    //         ->firstOrFail();

    //     // Tăng lượt xem bất đồng bộ
    //     if (!session()->has('viewed_post_' . $post->id)) {
    //         dispatch(function () use ($post) {
    //             $post->increment('views');
    //         })->afterResponse();

    //         session()->put('viewed_post_' . $post->id, true);
    //     }

    //     // Xử lý tags
    //     $post_tags = array_map('trim', explode(',', $post->tags));

    //     // Lấy các bài viết gần đây với caching
    //     $recent_posts = Cache::remember('recent_posts_' . $post->id, 3600, function () use ($post) {
    //         return Post::select('id', 'title', 'slug', 'photo', 'created_at')
    //             ->where('status', 'active')
    //             ->where('id', '!=', $post->id)
    //             ->latest()
    //             ->take(5)
    //             ->get();
    //     });


    //     // Render view
    //     $view = view('pages.post-detail', compact(
    //         'post',
    //         'recent_posts',
    //         'post_tags'
    //     ))->render();

    //     // Cache view cho người dùng chưa đăng nhập
    //     if (!auth()->check() && !auth()->guard('doctor')->check()) {
    //         Cache::put($cacheKey, $view, 3600);
    //     }

    //     return $view;
    // }
    public function detail($slug)
    {
        // Cache key dựa trên slug
        $cacheKey = 'post_detail_' . $slug;

        // Cache view đã render
        if (Cache::has($cacheKey) && !auth()->check() && !auth()->guard('doctor')->check()) {
            return Cache::get($cacheKey);
        }

        // Eager load tất cả các quan hệ cần thiết
        $post = Post::with([
            'comments' => function ($query) {
                $query->whereNull('parent_id')
                    ->where('status', 'active')
                    ->latest();
            },
            'comments.replies',
            'comments.user:id,name,photo',
            'comments.doctor:id,name,photo',
            'comments.replies.user:id,name,photo',
            'comments.replies.doctor:id,name,photo',
            'cat_info:id,name as title,slug',
            'user:id,name,photo',
            'doctor:id,name,photo,short_bio,bio',
            'doctor.specializations:id,name,slug',
            'likes'
        ])
            ->where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Tăng lượt xem bất đồng bộ
        if (!session()->has('viewed_post_' . $post->id)) {
            dispatch(function () use ($post) {
                $post->increment('views');
            })->afterResponse();

            session()->put('viewed_post_' . $post->id, true);
        }

        // Xử lý tags
        $post_tags = array_map('trim', explode(',', $post->tags));

        // Lấy các bài viết gần đây với caching
        $recent_posts = Cache::remember('recent_posts_' . $post->id, 3600, function () use ($post) {
            return Post::select('id', 'title', 'slug', 'photo', 'created_at')
                ->where('status', 'active')
                ->where('id', '!=', $post->id)
                ->latest()
                ->take(5)
                ->get();
        });

        // Render view
        $view = view('pages.post-detail', compact(
            'post',
            'recent_posts',
            'post_tags'
        ))->render();

        // Cache view cho người dùng chưa đăng nhập
        if (!auth()->check() && !auth()->guard('doctor')->check()) {
            Cache::put($cacheKey, $view, 3600);
        }

        return $view;
    }
    public function create()
    {
        // Thay đổi để sử dụng model Category với type = post
        $categories = Category::where('status', 'active')
            ->where('type', 'post')
            ->get();
        return view('doctor.profile', compact('categories'));
    }


    public function store(Request $request)
    {
        $doctor = auth()->guard('doctor')->user();

        if (!$doctor) {
            return redirect()->back()->with('error', 'Bạn không có quyền đăng bài.');
        }

        // Điều chỉnh validation tùy theo loại bài viết
        $validationRules = [
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'description' => 'required|string',
            'post_cat_id' => 'required|exists:categories,id',
            'post_type' => 'required|in:post,event,story,research,video',
        ];

        // Thêm validation tùy thuộc vào loại bài viết
        if ($request->post_type == 'event') {
            $validationRules['meta_data.event_start_date'] = 'required|date_format:Y-m-d\TH:i';
            $validationRules['meta_data.event_end_date'] = 'required|date_format:Y-m-d\TH:i|after_or_equal:meta_data.event_start_date';
            $validationRules['meta_data.location'] = 'required|string';
        } else if ($request->post_type == 'video') {
            $validationRules['meta_data.video_url'] = 'required|url';
        }

        // Thêm validation cho hình ảnh
        if ($request->image_option == 'upload') {
            $validationRules['photo'] = 'required|image|mimes:webp,jpeg,png,jpg,gif|max:2048';
        } else {
            $validationRules['photo_url'] = 'required|url';
        }

        $request->validate($validationRules);

        // Xử lý metadata
        $metaData = $request->meta_data ?? [];

        // Xử lý đặc biệt cho các trường dạng mảng
        if ($request->post_type == 'research' && isset($metaData['co_authors'])) {
            $metaData['co_authors'] = json_decode($metaData['co_authors']);

            // Xử lý document file nếu có
            if ($request->hasFile('document_file')) {
                $file = $request->file('document_file');
                $fileName = Str::slug($request->title) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = Storage::disk('s3')->putFileAs('documents/research', $file, $fileName, 'public');
                $metaData['document_url'] = Storage::disk('s3')->url($filePath);
            }
        } else if ($request->post_type == 'video' && isset($metaData['topics'])) {
            $metaData['topics'] = json_decode($metaData['topics']);
        }

        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::slug($request->title);
        $post->summary = $request->summary;
        $post->description = $request->description;
        $post->post_cat_id = $request->post_cat_id;
        $post->status = 'active';
        $post->added_by = $doctor->id;
        $post->author_type = 'doctor';
        $post->post_type = $request->post_type;
        $post->tags = $request->tags;
        $post->quote = $request->quote;
        $post->meta_data = $metaData;

        // Xử lý ảnh tùy theo lựa chọn
        if ($request->image_option == 'upload' && $request->hasFile('photo')) {
            // Sử dụng phương thức tải lên hiện có
            $imageUrl = app(ImageController::class)->uploadImage($request);
        } else if ($request->image_option == 'link' && $request->filled('photo_url')) {
            // Sử dụng URL ảnh do người dùng cung cấp
            $imageUrl = $request->photo_url;
        } else {
            // Nếu không có ảnh, sử dụng ảnh mặc định hoặc để trống
            $imageUrl = null;
        }

        $post->photo = $imageUrl;

        try {
            $post->save();
            if (in_array($post->post_cat_id, range(88, 100)) && $request->has('clinic_ids') && !empty($request->clinic_ids)) {
                // Thêm log để debug
                \Log::info('Clinic IDs received:', ['clinic_ids' => $request->clinic_ids]);

                // Chuyển chuỗi IDs thành mảng và lọc các giá trị hợp lệ
                $clinicIds = array_filter(explode(',', $request->clinic_ids), function ($id) {
                    return is_numeric($id) && $id > 0;
                });

                if (!empty($clinicIds)) {
                    \Log::info('Clinic IDs after filtering:', ['clinic_ids' => $clinicIds]);
                    $post->clinics()->sync($clinicIds);
                }
            }
            return redirect()->back()->with('success', 'Bài viết đã được tạo thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi khi lưu bài viết: ' . $e->getMessage());
        }
    }
    // public function update(Request $request, $id)
    // {
    //     // Validate dữ liệu nhập vào
    //     $validationRules = [
    //         'title' => 'required|string|max:255',
    //         'summary' => 'required|string',
    //         'description' => 'required|string',
    //         'post_cat_id' => 'required|exists:categories,id', // Thay đổi bảng từ post_categories thành categories
    //         'edit_image_option' => 'required|in:keep,upload,link',
    //     ];

    //     // Thêm validation tùy thuộc vào lựa chọn người dùng
    //     if ($request->edit_image_option == 'upload') {
    //         $validationRules['photo'] = 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
    //     } else if ($request->edit_image_option == 'link') {
    //         $validationRules['photo_url'] = 'required|url';
    //     }

    //     $request->validate($validationRules);

    //     // Lấy bài viết cần chỉnh sửa
    //     $post = Post::findOrFail($id);
    //     $post->title = $request->title;
    //     $post->summary = $request->summary;
    //     $post->description = $request->description;
    //     $post->post_cat_id = $request->post_cat_id;

    //     // Xử lý ảnh tùy theo lựa chọn của người dùng
    //     if ($request->edit_image_option == 'upload' && $request->hasFile('photo')) {
    //         // Xóa ảnh cũ trên S3 nếu có và nếu không phải URL bên ngoài
    //         if ($post->photo && !filter_var($post->photo, FILTER_VALIDATE_URL)) {
    //             try {
    //                 $oldImagePath = str_replace(Storage::disk('s3')->url(''), '', $post->photo);
    //                 Storage::disk('s3')->delete($oldImagePath);
    //             } catch (\Exception $e) {
    //                 // Ghi log lỗi nhưng vẫn tiếp tục
    //                 \Log::error('Không thể xóa ảnh cũ: ' . $e->getMessage());
    //             }
    //         }

    //         // Upload ảnh mới
    //         $imageUrl = app(ImageController::class)->uploadImage($request);
    //         $post->photo = $imageUrl;
    //     } else if ($request->edit_image_option == 'link' && $request->filled('photo_url')) {
    //         // Cập nhật với URL ảnh mới
    //         $post->photo = $request->photo_url;
    //     }

    //     try {
    //         $post->save();
    //     } catch (\Exception $e) {
    //         return redirect()->back()->with('error', 'Lỗi khi cập nhật bài viết: ' . $e->getMessage());
    //     }

    //     // Trả về thông báo thành công
    //     return redirect()->back()->with('success', 'Bài viết đã được cập nhật!');
    // }
    public function update(Request $request, $id)
    {
        // Validate dữ liệu nhập vào
        $validationRules = [
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'description' => 'required|string',
            'post_cat_id' => 'required|exists:categories,id',
            'post_type' => 'required|in:post,event,story,research,video',
            'edit_image_option' => 'required|in:keep,upload,link',
        ];

        // Thêm validation tùy thuộc vào loại bài viết
        if ($request->post_type == 'event') {
            $validationRules['meta_data.event_start_date'] = 'required|date_format:Y-m-d\TH:i';
            $validationRules['meta_data.event_end_date'] = 'required|date_format:Y-m-d\TH:i|after_or_equal:meta_data.event_start_date';
            $validationRules['meta_data.location'] = 'required|string';
        } else if ($request->post_type == 'video') {
            $validationRules['meta_data.video_url'] = 'required|url';
        }

        // Thêm validation tùy thuộc vào lựa chọn người dùng về ảnh
        if ($request->edit_image_option == 'upload') {
            $validationRules['photo'] = 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
        } else if ($request->edit_image_option == 'link') {
            $validationRules['photo_url'] = 'required|url';
        }

        $request->validate($validationRules);

        // Lấy bài viết cần chỉnh sửa
        $post = Post::findOrFail($id);

        // Cập nhật thông tin cơ bản
        $post->title = $request->title;
        $post->summary = $request->summary;
        $post->description = $request->description;
        $post->post_cat_id = $request->post_cat_id;
        $post->post_type = $request->post_type;
        $post->tags = $request->tags;
        $post->quote = $request->quote;

        // Xử lý metadata
        $metaData = $request->meta_data ?? [];

        // Xử lý đặc biệt cho các trường dạng mảng
        if ($request->post_type == 'research' && isset($metaData['co_authors'])) {
            $metaData['co_authors'] = json_decode($metaData['co_authors']);

            // Xử lý document file nếu có
            if ($request->hasFile('document_file')) {
                // Xóa file cũ nếu có
                if (isset($post->meta_data['document_url'])) {
                    $oldDocPath = str_replace(Storage::disk('s3')->url(''), '', $post->meta_data['document_url']);
                    Storage::disk('s3')->delete($oldDocPath);
                }

                // Upload file mới
                $file = $request->file('document_file');
                $fileName = Str::slug($request->title) . '-' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = Storage::disk('s3')->putFileAs('documents/research', $file, $fileName, 'public');
                $metaData['document_url'] = Storage::disk('s3')->url($filePath);
            } else {
                // Giữ lại đường dẫn tài liệu cũ
                if (isset($post->meta_data['document_url'])) {
                    $metaData['document_url'] = $post->meta_data['document_url'];
                }
            }
        } else if ($request->post_type == 'video' && isset($metaData['topics'])) {
            $metaData['topics'] = json_decode($metaData['topics']);
        }

        // Cập nhật metadata
        $post->meta_data = $metaData;

        // Xử lý ảnh tùy theo lựa chọn của người dùng
        if ($request->edit_image_option == 'upload' && $request->hasFile('photo')) {
            // Xóa ảnh cũ trên S3 nếu có và nếu không phải URL bên ngoài
            if ($post->photo && !filter_var($post->photo, FILTER_VALIDATE_URL)) {
                try {
                    $oldImagePath = str_replace(Storage::disk('s3')->url(''), '', $post->photo);
                    Storage::disk('s3')->delete($oldImagePath);
                } catch (\Exception $e) {
                    // Ghi log lỗi nhưng vẫn tiếp tục
                    \Log::error('Không thể xóa ảnh cũ: ' . $e->getMessage());
                }
            }

            // Upload ảnh mới
            $imageUrl = app(ImageController::class)->uploadImage($request);
            $post->photo = $imageUrl;
        } else if ($request->edit_image_option == 'link' && $request->filled('photo_url')) {
            // Cập nhật với URL ảnh mới
            $post->photo = $request->photo_url;
        }
        // (Nếu lựa chọn là 'keep', thì không cần thay đổi ảnh)

        try {
            $post->save();

            // Xử lý mối quan hệ với bệnh viện/phòng khám nếu là bài viết về phương pháp điều trị
            $treatmentCategoryIds = range(88, 100);
            if (in_array($post->post_cat_id, $treatmentCategoryIds) && $request->has('clinic_ids')) {
                // Nếu bạn đã tạo quan hệ trong model và migration
                $post->clinics()->sync($request->clinic_ids);
            }

            return redirect()->back()->with('success', 'Bài viết đã được cập nhật thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi khi cập nhật bài viết: ' . $e->getMessage());
        }
    }
    public function searchResult(Request $request)
    {
        $q = $request->input('query');

        $posts = Post::with(['user', 'doctor'])
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

    public function getPostData($id)
    {
        try {
            $post = Post::with('cat_info')->findOrFail($id);

            // Lấy danh sách bệnh viện liên kết nếu đây là bài viết về phương pháp điều trị
            $clinics = [];
            $treatmentCategoryIds = range(88, 100);
            if (in_array($post->post_cat_id, $treatmentCategoryIds)) {
                $clinics = $post->clinics()->get();
            }

            return response()->json([
                'success' => true,
                'post' => $post,
                'clinics' => $clinics
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể lấy thông tin bài viết: ' . $e->getMessage()
            ]);
        }
    }
}
