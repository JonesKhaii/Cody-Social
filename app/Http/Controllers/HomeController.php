<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Doctor;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Danh sách categories (cache 1h)
        $categories = Cache::remember('home_categories_simple', 3600, function () {
            return Category::select('id', 'name as title', 'slug')
                ->where('status', 'active')
                ->where('type', 'other')
                ->orderBy('name')
                ->get();
        });

        // 2. Top doctors (cache 30 phút)
        $topDoctors = Cache::remember('home_top_doctors_simple', 1800, function () {
            return Doctor::select('id', 'name', 'photo', 'rating')
                ->with('specializations:id,name')
                ->where('status', true)
                ->orderByDesc('rating')
                ->limit(4)
                ->get();
        });

        // 3. Popular categories (cache 30 phút)
        $popularCategories = Category::select([
            'categories.id',
            'categories.name as title',
            'categories.slug',
            'categories.photo'
        ])
            ->leftJoin('posts', function ($join) {
                $join->on('categories.id', '=', 'posts.post_cat_id')
                    ->where('posts.status', 'active');
            })
            ->where('categories.type', 'other')
            ->where('categories.status', 'active')
            ->groupBy('categories.id', 'categories.name', 'categories.slug', 'categories.photo')
            ->havingRaw('COUNT(posts.id) > 0')
            ->orderByRaw('COUNT(posts.id) DESC')
            ->limit(5)
            ->get();

        // 4. Lấy tất cả posts cần thiết - KHÔNG dùng with()
        $allPosts = Post::select([
            'id',
            'title',
            'slug',
            'summary',
            'photo',
            'views',
            'post_cat_id',
            'added_by',
            'author_type',
            'created_at'
        ])
            ->where('status', 'active')
            ->latest()
            ->limit(50)
            ->get();

        // 5. Lấy tất cả user IDs và doctor IDs
        $userIds = $allPosts->where('author_type', 'user')->pluck('added_by')->unique()->filter();
        $doctorIds = $allPosts->where('author_type', 'doctor')->pluck('added_by')->unique()->filter();

        // 6. Load tất cả users cần thiết
        $users = collect();
        if ($userIds->isNotEmpty()) {
            $users = User::select('id', 'name', 'photo')
                ->whereIn('id', $userIds)
                ->get()
                ->keyBy('id');
        }

        // 7. Load tất cả doctors cần thiết  
        $doctors = collect();
        if ($doctorIds->isNotEmpty()) {
            $doctors = Doctor::select('id', 'name', 'photo')
                ->whereIn('id', $doctorIds)
                ->get()
                ->keyBy('id');
        }

        // 8. Load categories cho posts
        $postCategoryIds = $allPosts->pluck('post_cat_id')->unique()->filter();
        $postCategories = Category::select('id', 'name')
            ->whereIn('id', $postCategoryIds)
            ->get()
            ->keyBy('id');

        // 9. Gán authors và categories cho posts (trong memory - không query DB)
        foreach ($allPosts as $post) {
            // Gán author
            if ($post->author_type === 'doctor') {
                $author = $doctors->get($post->added_by);
                $post->author = $author;
                $post->setRelation('doctor', $author);
                $post->setRelation('user', null);
            } else {
                $author = $users->get($post->added_by);
                $post->author = $author;
                $post->setRelation('user', $author);
                $post->setRelation('doctor', null);
            }

            // Gán category info
            $category = $postCategories->get($post->post_cat_id);
            $post->cat_info = $category;
            $post->setRelation('cat_info', $category);
        }
        // 10. Phân chia posts (trong memory - không query DB)
        $posts = $allPosts->take(6);

        $topViewedPosts = $allPosts->sortByDesc('views')->take(5)->values();

        // 11. Posts theo categories
        $categoryIds = $popularCategories->pluck('id')->toArray();
        $categoryPostsGrouped = $allPosts->whereIn('post_cat_id', $categoryIds)->groupBy('post_cat_id');

        foreach ($popularCategories as $category) {
            $category->loaded_posts = $categoryPostsGrouped->get($category->id, collect())->take(5);
        }

        return view('index', compact(
            'posts',
            'topViewedPosts',
            'topDoctors',
            'categories',
            'popularCategories'
        ));
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
                $author = $post->author_type === 'doctor' ? $post->doctor : $post->user;
                return [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'author' => $author->name ?? 'N/A',
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
