<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clinic;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DropdownMenuController extends Controller
{
    /**
     * Lấy dữ liệu dropdown bệnh viện và phòng khám
     */
    public function getDropdownData()
    {
        // Sử dụng cache để lưu kết quả (10 phút)
        return Cache::remember('clinics_dropdown_data', 10 * 60, function () {
            // Truy vấn một lần để lấy tất cả dữ liệu cần thiết
            $clinicsByType = Clinic::select('id', 'name', 'photo', 'type')
                ->whereIn('type', ['Bệnh viện', 'Phòng khám'])
                ->latest()
                ->get()
                ->groupBy('type');

            // Tách dữ liệu đã lấy
            $hospitals = isset($clinicsByType['Bệnh viện'])
                ? $clinicsByType['Bệnh viện']->take(5)
                : collect([]);

            $clinics = isset($clinicsByType['Phòng khám'])
                ? $clinicsByType['Phòng khám']->take(5)
                : collect([]);

            // Đếm tổng số từ dữ liệu đã lấy
            $totalHospitals = isset($clinicsByType['Bệnh viện'])
                ? $clinicsByType['Bệnh viện']->count()
                : 0;

            $totalClinics = isset($clinicsByType['Phòng khám'])
                ? $clinicsByType['Phòng khám']->count()
                : 0;

            return [
                'hospitals' => $hospitals,
                'clinics' => $clinics,
                'totalHospitals' => $totalHospitals,
                'totalClinics' => $totalClinics
            ];
        });
    }

    /**
     * API endpoint để lấy dữ liệu dropdown bệnh viện
     */
    public function getClinicsDropdownData()
    {
        return response()->json($this->getDropdownData());
    }

    /**
     * Lấy danh mục bài viết cho dropdown
     */
    public function getPostCategoriesData()
    {
        return Cache::remember('post_categories_dropdown_data', 10 * 60, function () {

            $parentCategories = Category::select('id', 'name', 'slug', 'photo', 'icon')
                ->with(['posts' => function ($query) {
                    $query->select('id', 'post_cat_id')
                        ->where('status', 'active');
                }])
                ->where('status', 'active')
                ->whereNull('parent_id')
                ->orderBy('id')
                ->take(8)
                ->get();

            $childCategories = Category::select('id', 'name', 'slug', 'parent_id', 'photo', 'icon')
                ->with(['posts' => function ($query) {
                    $query->select('id', 'post_cat_id')
                        ->where('status', 'active');
                }])
                ->where('status', 'active')
                ->whereIn('parent_id', $parentCategories->pluck('id')->toArray())
                ->orderBy('id')
                ->get()
                ->groupBy('parent_id');

            $recentPosts = Post::select('id', 'title', 'slug', 'photo', 'created_at', 'post_cat_id')
                ->with(['cat_info:id,name as title,slug'])
                ->where('status', 'active')
                ->latest()
                ->take(5)
                ->get();

            $totalCounts = Cache::remember('total_counts', 30 * 60, function () {
                return [
                    'categories' => Category::where('status', 'active')->count(),
                    'posts' => Post::where('status', 'active')->count()
                ];
            });

            // Xử lý danh mục cha và danh mục con
            foreach ($parentCategories as $category) {
                // Gán danh mục con
                $category->children_with_posts = isset($childCategories[$category->id])
                    ? $childCategories[$category->id]
                    : collect([]);

                // Tính số bài viết
                $category->posts_count = $category->posts->count();

                // Tính tổng số bài viết (bài viết trực tiếp + bài viết trong danh mục con)
                $childPostsCount = 0;

                foreach ($category->children_with_posts as $child) {
                    $child->posts_count = $child->posts->count();
                    $childPostsCount += $child->posts_count;
                }

                $category->total_posts_count = $category->posts_count + $childPostsCount;

                // Loại bỏ quan hệ posts để giảm kích thước dữ liệu gửi đi
                unset($category->posts);
                foreach ($category->children_with_posts as $child) {
                    unset($child->posts);
                }
            }

            return [
                'categories' => $parentCategories,
                'recentPosts' => $recentPosts,
                'totalCategories' => $totalCounts['categories'],
                'totalPosts' => $totalCounts['posts']
            ];
        });
    }

    /**
     * API endpoint để lấy dữ liệu danh mục bài viết
     */
    public function getPostsDropdownData()
    {
        return response()->json($this->getPostCategoriesData());
    }

    /**
     * Lấy tất cả dữ liệu dropdown
     * Phương thức này giúp giảm số truy vấn khi ứng dụng cần tất cả dữ liệu dropdown
     */
    public function getAllDropdownData()
    {

        return Cache::remember('all_dropdown_data', 10 * 60, function () {
            return [
                'clinics' => $this->getDropdownData(),
                'posts' => $this->getPostCategoriesData(),

            ];
        });
    }
}
