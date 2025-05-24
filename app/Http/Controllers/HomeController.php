<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Doctor;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Posts với eager loading author dựa trên author_type
        $posts = Post::select('id', 'title', 'slug', 'summary', 'photo', 'post_cat_id', 'post_tag_id', 'added_by', 'author_type', 'created_at')
            ->where('status', 'active')
            ->with([
                'cat_info:id,name as title',
                // Eager load cả user và doctor, Laravel sẽ chỉ query cái nào cần
                'user:id,name,photo',
                'doctor:id,name,photo'
            ])
            ->withCount(['comments'])
            ->paginate(6);

        // 2. Top viewed posts
        $topViewedPosts = Post::select('id', 'title', 'slug', 'summary', 'photo', 'views', 'post_cat_id', 'post_tag_id', 'added_by', 'author_type', 'created_at')
            ->where('status', 'active')
            ->with([
                'cat_info:id,name as title',
                'user:id,name,photo',
                'doctor:id,name,photo'
            ])
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        // 3. Top doctors
        $topDoctors = Doctor::with('specializations:id,name')
            ->select('id', 'name', 'photo', 'rating')
            ->where('status', true)
            ->orderByDesc('rating')
            ->limit(4)
            ->get();

        // 4. Categories
        $categories = Category::select('id', 'name as title', 'slug')
            ->where('status', 'active')
            ->where('type', 'other')
            ->orderBy('name')
            ->get();

        // 5. Popular categories
        $popularCategories = Category::select('categories.id', 'categories.name as title', 'categories.slug', 'categories.photo')
            ->leftJoin('posts', function ($join) {
                $join->on('categories.id', '=', 'posts.post_cat_id')
                    ->where('posts.status', 'active');
            })
            ->where('categories.type', 'post')
            ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.photo')
            ->orderByRaw('COUNT(posts.id) DESC')
            ->limit(5)
            ->get();

        // Load posts cho categories với eager loading đúng
        $categoryIds = $popularCategories->pluck('id')->toArray();

        $allCategoryPosts = Post::select('id', 'title', 'slug', 'summary', 'photo', 'post_cat_id', 'created_at', 'added_by', 'author_type')
            ->whereIn('post_cat_id', $categoryIds)
            ->where('status', 'active')
            ->with([
                'user:id,name,photo',
                'doctor:id,name,photo'
            ])
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('post_cat_id');

        // Gắn posts vào categories
        foreach ($popularCategories as $category) {
            $category->loaded_posts = $allCategoryPosts->get($category->id, collect())->take(5);
        }

        return view('index', compact('posts', 'topDoctors', 'categories', 'popularCategories', 'topViewedPosts'));
    }

    public function filterPosts(Request $request)
    {
        $categoryTitle = $request->input('category');

        $posts = Post::select('id', 'title', 'slug', 'summary', 'photo', 'post_cat_id', 'post_tag_id', 'added_by', 'author_type', 'created_at')
            ->where('status', 'active')
            ->whereHas('cat_info', function ($query) use ($categoryTitle) {
                $query->where('name', $categoryTitle);
            })
            ->with([
                'cat_info:id,name',
                'tag_info:id,title',
                'user:id,name,photo',
                'doctor:id,name,photo',
            ])
            ->latest()
            ->paginate(6);

        $html = view('partials.posts', compact('posts'))->render();
        return response()->json(['html' => $html]);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        if (strlen($query) < 2) {
            return response()->json(['results' => [], 'count' => 0]);
        }

        $posts = Post::where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('summary', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->with(['user:id,name,photo', 'doctor:id,name,photo'])
            ->take(4)
            ->get(['id', 'title', 'slug', 'author_type', 'added_by'])
            ->map(function ($post) {
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'author' => $post->author_info->name ?? 'N/A',
                    'type' => 'post'
                ];
            });

        $doctors = Doctor::where('status', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                    ->orWhere('bio', 'like', "%{$query}%");
            })
            ->with('specializations:id,name')
            ->take(3)
            ->get(['id', 'name', 'photo'])
            ->map(function ($doctor) {
                return [
                    'id' => $doctor->id,
                    'title' => $doctor->name,
                    'specialty' => $doctor->specializations->first()->name ?? 'Chuyên khoa',
                    'type' => 'doctor'
                ];
            });

        $results = $posts->concat($doctors);
        $count = $results->count();

        return response()->json([
            'results' => $results,
            'count' => $count
        ]);
    }

    public function searchResults(Request $request)
    {
        $q = $request->input('q');

        if (empty($q)) {
            return redirect()->route('home')->with('error', 'Vui lòng nhập từ khóa tìm kiếm');
        }

        $posts = Post::where('status', 'active')
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('summary', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('tags', 'like', "%{$q}%");
            })
            ->with(['cat_info', 'user:id,name,photo', 'doctor:id,name,photo'])
            ->paginate(6);

        $doctors = Doctor::where(function ($query) use ($q) {
            $query->where('name', 'like', "%{$q}%")
                ->orWhere('bio', 'like', "%{$q}%");
        })
            ->orWhereHas('specializations', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->where('status', true)
            ->with('specializations')
            ->paginate(6);

        return view('pages.search-results', compact('posts', 'doctors', 'q'));
    }
}
