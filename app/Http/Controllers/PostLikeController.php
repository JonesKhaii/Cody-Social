<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostLike;
use Illuminate\Support\Facades\Auth;

class PostLikeController extends Controller
{
    // public function toggleLike(Request $request)
    // {
    //     $post = Post::findOrFail($request->post_id);
    //     $user = Auth::guard('web')->user();
    //     $doctor = Auth::guard('doctor')->user();

    //     if (!$user && !$doctor) {
    //         return response()->json(['error' => 'Bạn cần đăng nhập để like.'], 401);
    //     }

    //     $likeData = [
    //         'post_id' => $post->id,
    //         'user_id' => $user ? $user->id : null,
    //         'doctor_id' => $doctor ? $doctor->id : null,
    //     ];

    //     $existingLike = PostLike::where($likeData)->first();

    //     if ($existingLike) {
    //         // Nếu đã like, thì unlike
    //         $existingLike->delete();
    //         return response()->json(['liked' => false, 'message' => 'Bạn đã bỏ like bài viết này.']);
    //     } else {
    //         // Nếu chưa like, thì thêm like
    //         PostLike::create($likeData);
    //         return response()->json(['liked' => true, 'message' => 'Bạn đã like bài viết này.']);
    //     }
    // }
    public function toggleLike(Request $request)
    {
        $post = Post::findOrFail($request->post_id);
        $user = Auth::guard('web')->user() ?? Auth::guard('doctor')->user(); // Kiểm tra user hoặc doctor

        if (!$user) {
            return response()->json(['error' => 'Bạn cần đăng nhập để like.'], 401);
        }

        // Kiểm tra xem user hoặc doctor đã like chưa
        $existingLike = PostLike::where('post_id', $post->id)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhere('doctor_id', $user->id);
            })->first();

        if ($existingLike) {
            $existingLike->delete(); // Nếu đã like thì bỏ like
            $liked = false;
        } else {
            PostLike::create([
                'post_id' => $post->id,
                'user_id' => get_class($user) === 'App\Models\User' ? $user->id : null,
                'doctor_id' => get_class($user) === 'App\Models\Doctor' ? $user->id : null,
            ]);
            $liked = true;
        }

        // Đếm số lượt like mới
        $likeCount = PostLike::where('post_id', $post->id)->count();

        return response()->json([
            'liked' => $liked,
            'count' => $likeCount
        ]);
    }
}
