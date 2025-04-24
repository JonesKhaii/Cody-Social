<?php

namespace App\Providers;

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
            $categories = \App\Models\PostCategory::select('id', 'title', 'slug')
                ->where('status', 'active')
                ->orderBy('title')  // Sắp xếp theo title
                ->get();

            $view->with('categories', $categories);
        });

        // Trong AppServiceProvider
        View::composer(['layouts.master', 'layouts.header'], function ($view) {
            $parentCategories = PostCategory::where('status', 'active')
                ->whereNull('parent_id')
                ->with(['children' => function ($query) {
                    $query->where('status', 'active');
                }])
                ->orderBy('title')
                ->get();

            $view->with('parentCategories', $parentCategories);
        });
    }
}
