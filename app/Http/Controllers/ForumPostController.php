<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Post;
use App\Models\ForumThread;
use App\Models\ForumPost;
use App\Models\ForumStats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForumPostController extends Controller
{


    // ====================Dành riêng cho thread==========================

    public function store(Request $request, Category $category, $threadSlug)
    {
        $thread = ForumThread::where('slug', $threadSlug)
            ->where('category_id', $category->id)
            ->firstOrFail();

        if ($thread->is_locked && !auth()->user()->isAdmin()) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Chủ đề bị khóa'], 403);
            }
            return back()->with('error', 'Chủ đề này đã bị khóa, không thể thêm bình luận!');
        }

        $validated = $request->validate([
            'content' => 'required|min:2',
            'parent_id' => 'nullable|exists:forum_posts,id'
        ]);

        $post = ForumPost::create([
            'content' => $validated['content'],
            'thread_id' => $thread->id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id
        ]);

        $thread->increment('reply_count');
        $thread->update([
            'last_posted_at' => now(),
            'last_posted_by' => auth()->id()
        ]);

        $stats = ForumStats::where('category_id', $category->id)->first();
        if ($stats) {
            $stats->increment('post_count');
            $stats->update([
                'last_post_id' => $post->id,
                'last_posted_at' => now(),
                'last_posted_by' => auth()->id()
            ]);
        }

        // ✅ Nếu là AJAX/fetch
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'post' => [
                    'id' => $post->id,
                    'user_name' => auth()->user()->name,
                    'user_photo' => auth()->user()->photo ?? asset('images/avatar-placeholder.png'),
                    'content' => $post->content,
                    'created_at' => $post->created_at->format('d/m/Y H:i'),
                ]
            ]);
        }

        // ✅ Nếu là form submit thông thường
        return redirect()->route('forum.threads.show', [$category->slug, $thread->slug])
            ->with('success', 'Bình luận đã được đăng thành công!');
    }

    // Hiển thị form sửa bài viết
    public function edit(Category $category, $threadSlug, ForumPost $post)
    {
        $thread = ForumThread::where('slug', $threadSlug)
            ->where('category_id', $category->id)
            ->firstOrFail();

        // Kiểm tra quyền
        if (auth()->id() !== $post->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Bạn không có quyền sửa bình luận này');
        }

        return view('pages.forum.posts.edit', compact('category', 'thread', 'post'));
    }


    public function update(Request $request, Category $category, $threadSlug, ForumPost $post)
    {
        $thread = ForumThread::where('slug', $threadSlug)
            ->where('category_id', $category->id)
            ->firstOrFail();

        if (auth()->id() !== $post->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Không có quyền chỉnh sửa bình luận này');
        }

        $validated = $request->validate([
            'content' => 'required|min:2',
        ]);

        $post->update([
            'content' => $validated['content']
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'post' => [
                    'id' => $post->id,
                    'content' => $post->content,
                ]
            ]);
        }

        return back()->with('success', 'Cập nhật bình luận thành công!');
    }

    public function destroy(Request $request, Category $category, $threadSlug, ForumPost $post)
    {
        $thread = ForumThread::where('slug', $threadSlug)
            ->where('category_id', $category->id)
            ->firstOrFail();

        if (auth()->id() !== $post->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Bạn không có quyền xóa bình luận này');
        }

        $replyCount = 1 + $post->replies()->count();
        $post->delete();

        $thread->decrement('reply_count', $replyCount);

        if ($thread->reply_count > 0) {
            $lastPost = ForumPost::where('thread_id', $thread->id)
                ->orderBy('created_at', 'desc')->first();

            if ($lastPost) {
                $thread->update([
                    'last_posted_at' => $lastPost->created_at,
                    'last_posted_by' => $lastPost->user_id
                ]);
            }
        } else {
            $thread->update([
                'last_posted_at' => $thread->created_at,
                'last_posted_by' => $thread->user_id
            ]);
        }

        $stats = ForumStats::where('category_id', $category->id)->first();
        if ($stats) {
            $stats->decrement('post_count', $replyCount);

            if ($stats->last_post_id === $post->id) {
                $lastPost = ForumPost::whereHas('thread', function ($q) use ($category) {
                    $q->where('category_id', $category->id);
                })->orderBy('created_at', 'desc')->first();

                if ($lastPost) {
                    $stats->update([
                        'last_post_id' => $lastPost->id,
                        'last_posted_at' => $lastPost->created_at,
                        'last_posted_by' => $lastPost->user_id
                    ]);
                } else {
                    $lastThread = ForumThread::where('category_id', $category->id)
                        ->orderBy('created_at', 'desc')->first();

                    if ($lastThread) {
                        $stats->update([
                            'last_thread_id' => $lastThread->id,
                            'last_post_id' => null,
                            'last_posted_at' => $lastThread->created_at,
                            'last_posted_by' => $lastThread->user_id
                        ]);
                    }
                }
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('forum.threads.show', [$category->slug, $thread->slug])
            ->with('success', 'Bình luận đã được xóa!');
    }

    public function like(Request $request, Category $category, $threadSlug, ForumPost $post)
    {
        try {
            // Kiểm tra đăng nhập
            if (!(Auth::guard('web')->check() || Auth::guard('doctor')->check())) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần đăng nhập để thích bài viết'
                ], 403);
            }

            // Lấy thông tin user
            $userId = Auth::guard('web')->check() ? Auth::id() : Auth::guard('doctor')->id();
            $guardName = Auth::guard('web')->check() ? 'web' : 'doctor';

            // Kiểm tra đã like chưa
            $existing = DB::table('forum_post_likes')
                ->where('post_id', $post->id)
                ->where('user_id', $userId)
                ->where('guard_name', $guardName)
                ->first();

            if ($existing) {
                DB::table('forum_post_likes')
                    ->where('post_id', $post->id)
                    ->where('user_id', $userId)
                    ->where('guard_name', $guardName)
                    ->delete();
                $post->decrement('like_count');
                $post->refresh();

                return response()->json([
                    'success' => true,
                    'liked' => false,
                    'likes' => $post->like_count
                ]);
            } else {
                DB::table('forum_post_likes')->insert([
                    'post_id' => $post->id,
                    'user_id' => $userId,
                    'guard_name' => $guardName,
                    'created_at' => now()
                ]);
                $post->increment('like_count');
                $post->refresh();

                return response()->json([
                    'success' => true,
                    'liked' => true,
                    'likes' => $post->like_count
                ]);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ], 500);
        }
    }




    // ======= Post=================================


    public function categoryPosts($slug)
    {

        $category = Category::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        $categoryPosts = Post::where('post_cat_id', $category->id)
            ->where('status', 'active')
            ->select('id', 'title', 'slug', 'summary', 'photo', 'created_at', 'updated_at')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categories = Category::where('type', 'forum')
            ->where('status', 'active')
            ->select('id', 'name', 'slug')
            ->orderBy('display_order')
            ->get();

        return view('pages.forum.posts.posts_category', compact('category', 'categoryPosts', 'categories'));
    }


    public function showCategoryPost($categorySlug, $postSlug)
    {

        $category = Category::where('slug', $categorySlug)
            ->where('status', 'active')
            ->firstOrFail();


        $categoryPost = Post::where('slug', $postSlug)
            ->where('post_cat_id', $category->id)
            ->where('status', 'active')
            ->with(['cat_info', 'author_info'])
            ->firstOrFail();

        $relatedCategoryPosts = Post::where('post_cat_id', $category->id)
            ->where('id', '!=', $categoryPost->id)
            ->where('status', 'active')
            ->select('id', 'title', 'slug', 'photo', 'summary')
            ->orderBy('created_at', 'desc')
            ->limit(4)
            ->get();


        $relatedThreads = ForumThread::where('category_id', $category->id)
            ->select('id', 'title', 'slug', 'user_id', 'reply_count', 'created_at')
            ->with(['user:id,name,photo'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $popularCategoryPosts = Post::where('status', 'active')
            ->select('id', 'title', 'slug', 'photo', 'post_cat_id')
            ->with(['cat_info:id,name,slug'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Lấy tất cả danh mục
        $categories = Category::where('type', 'forum')
            ->where('status', 'active')
            ->select('id', 'name', 'slug')
            ->orderBy('display_order')
            ->get();

        return view('pages.forum.posts.post_detail', compact(
            'categoryPost',
            'category',
            'relatedCategoryPosts',
            'relatedThreads',
            'popularCategoryPosts',
            'categories'
        ));
    }

    public function incrementCategoryPostViews($categorySlug, $postSlug)
    {
        $categoryPost = Post::where('slug', $postSlug)
            ->where('status', 'active')
            ->first();

        if ($categoryPost) {
            // Nếu có trường view_count trong bảng posts, tăng số lượt xem
            if (Schema::hasColumn('posts', 'view_count')) {
                $categoryPost->increment('view_count');
            }
        }

        return response()->json(['success' => true]);
    }


    public function getFeaturedCategoryPosts()
    {
        $featuredCategoryPosts = Post::where('status', 'active')
            ->where('is_featured', 1)
            ->select('id', 'title', 'slug', 'summary', 'photo', 'post_cat_id')
            ->with(['category:id,name,slug'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return response()->json([
            'success' => true,
            'posts' => $featuredCategoryPosts
        ]);
    }

    public function searchCategoryPosts(Request $request)
    {
        $query = trim($request->input('q'));

        if (strlen($query) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Từ khóa quá ngắn.'
            ]);
        }

        $categoryPosts = Post::where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', '%' . $query . '%')
                    ->orWhere('summary', 'LIKE', '%' . $query . '%')
                    ->orWhere('description', 'LIKE', '%' . $query . '%');
            })
            ->select('id', 'title', 'slug', 'summary', 'photo', 'post_cat_id', 'created_at')
            ->with(['category:id,name,slug'])
            ->orderBy('created_at', 'desc')
            ->limit(20)
            ->get();

        if ($categoryPosts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy bài viết phù hợp.'
            ]);
        }

        $categoryPostsHtml = view('pages.forum.post.partials.post_list', compact('categoryPosts'))->render();

        return response()->json([
            'success' => true,
            'posts_html' => $categoryPostsHtml
        ]);
    }
}
