<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Product;
use App\Models\AffiliateLink;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AffiliateController extends Controller
{

    public function index()
    {
        $products = Product::all(); // Lấy tất cả sản phẩm
        return view('doctor.affiliate.index', compact('products')); // Truyền biến $products vào view
    }

    public function generateLink(Request $request, $product_slug)
    {
        $doctor = Auth::guard('doctor')->user();

        // Tìm sản phẩm theo slug
        $product = Product::where('slug', $product_slug)->firstOrFail();

        // Kiểm tra xem link đã tồn tại chưa
        $existingLink = AffiliateLink::where([
            ['doctor_id', $doctor->id],
            ['product_id', $product->id]
        ])->first();

        // Xác định URL gốc của sản phẩm
        $productBaseUrl = $product->product_url ?? "http://toikhoe.vn/product-detail/{$product->slug}";

        // Nếu sản phẩm đã có liên kết tiếp thị
        if ($existingLink) {
            return response()->json([
                'message' => 'Sản phẩm này đã có trong danh sách tiếp thị!',
                'affiliate_link' => "{$productBaseUrl}?ref={$existingLink->hash_ref}",
                'is_existing' => true, // Trả về trạng thái sản phẩm đã có liên kết
                'data' => $existingLink
            ], 200);
        }

        // Tạo hash ref mới cho link tiếp thị
        $hashRef = hash('sha256', $doctor->id . $product->id . time());

        // Tạo link tiếp thị mới
        $affiliate = AffiliateLink::create([
            'doctor_id' => $doctor->id,
            'product_id' => $product->id,
            'product_link' => "{$productBaseUrl}?ref={$hashRef}",
            'commission_percentage' => $product->commission,
            'hash_ref' => $hashRef
        ]);

        return response()->json([
            'message' => 'Link Affiliate được tạo thành công!',
            'affiliate_link' => "{$productBaseUrl}?ref={$hashRef}",
            'is_existing' => false, // Trả về trạng thái sản phẩm chưa có liên kết
            'data' => $affiliate
        ], 201);
    }


    public function searchProduct(Request $request)
    {
        $query = $request->query('q');

        if (!$query) {
            return response()->json([]); // Trả về mảng rỗng nếu không có từ khóa
        }

        // Tìm kiếm sản phẩm theo tiêu đề
        $products = Product::where('title', 'LIKE', "%$query%")
            ->orderBy('title')
            ->limit(7) // Giới hạn tối đa 7 sản phẩm
            ->get(['id', 'title', 'slug', 'price', 'photo']);
        return response()->json($products);
    }
}
