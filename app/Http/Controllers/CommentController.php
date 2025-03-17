<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::guard('web')->user() ?? Auth::guard('doctor')->user();

        if (!$user) {
            return back()->with('error', 'Bạn cần đăng nhập để bình luận.');
        }

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'comment' => $request->comment,
            'status' => 'active',
            'parent_id' => $request->parent_id,
            'replied_comment' => $request->parent_id ? $request->replied_comment : null,
            'user_id' => get_class($user) === 'App\\Models\\User' ? $user->id : null,
            'doctor_id' => get_class($user) === 'App\\Models\\Doctor' ? $user->id : null,
        ]);

        // Gửi thông báo cho tác giả bài viết
        $post = Post::findOrFail($request->post_id);
        $postAuthor = $post->author_info;
        if ($postAuthor && $postAuthor->id !== $user->id) {
            NotificationHelper::send(
                $postAuthor,
                'comment',
                $user->name . ' đã bình luận về bài viết của bạn: "' . $post->title . '".',
                route('post.detail', ['slug' => $post->slug])
            );
        }

        return back()->with('success', 'Bình luận của bạn đã được thêm.');
    }
}
