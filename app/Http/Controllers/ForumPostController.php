<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\ForumThread;
use App\Models\ForumPost;
use App\Models\ForumStats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForumPostController extends Controller
{


    // Tạo bài viết mới
    // public function store(Request $request, Category $category, $threadSlug)
    // {
    //     // Tìm chủ đề
    //     $thread = ForumThread::where('slug', $threadSlug)
    //         ->where('category_id', $category->id)
    //         ->firstOrFail();

    //     // Kiểm tra xem chủ đề có bị khóa không
    //     if ($thread->is_locked && !auth()->user()->isAdmin()) {
    //         return back()->with('error', 'Chủ đề này đã bị khóa, không thể thêm bình luận!');
    //     }

    //     // Validate đầu vào
    //     $validated = $request->validate([
    //         'content' => 'required|min:2',
    //         'parent_id' => 'nullable|exists:forum_posts,id'
    //     ]);

    //     // Tạo bài viết
    //     $post = ForumPost::create([
    //         'content' => $validated['content'],
    //         'thread_id' => $thread->id,
    //         'user_id' => auth()->id(),
    //         'parent_id' => $request->parent_id
    //     ]);

    //     // Cập nhật thông tin chủ đề
    //     $thread->increment('reply_count');
    //     $thread->update([
    //         'last_posted_at' => now(),
    //         'last_posted_by' => auth()->id()
    //     ]);

    //     // Cập nhật thống kê
    //     $stats = ForumStats::where('category_id', $category->id)->first();
    //     if ($stats) {
    //         $stats->increment('post_count');
    //         $stats->update([
    //             'last_post_id' => $post->id,
    //             'last_posted_at' => now(),
    //             'last_posted_by' => auth()->id()
    //         ]);
    //     }

    //     return redirect()->route('forum.threads.show', [$category->slug, $thread->slug])
    //         ->with('success', 'Bình luận đã được đăng thành công!');
    // }
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

    // Cập nhật bài viết
    // public function update(Request $request, Category $category, $threadSlug, ForumPost $post)
    // {
    //     $thread = ForumThread::where('slug', $threadSlug)
    //         ->where('category_id', $category->id)
    //         ->firstOrFail();

    //     // Kiểm tra quyền
    //     if (auth()->id() !== $post->user_id && !auth()->user()->isAdmin()) {
    //         abort(403, 'Bạn không có quyền sửa bình luận này');
    //     }

    //     // Validate đầu vào
    //     $validated = $request->validate([
    //         'content' => 'required|min:2',
    //     ]);

    //     // Cập nhật bài viết
    //     $post->update([
    //         'content' => $validated['content']
    //     ]);

    //     return redirect()->route('forum.threads.show', [$category->slug, $thread->slug])
    //         ->with('success', 'Bình luận đã được cập nhật!');
    // }
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


    // Xóa bài viết
    // public function destroy(Category $category, $threadSlug, ForumPost $post)
    // {
    //     $thread = ForumThread::where('slug', $threadSlug)
    //         ->where('category_id', $category->id)
    //         ->firstOrFail();

    //     // Kiểm tra quyền
    //     if (auth()->id() !== $post->user_id && !auth()->user()->isAdmin()) {
    //         abort(403, 'Bạn không có quyền xóa bình luận này');
    //     }

    //     // Đếm số lượng replies sẽ bị xóa
    //     $replyCount = 1 + $post->replies()->count();

    //     // Xóa bài viết
    //     $post->delete();

    //     // Cập nhật thông tin chủ đề
    //     $thread->decrement('reply_count', $replyCount);

    //     // Cập nhật last_posted_at nếu cần
    //     if ($thread->reply_count > 0) {
    //         $lastPost = ForumPost::where('thread_id', $thread->id)
    //             ->orderBy('created_at', 'desc')
    //             ->first();

    //         if ($lastPost) {
    //             $thread->update([
    //                 'last_posted_at' => $lastPost->created_at,
    //                 'last_posted_by' => $lastPost->user_id
    //             ]);
    //         }
    //     } else {
    //         $thread->update([
    //             'last_posted_at' => $thread->created_at,
    //             'last_posted_by' => $thread->user_id
    //         ]);
    //     }

    //     // Cập nhật thống kê
    //     $stats = ForumStats::where('category_id', $category->id)->first();
    //     if ($stats) {
    //         $stats->decrement('post_count', $replyCount);

    //         // Cập nhật thông tin bài viết cuối nếu cần
    //         if ($stats->last_post_id === $post->id) {
    //             $lastPost = ForumPost::whereHas('thread', function ($query) use ($category) {
    //                 $query->where('category_id', $category->id);
    //             })
    //                 ->orderBy('created_at', 'desc')
    //                 ->first();

    //             if ($lastPost) {
    //                 $stats->update([
    //                     'last_post_id' => $lastPost->id,
    //                     'last_posted_at' => $lastPost->created_at,
    //                     'last_posted_by' => $lastPost->user_id
    //                 ]);
    //             } else {
    //                 $lastThread = ForumThread::where('category_id', $category->id)
    //                     ->orderBy('created_at', 'desc')
    //                     ->first();

    //                 if ($lastThread) {
    //                     $stats->update([
    //                         'last_thread_id' => $lastThread->id,
    //                         'last_post_id' => null,
    //                         'last_posted_at' => $lastThread->created_at,
    //                         'last_posted_by' => $lastThread->user_id
    //                     ]);
    //                 }
    //             }
    //         }
    //     }

    //     return redirect()->route('forum.threads.show', [$category->slug, $thread->slug])
    //         ->with('success', 'Bình luận đã được xóa!');
    // }
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

    // Like bài viết
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
}
