<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\ForumThread;
use App\Models\ForumPost;
use App\Models\ForumStats;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ForumThreadController extends Controller
{


    // Hiển thị trang tạo chủ đề mới
    public function create(Category $category)
    {
        // Kiểm tra danh mục
        if ($category->type !== 'forum') {
            abort(404);
        }

        return view('pages.forum.threads.create', compact('category'));
    }

    // Xử lý tạo chủ đề mới
    public function store(Request $request): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|min:5|max:255',
            'content' => 'required|min:10',
            'category_id' => 'required|exists:categories,id'
        ]);

        $category = Category::where('id', $validated['category_id'])
            ->where('type', 'forum')
            ->firstOrFail();

        $slug = ForumThread::createSlug($validated['title']);

        $thread = ForumThread::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'content' => $validated['content'],
            'category_id' => $category->id,
            'user_id' => auth()->id(),
            'last_posted_at' => now(),
            'last_posted_by' => auth()->id()
        ]);

        // Cập nhật thống kê
        ForumStats::updateOrCreate(
            ['category_id' => $category->id],
            ['last_thread_id' => $thread->id, 'last_posted_at' => now(), 'last_posted_by' => auth()->id()]
        );

        // Nếu là AJAX (submit từ modal)
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tạo chủ đề thành công!',
                'thread' => [
                    'title' => $thread->title,
                    'slug' => $thread->slug,
                    'content' => $thread->content,
                    'category_slug' => $category->slug,
                    'created_at' => $thread->created_at->diffForHumans(),
                    'user_name' => auth()->user()->name,
                    'user_photo' => auth()->user()->photo ?? asset('images/avatar-placeholder.png')
                ]
            ]);
        }

        // Bình thường (nếu cần fallback)
        return redirect()->route('forum.threads.show', [$category->slug, $thread->slug])
            ->with('success', 'Tạo chủ đề thành công!');
    }


    // Hiển thị chủ đề và bài viết
    public function show(Category $category, $threadSlug)
    {
        // Tìm chủ đề theo slug
        $thread = ForumThread::where('slug', $threadSlug)
            ->where('category_id', $category->id)
            ->firstOrFail();

        // Tăng số lượt xem
        $thread->increment('view_count');

        // Lấy bài viết trong chủ đề
        $posts = ForumPost::where('thread_id', $thread->id)
            ->with(['user', 'replies.user'])
            ->whereNull('parent_id') // Chỉ lấy các bài viết gốc, không phải reply
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('pages.forum.threads.show', compact('category', 'thread', 'posts'));
    }

    // Hiển thị form sửa chủ đề
    public function update(Request $request, Category $category, $threadSlug)
    {
        $thread = ForumThread::where('slug', $threadSlug)
            ->where('category_id', $category->id)
            ->firstOrFail();

        // Xác định người dùng
        $user = Auth::guard('web')->user() ?? Auth::guard('doctor')->user();

        if (!$user || ($user->id !== $thread->user_id && !$user->isAdmin())) {
            abort(403, 'Bạn không có quyền chỉnh sửa chủ đề này');
        }

        $validated = $request->validate([
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:5',
        ]);

        $thread->update($validated);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'thread' => [
                    'title' => $thread->title,
                    'content' => $thread->content
                ]
            ]);
        }

        return redirect()->route('forum.threads.show', [$category->slug, $thread->slug])
            ->with('success', 'Cập nhật chủ đề thành công!');
    }


    // Xóa chủ đề
    public function destroy(Category $category, $threadSlug)
    {
        $thread = ForumThread::where('slug', $threadSlug)
            ->where('category_id', $category->id)
            ->firstOrFail();

        if (auth()->id() !== $thread->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Bạn không có quyền xóa chủ đề này');
        }

        $thread->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'redirect_url' => route('forum.category', $category->slug)
            ]);
        }

        return redirect()->route('forum.index', $category->slug)
            ->with('success', 'Xóa chủ đề thành công!');
    }
}
