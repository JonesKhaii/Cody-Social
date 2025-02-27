<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    public function toggleLike(Request $request)
    {
        $post = Post::findOrFail($request->post_id);
        $user = Auth::guard('web')->user();
        $doctor = Auth::guard('doctor')->user();

        if (!$user && !$doctor) {
            return response()->json(['error' => 'Bạn cần đăng nhập để like.'], 401);
        }

        $likeData = [
            'post_id' => $post->id,
            'user_id' => $user ? $user->id : null,
            'doctor_id' => $doctor ? $doctor->id : null,
        ];

        $existingLike = PostLike::where($likeData)->first();

        if ($existingLike) {
            // Nếu đã like, thì unlike
            $existingLike->delete();
            return response()->json(['liked' => false, 'message' => 'Bạn đã bỏ like bài viết này.']);
        } else {
            // Nếu chưa like, thì thêm like
            PostLike::create($likeData);
            return response()->json(['liked' => true, 'message' => 'Bạn đã like bài viết này.']);
        }
    }
}
