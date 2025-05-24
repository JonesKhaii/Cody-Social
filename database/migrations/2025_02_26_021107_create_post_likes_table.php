<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Doctor;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Cache static data (không paginate) 30 phút
        $staticData = Cache::remember('homepage_static_data', 1800, function () {

            // Top viewed posts với eager loading
            $topViewedPosts = Post::select('id', 'title', 'slug', 'summary', 'photo', 'views', 'post_cat_id', 'added_by', 'author_type')
                ->where('status', 'active')
                ->with([
                    'cat_info:id,name',
                    'author_info:id,name,photo'
                ])
                ->orderByDesc('views')
                ->limit(5)
                ->get();

            // Top doctors
            $topDoctors = Doctor::select('id', 'name', 'photo', 'rating')
                ->where('status', true)
                ->with(['specializations' => function ($query) {
                    $query->select('categories.id', 'categories.name')
                        ->where('categories.type', 'other');
                }])
                ->orderByDesc('rating')
                ->limit(4)
                ->get();

            // Categories for filter
            $categories = Category::select('id', 'name', 'slug')
                ->where('status', 'active')
                ->where('type', 'other')
                ->orderBy('name')
                ->get();

            // Popular categories
            $popularCategories = Category::select('categories.id', 'categories.name as title', 'categories.slug', 'categories.photo')
                ->leftJoin('posts', function ($join) {
                    $join->on('categories.id', '=', 'posts.post_cat_id')
                        ->where('posts.status', 'active');
                })
                ->where('categories.type', 'post')
                ->where('categories.status', 'active')
                ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.photo')
                ->orderByRaw('COUNT(posts.id) DESC')
                ->limit(5)
                ->get();

            // Preload posts cho mỗi category
            $categoryPosts = [];
            foreach ($popularCategories as $category) {
                $categoryPosts[$category->id] = Post::select('id', 'title', 'slug', 'summary', 'photo')
                    ->where('status', 'active')
                    ->where('post_cat_id', $category->id)
                    ->latest()
                    ->limit(5)
                    ->get();
            }

            return compact('topViewedPosts', 'topDoctors', 'categories', 'popularCategories', 'categoryPosts');
        });

        // Posts cần paginate, không cache
        $posts = Post::select('id', 'title', 'slug', 'summary', 'photo', 'post_cat_id', 'post_tag_id', 'added_by', 'author_type', 'created_at')
            ->where('status', 'active')
            ->with([
                'cat_info:id,name',
                'author_info:id,name,photo'
            ])
            ->withCount('comments')
            ->latest()
            ->paginate(6);

        return view('index', array_merge($staticData, compact('posts')));
    }

    public function filterPosts(Request $request)
    {
        $categoryTitle = $request->input('category');

        $posts = Post::select('id', 'title', 'slug', 'summary', 'photo', 'post_cat_id', 'created_at')
            ->where('status', 'active')
            ->whereHas('cat_info', function ($query) use ($categoryTitle) {
                $query->where('name', $categoryTitle);
            })
            ->with([
                'cat_info:id,name',
                'author_info:id,name,photo',
            ])
            ->latest()
            ->paginate(6); // Dùng paginate cho AJAX

        $html = view('partials.posts', compact('posts'))->render();
        return response()->json(['html' => $html]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        if (strlen($query) < 2) {
            return response()->json(['results' => [], 'count' => 0]);
        }

        // Cache search results 5 phút
        $cacheKey = 'search_' . md5($query);

        $results = Cache::remember($cacheKey, 300, function () use ($query) {

            // Search posts
            $posts = Post::select('id', 'title', 'slug', 'added_by', 'author_type')
                ->where('status', 'active')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                        ->orWhere('summary', 'like', "%{$query}%");
                })
                ->with('author_info:id,name')
                ->limit(4)
                ->get()
                ->map(function ($post) {
                    return [
                        'id' => $post->id,
                        'title' => $post->title,
                        'slug' => $post->slug,
                        'author' => $post->author_info->name ?? 'N/A',
                        'type' => 'post'
                    ];
                });

            // Search doctors
            $doctors = Doctor::select('id', 'name')
                ->where('status', true)
                ->where('name', 'like', "%{$query}%")
                ->with(['specializations' => function ($query) {
                    $query->select('categories.id', 'categories.name')
                        ->where('categories.type', 'other');
                }])
                ->limit(3)
                ->get()
                ->map(function ($doctor) {
                    return [
                        'id' => $doctor->id,
                        'title' => $doctor->name,
                        'specialty' => $doctor->specializations->first()->name ?? 'Chuyên khoa',
                        'type' => 'doctor'
                    ];
                });

            return $posts->concat($doctors);
        });

        return response()->json([
            'results' => $results,
            'count' => $results->count()
        ]);
    }

    public function searchResults(Request $request)
    {
        $q = $request->input('q');

        if (empty($q)) {
            return redirect()->route('home')->with('error', 'Vui lòng nhập từ khóa tìm kiếm');
        }

        // Posts với pagination
        $posts = Post::select('id', 'title', 'slug', 'summary', 'photo', 'post_cat_id', 'added_by', 'author_type', 'created_at')
            ->where('status', 'active')
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('summary', 'like', "%{$q}%");
            })
            ->with(['cat_info:id,name', 'author_info:id,name,photo'])
            ->paginate(6);

        // Doctors với pagination
        $doctors = Doctor::select('id', 'name', 'photo', 'bio')
            ->where('status', true)
            ->where('name', 'like', "%{$q}%")
            ->with(['specializations' => function ($query) {
                $query->select('categories.id', 'categories.name')
                    ->where('categories.type', 'other');
            }])
            ->paginate(6);

        return view('pages.search-results', compact('posts', 'doctors', 'q'));
    }
}
