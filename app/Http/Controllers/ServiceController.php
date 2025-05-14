<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class ServiceController extends Controller
{
    /**
     * Hiển thị trang chính phương pháp điều trị
     */
    public function index()
    {
        // Lấy danh mục cha "Phương pháp điều trị"
        $parentCategory = Category::where('slug', 'dich-vu-y-te')->first();

        // Lấy tất cả danh mục con (cấp 1)
        $serviceCategories = Category::where('parent_id', $parentCategory->id)
            ->orderBy('display_order')
            ->get();
        // Lấy các phương pháp điều trị nổi bật (nếu cần)
        $featuredServices = Post::where('post_type', 'service')
            ->where('is_featured', true)
            ->where('status', 'active')
            ->take(3)
            ->get();

        return view('pages.treatment.index', compact('serviceCategories', 'featuredServices'));
    }
    /**
     * Hiển thị danh sách dịch vụ theo danh mục
     */
    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        // Lấy danh sách các dịch vụ thuộc danh mục này
        $services = Post::where('post_type', 'post')
            ->where(function ($query) use ($category) {
                $query->where('post_cat_id', $category->id)
                    ->orWhereIn('post_cat_id', function ($subQuery) use ($category) {
                        $subQuery->select('id')
                            ->from('categories')
                            ->where('parent_id', $category->id);
                    });
            })
            ->where('status', 'active')
            ->paginate(9);

        // Lấy các danh mục con (nếu có)
        $subcategories = Category::where('parent_id', $category->id)
            ->orderBy('display_order')
            ->get();

        return view('pages.treatment.category', compact('category', 'services', 'subcategories'));
    }

    /**
     * Hiển thị chi tiết dịch vụ
     */
    public function detail($slug)
    {
        $service = Post::where('slug', $slug)
            ->where('post_type', 'post') // Sửa từ 'service' thành 'post'
            ->where('status', 'active')
            ->firstOrFail();

        // Lấy các dịch vụ liên quan
        $relatedServices = Post::where('post_type', 'post')
            ->where('post_cat_id', $service->post_cat_id)
            ->where('id', '!=', $service->id)
            ->where('status', 'active')
            ->take(3)
            ->get();

        // Các phần còn lại giữ nguyên
        $categories = Category::withCount('posts')->orderBy('name')->get();
        $recent_posts = Post::where('status', 'active')->orderBy('created_at', 'DESC')->take(5)->get();


        return view('pages.treatment.detail', compact('service', 'categories', 'recent_posts', 'relatedServices'));
    }
    /**
     * Form đăng ký tư vấn dịch vụ
     */
    public function registerConsultation(Request $request)
    {
        // Logic xử lý form đăng ký tư vấn
        // ...

        return redirect()->back()->with('success', 'Đăng ký tư vấn thành công. Chúng tôi sẽ liên hệ với bạn sớm nhất!');
    }
}
