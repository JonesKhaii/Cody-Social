<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\PostCategory;

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
        View::composer('*', function ($view) {

            // Lấy danh mục kèm số bài viết
            $categories = Cache::remember('global_categories', 3600, function () {
                return PostCategory::withCount('posts')
                    ->addSelect(['id', 'title', 'slug'])
                    ->where('status', 'active')
                    ->having('posts_count', '>', 0)
                    ->orderBy('title')
                    ->get();
            });


            // Lấy menu cha/con
            $menu_data = Cache::remember('menu_categories', 3600, function () {
                $parent_categories = PostCategory::select('id', 'title', 'slug')
                    ->where('status', 'active')
                    ->whereNull('parent_id')
                    ->orderBy('title')
                    ->get();

                $child_categories = PostCategory::select('id', 'title', 'slug', 'parent_id')
                    ->where('status', 'active')
                    ->whereNotNull('parent_id')
                    ->orderBy('title')
                    ->get()
                    ->groupBy('parent_id');

                return [
                    'parents' => $parent_categories,
                    'children' => $child_categories
                ];
            });

            // Đẩy biến ra View
            $view->with('categories', $categories);
            $view->with('menu_categories', $menu_data);
            $view->with('parentCategories', $menu_data['parents']);
        });
    }
}
