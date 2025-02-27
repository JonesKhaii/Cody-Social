<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::guard('web')->user(); // Lấy user từ guard 'web'
        $doctor = Auth::guard('doctor')->user(); // Lấy doctor từ guard 'doctor'

        // Nếu cả User và Doctor đều không đăng nhập, không cho bình luận
        if (!$user && !$doctor) {
            return back()->with('error', 'Bạn cần đăng nhập để bình luận.');
        }

        // Xác định vai trò của người bình luận
        $commentData = [
            'post_id' => $request->post_id,
            'comment' => $request->comment,
            'status' => 'active',
            'parent_id' => $request->parent_id,
            'replied_comment' => $request->parent_id ? $request->replied_comment : null,
        ];

        // Nếu là User → lưu user_id, nếu là Doctor → lưu doctor_id
        if ($user) {
            $commentData['user_id'] = $user->id;
        } elseif ($doctor) {
            $commentData['doctor_id'] = $doctor->id;
        }

        Comment::create($commentData);

        return back()->with('success', 'Bình luận của bạn đã được thêm.');
    }
}
