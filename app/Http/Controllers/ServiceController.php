<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\Doctor;
use Illuminate\Support\Facades\Cache;

class ServiceController extends Controller
{
    // Dịch vụ tại nhà
    public function index()
    {
        $services = Cache::remember('inhome_services', 3600, function () {
            return Service::active()->orderBy('name')->get();
        });

        return view('pages.inhome-services.index', compact('services'));
    }

    /**
     * Hiển thị chi tiết một dịch vụ
     */
    public function show($slug)
    {
        $service = Cache::remember('service_detail_' . $slug, 3600, function () use ($slug) {
            return Service::where('slug', $slug)
                ->where('is_active', true)
                ->firstOrFail();
        });

        // Lấy các dịch vụ liên quan, nhưng không lấy dữ liệu bác sĩ
        $relatedServices = Cache::remember('related_services_' . $service->id, 3600, function () use ($service) {
            return Service::where('id', '!=', $service->id)
                ->where('is_active', true)
                ->inRandomOrder()
                ->take(3)
                ->get();
        });

        return view('pages.inhome-services.service-detail', compact('service', 'relatedServices'));
    }

    // Treatment methods

    public function treatment_index()
    {
        // Sử dụng cache để tối ưu truy vấn thường xuyên và ít thay đổi
        $parentCategory = Cache::remember('treatment_parent_category', 3600, function () {
            return Category::where('slug', 'dich-vu-y-te')->first();
        });

        $serviceCategories = Cache::remember('treatment_categories', 3600, function () use ($parentCategory) {
            if (!$parentCategory) return collect();

            return Category::where('parent_id', $parentCategory->id)
                ->orderBy('display_order')
                ->withCount(['posts' => function ($query) {
                    $query->where('status', 'active');
                }])
                ->get();
        });

        return view('pages.treatment.index', compact('serviceCategories'));
    }

    public function category($slug)
    {
        $category = Cache::remember('category_' . $slug, 1800, function () use ($slug) {
            return Category::where('slug', $slug)->firstOrFail();
        });

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

        $subcategories = Cache::remember('subcategories_' . $category->id, 1800, function () use ($category) {
            return Category::where('parent_id', $category->id)
                ->orderBy('display_order')
                ->withCount(['posts' => function ($query) {
                    $query->where('status', 'active');
                }])
                ->get();
        });

        return view('pages.treatment.category', compact('category', 'services', 'subcategories'));
    }

    public function detail($slug)
    {
        // Sử dụng cache cho bài viết chi tiết
        $service = Cache::remember('treatment_detail_' . $slug, 1800, function () use ($slug) {
            return Post::with([
                'cat_info:id,name,slug',
                'doctor:id,name,photo,short_bio,bio',
                'doctor.specializations:id,name,slug',
                // Không eager load clinics ở đây để load riêng với các trường cụ thể
            ])
                ->where('slug', $slug)
                ->where('status', 'active')
                ->firstOrFail();
        });

        // Kiểm tra nếu là bài viết phương pháp điều trị
        $isTreatmentPost = $service->isTreatmentPost();

        // Tối ưu việc load clinics cho các bài viết phương pháp điều trị
        if ($isTreatmentPost) {
            // Chỉ load clinics nếu cần thiết, và chỉ lấy các trường cần thiết
            $service->load(['clinics' => function ($query) {
                $query->select('clinics.id', 'name', 'address', 'phone', 'email', 'website', 'photo', 'type', 'slug');
            }]);
        }

        // Cache related services
        $relatedServices = Cache::remember('related_treatment_' . $service->id, 1800, function () use ($service) {
            return Post::where('post_type', 'post')
                ->where('post_cat_id', $service->post_cat_id)
                ->where('id', '!=', $service->id)
                ->where('status', 'active')
                ->take(3)
                ->get(['id', 'title', 'slug', 'summary', 'photo']);
        });

        // Lấy các chuyên gia liên quan - chỉ lấy 2 và cache
        $specialists = Cache::remember('specialists_for_treatment', 3600, function () {
            return Doctor::where('status', 'active')
                ->take(2)
                ->get(['id', 'name', 'photo', 'short_bio']);
        });

        // Lấy danh mục phương pháp điều trị từ cache
        $parentCategory = Cache::remember('treatment_parent_category', 3600, function () {
            return Category::where('slug', 'dich-vu-y-te')->first(['id', 'name', 'slug']);
        });

        $serviceCategories = Cache::remember('service_categories_sidebar', 3600, function () use ($parentCategory) {
            if (!$parentCategory) return collect();

            return Category::where('parent_id', $parentCategory->id)
                ->orderBy('display_order')
                ->withCount(['posts' => function ($query) {
                    $query->where('status', 'active');
                }])
                ->get(['id', 'name', 'slug', 'display_order']);
        });

        return view('pages.treatment.detail', compact(
            'service',
            'specialists',
            'relatedServices',
            'isTreatmentPost',
            'serviceCategories'
        ));
    }
}
