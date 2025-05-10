<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
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
        // Sử dụng một view composer duy nhất để tránh trùng lặp truy vấn
        View::composer('*', function ($view) {
            // Sử dụng một cache key duy nhất cho tất cả dữ liệu chung
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
    }
}
