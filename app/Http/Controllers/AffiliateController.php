<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Product;
use App\Models\AffiliateLink;
use App\Models\AffiliateClick;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


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

    public function trackClick(Request $request, $hash_ref)
    {
        // ✅ Tìm affiliate link theo hash_ref
        $affiliate = DB::table('affiliate_links')->where('hash_ref', $hash_ref)->first();

        if (!$affiliate) {
            return response()->json(['error' => 'Affiliate link không tồn tại.'], 404);
        }

        $ip_address = $request->ip();
        $user_agent = $request->header('User-Agent');
        $doctor_id = $affiliate->doctor_id;
        $product_id = $affiliate->product_id;

        // ✅ Kiểm tra xem IP/User-Agent đã click trong 10 phút gần đây chưa (chống spam điểm)
        $recentClick = DB::table('affiliate_clicks')
            ->where('doctor_id', $doctor_id)
            ->where('product_id', $product_id)
            ->where(function ($query) use ($ip_address, $user_agent) {
                $query->where('ip_address', $ip_address)
                    ->orWhere('user_agent', $user_agent);
            })
            ->where('created_at', '>', now()->subMinutes(10))
            ->exists();

        // ✅ Lưu thông tin click
        AffiliateClick::create([
            'doctor_id' => $doctor_id,
            'product_id' => $product_id,
            'hash_ref' => $hash_ref,
            'ip_address' => $ip_address,
            'user_agent' => $user_agent,
        ]);


        $pointsAdded = 0;

        // ✅ Nếu chưa click gần đây => Cộng điểm
        if (!$recentClick) {
            DB::table('doctors')->where('id', $doctor_id)->increment('points', 1);
            $pointsAdded = 1;
        }

        return response()->json([
            'message' => 'Click được ghi nhận!',
            'doctor_id' => $doctor_id,
            'product_id' => $product_id,
            'points_added' => $pointsAdded
        ], 200);
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
