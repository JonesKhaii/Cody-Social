<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Intervention\Image\ImageManager;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        // Kiểm tra nếu file có được chọn và validate
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate ảnh
        ]);

        // Lấy file ảnh từ request
        $image = $request->file('image');

        // Tạo tên file WebP (hoặc có thể dùng tên gốc của file)
        $fileName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $fileExtension = $image->getClientOriginalExtension();
        $webpFileName = $fileName . '.' . $fileExtension; // Hoặc đổi sang .webp nếu cần

        // Lưu ảnh lên S3 với tên rõ ràng
        $path = $image->storeAs('images', $webpFileName, 's3'); // Lưu vào thư mục 'images'

        // Đảm bảo rằng ảnh được lưu với visibility public
        Storage::disk('s3')->setVisibility($path, 'public');

        // Lấy URL của ảnh đã upload
        $imageUrl = Storage::disk('s3')->url($path); // Trả về đường dẫn đầy đủ của ảnh

        // Trả về URL ảnh dưới dạng chuỗi
        return $imageUrl;
    }
}
