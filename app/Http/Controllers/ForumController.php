<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ForumThread;
use App\Models\ForumStats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\JsonResponse;

class ForumController extends Controller
{
    // Trang chính của diễn đàn
    public function index()
    {
        Cache::forget('all_dropdown_data');
        Cache::forget('post_categories_dropdown_data');
        Cache::forget('dropdown_data');
        Cache::forget('total_counts');
        // Lấy danh mục diễn đàn
        $forumCategories = Category::select('id', 'name', 'slug', 'type', 'parent_id', 'icon', 'status', 'display_order', 'summary', 'photo')
            ->where('type', 'forum')
            ->where('status', 'active')
            ->withCount('forumThreads')
            ->with('forumStats')
            ->orderBy('display_order')
            ->get();


        // Lấy các chủ đề mới nhất
        // Trong ForumController
        $latestThreads = ForumThread::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();



        // Lấy các chủ đề đang hot (nhiều lượt xem nhất)
        $popularThreads = ForumThread::with(['user', 'category'])
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get();

        return view('pages.forum.index', compact('forumCategories', 'latestThreads', 'popularThreads'));
    }

    // Trang danh mục
    public function categoryThreads($slug)
    {
        try {
            $category = Category::where('slug', $slug)->first();

            if (!$category) {
                return response()->json(['success' => false, 'message' => 'Không tìm thấy danh mục'], 404);
            }

            $threads = ForumThread::with('user', 'category')
                ->where('category_id', $category->id)
                ->latest()
                ->limit(20)
                ->get();

            $threadsHtml = view('pages.forum.partials.thread_list', compact('threads'))->render();

            return response()->json([
                'success' => true,
                'threads_html' => $threadsHtml
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi máy chủ: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $query = trim($request->input('q'));

        if (strlen($query) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Từ khóa quá ngắn.'
            ]);
        }

        $threads = ForumThread::with('user', 'category')
            ->where('title', 'LIKE', '%' . $query . '%')
            ->orWhere('content', 'LIKE', '%' . $query . '%')
            ->latest()
            ->limit(20)
            ->get();

        if ($threads->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy chủ đề phù hợp.'
            ]);
        }

        $threadsHtml = view('pages.forum.partials.thread_list', compact('threads'))->render();

        return response()->json([
            'success' => true,
            'threads_html' => $threadsHtml
        ]);
    }
}
