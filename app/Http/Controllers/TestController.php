<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function upload(Request $request)
    {
        // Kiểm tra nếu file có được chọn
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Lấy file ảnh từ request
        $image = $request->file('image');

        // Lưu ảnh lên S3
        $path = $image->store('images', 's3');

        // Trả về URL của ảnh đã upload
        return response()->json([
            'message' => 'Image uploaded successfully!',
            'image_url' => Storage::disk('s3')->url($path),
        ]);
    }
}
