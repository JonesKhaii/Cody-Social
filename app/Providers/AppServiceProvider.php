<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Post;
use App\Models\Doctor;
use App\Http\Controllers\DropdownMenuController;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Cache global data cho header và shared components
        View::composer([
            'layouts.header',
            'layouts.partials.dropdown-templates.*',
            'pages.specialties.*',
            'pages.post-detail'
        ], function ($view) {
            // Cache global data với TTL 1 giờ
            $globalData = Cache::remember('global_view_data', 60 * 60, function () {
                // Tạo controller instance chỉ một lần
                $dropdownController = new DropdownMenuController();

                // Lấy tất cả dữ liệu dropdown thông qua một phương thức duy nhất
                $allDropdownData = $dropdownController->getAllDropdownData();

                // Lấy danh mục kèm số bài viết
                $categories = Category::select('id', 'name as title', 'slug')
                    ->with(['posts' => function ($query) {
                        $query->select('id', 'post_cat_id')
                            ->where('status', 'active');
                    }])
                    ->where('status', 'active')
                    ->where('type', 'post')
                    ->whereHas('posts', function ($query) {
                        $query->where('status', 'active');
                    })
                    ->orderBy('name')
                    ->get()
                    ->map(function ($category) {
                        $category->posts_count = $category->posts->count();
                        unset($category->posts); // Loại bỏ relation để giảm kích thước
                        return $category;
                    });

                // Lấy menu cha/con trong một lần truy vấn
                $allCategories = Category::select('id', 'name as title', 'slug', 'parent_id')
                    ->where('status', 'active')
                    ->where('type', 'post')
                    ->orderBy('name')
                    ->get();

                $parentCategories = $allCategories->whereNull('parent_id');
                $childCategories = $allCategories->whereNotNull('parent_id')->groupBy('parent_id');

                return [
                    'categories' => $categories,
                    'parentCategories' => $parentCategories,
                    'menu_categories' => [
                        'parents' => $parentCategories,
                        'children' => $childCategories
                    ],
                    'dropdownData' => $allDropdownData
                ];
            });

            // Đẩy biến ra View
            $view->with($globalData);
        });

        // Cache site statistics cho trang chủ và footer
        View::composer([
            'index',
            'layouts.footer',
            'pages.about'
        ], function ($view) {
            $siteStats = Cache::remember('site_statistics', 60 * 60 * 2, function () {
                return [
                    'total_posts' => Post::where('status', 'active')->count(),
                    'total_doctors' => Doctor::where('status', true)->count(),
                    'total_categories' => Category::where('status', 'active')
                        ->where('type', 'post')
                        ->count(),
                    'total_views' => Post::where('status', 'active')->sum('views'),
                    // Thêm một số stats khác nếu cần
                    'active_specialties' => \DB::table('doctor_specializations')
                        ->join('doctors', 'doctors.id', '=', 'doctor_specializations.doctor_id')
                        ->where('doctors.status', true)
                        ->distinct('doctor_specializations.specialization_id')
                        ->count(),
                ];
            });

            $view->with('site_stats', $siteStats);
        });

        // Cache trending/popular content cho sidebar và recommendations
        View::composer([
            'layouts.sidebar',
            'pages.post-detail',
            'pages.category-show'
        ], function ($view) {
            $trendingData = Cache::remember('trending_content', 60 * 30, function () {
                return [
                    // Top 5 bài viết xem nhiều nhất tuần này
                    'weekly_trending_posts' => Post::select('id', 'title', 'slug', 'photo', 'views')
                        ->where('status', 'active')
                        ->where('created_at', '>=', now()->subWeek())
                        ->orderByDesc('views')
                        ->limit(5)
                        ->get(),

                    // Top categories theo số bài viết
                    'popular_categories' => Category::select('id', 'name as title', 'slug')
                        ->withCount(['posts' => function ($query) {
                            $query->where('status', 'active');
                        }])
                        ->where('status', 'active')
                        ->where('type', 'post')
                        ->having('posts_count', '>', 0)
                        ->orderByDesc('posts_count')
                        ->limit(8)
                        ->get(),

                    // Recent posts (cache để tránh query lặp)
                    'recent_posts' => Post::select('id', 'title', 'slug', 'created_at')
                        ->where('status', 'active')
                        ->latest()
                        ->limit(10)
                        ->get(),
                ];
            });

            $view->with('trending_data', $trendingData);
        });

        // Cache user preferences và settings (nếu có authentication)
        if (auth()->check()) {
            View::composer('*', function ($view) {
                $userPreferences = Cache::remember(
                    'user_preferences_' . auth()->id(),
                    60 * 60 * 24, // Cache 24h cho user preferences
                    function () {
                        return [
                            'favorite_categories' => auth()->user()->favoriteCategories ?? collect(),
                            'reading_history' => auth()->user()->readingHistory()->limit(10)->get() ?? collect(),
                            'bookmarked_posts' => auth()->user()->bookmarkedPosts ?? collect(),
                        ];
                    }
                );

                $view->with('user_preferences', $userPreferences);
            });
        }
    }
}
