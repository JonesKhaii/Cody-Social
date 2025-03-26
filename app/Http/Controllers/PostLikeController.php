<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Support\Facades\Auth;
use App\Helpers\NotificationHelper;

class PostLikeController extends Controller
{

    public function toggleLike(Request $request)
    {
        $post = Post::findOrFail($request->post_id);
        $user = Auth::guard('web')->user() ?? Auth::guard('doctor')->user();

        if (!$user) {
            return response()->json(['error' => 'Bạn cần đăng nhập để like.'], 401);
        }

        $existingLike = PostLike::where('post_id', $post->id)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('doctor_id', $user->id);
            })->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            PostLike::create([
                'post_id' => $post->id,
                'user_id' => get_class($user) === 'App\\Models\\User' ? $user->id : null,
                'doctor_id' => get_class($user) === 'App\\Models\\Doctor' ? $user->id : null,
            ]);
            $liked = true;

            // Gửi thông báo cho tác giả bài viết khi được like
            $postAuthor = $post->author_info;
            if ($postAuthor && $postAuthor->id !== $user->id) {
                NotificationHelper::send(
                    $postAuthor,
                    'like',
                    '<div class="notification-content">
                        <div class="notification-icon">
                           <i class="fa-solid fa-newspaper"></i>
                        </div>
                        <div class="notification-text">
                            ' . $user->name . ' đã thích bài viết của bạn: 
                            "<strong>' . $post->title . '</strong>"
                        </div>
                    </div>',
                    route('post.detail', ['slug' => $post->slug])
                );
            }
        }

        $likeCount = PostLike::where('post_id', $post->id)->count();

        return response()->json([
            'liked' => $liked,
            'count' => $likeCount
        ]);
    }
}
