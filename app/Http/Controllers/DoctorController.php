<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\AffiliateLink;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Helpers\NotificationHelper;


class DoctorController extends Controller
{
    public function index()
    {

        $doctors = Doctor::select(['id', 'name', 'specialization', 'photo'])->paginate(10);

        return view('pages.list-doctors', compact('doctors'));
    }

    public function profile()
    {
        $doctor = Auth::guard('doctor')->user(); // Sử dụng guard doctor để lấy thông tin bác sĩ
        if (!$doctor) {
            return redirect()->route('login'); // Nếu không phải bác sĩ, chuyển hướng về trang đăng nhập
        }
        // dd($doctor);
        $posts = Post::where('added_by', $doctor->id)->get();

        if (!Auth::guard('doctor')->check()) {
            return redirect()->route('login');  // Nếu không phải bác sĩ, điều hướng về trang đăng nhập
        }

        $categories = PostCategory::where('status', 'active')->get();
        $doctor_id = Auth::guard('doctor')->id();
        $products = DB::table('affiliate_links')
            ->join('products', 'affiliate_links.product_id', '=', 'products.id')
            ->where('affiliate_links.doctor_id', $doctor_id)
            ->select('products.id', 'products.title', 'products.photo', 'products.price', 'products.discount')
            ->get();
        // dd($products);
        $appointments = Appointment::where('doctor_id', $doctor_id)
            ->with(['user:id,name,email,phone']) // Lấy thông tin bệnh nhân
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get(['id', 'user_id', 'date', 'time', 'status', 'approval_status', 'notes', 'consultation_type']);

        $productss = Product::with(['cat_info', 'sub_cat_info', 'brand'])
            ->orderBy('id', 'desc')
            ->paginate(10);

        foreach ($productss as $product) {
            // Kiểm tra xem sản phẩm đã có liên kết chưa
            $existingLink = AffiliateLink::where([
                ['doctor_id', $doctor->id],
                ['product_id', $product->id]
            ])->first();

            // Gắn dữ liệu liên kết vào sản phẩm
            $product->existingLink = $existingLink;
        }

        return view('doctor.profile', compact('doctor', 'posts', 'categories', 'products', 'appointments', 'productss'));
    }


    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update($request->only(['name', 'phone', 'email', 'workplace']));

        return redirect()->back()->with('success', 'Thông tin đã được cập nhật.');
    }

    public function getAffilateProduct($doctor_id)
    {
        $products = DB::table('doctor_products')
            ->join('products', 'doctor_products.product_id', '=', 'products.id')
            ->where('doctor_products.doctor_id', $doctor_id)
            ->select('products.id', 'products.title', 'products.photo', 'products.price', 'products.discount')
            ->get();

        return view('doctor.profile', compact('products'));
    }

    public function getAppointments()
    {
        $doctor = Auth::guard('doctor')->user();

        if (!$doctor) {
            return redirect()->route('login');
        }

        // Lấy danh sách lịch khám của bác sĩ hiện tại 
        $appointments = Appointment::where('doctor_id', $doctor->id)
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get();

        return view('doctor.appointments', compact('appointments'));
    }

    public function approveAppointment($id)
    {
        $doctor = Auth::guard('doctor')->user();

        if (!$doctor) {
            return redirect()->route('login');
        }

        $appointment = Appointment::where('doctor_id', $doctor->id)->findOrFail($id);

        if ($appointment->approval_status !== 'Chờ duyệt') {
            return back()->with('error', 'Lịch hẹn này không thể được xác nhận.');
        }

        $appointment->update([
            'status' => 'Sắp tới',
            'approval_status' => 'Chấp nhận'
        ]);

        // Lấy thông tin người dùng (bệnh nhân)
        $user = User::find($appointment->user_id);

        if ($user) {
            // Gửi thông báo đơn giản (chỉ cần hiển thị)
            NotificationHelper::send(
                $user,
                'appointment',
                'Lịch hẹn của bạn với Bác sĩ ' . $doctor->name . ' vào ngày ' . date('d/m/Y', strtotime($appointment->date)) . ' lúc ' . $appointment->time . ' đã được chấp nhận'
            );
        }

        return back()->with('success', 'Lịch hẹn đã được xác nhận và thông báo đã gửi đến bệnh nhân.');
    }

    public function rejectAppointment($id)
    {
        $doctor = Auth::guard('doctor')->user();

        if (!$doctor) {
            return redirect()->route('login');
        }

        $appointment = Appointment::where('doctor_id', $doctor->id)->findOrFail($id);

        if ($appointment->approval_status !== 'Chờ duyệt' || $appointment->status !== 'Chờ duyệt') {
            return back()->with('error', 'Lịch hẹn đã được xử lý trước đó.');
        }

        $appointment->update([
            'status' => 'Đã Huỷ',
            'approval_status' => 'Từ chối',
        ]);

        $user = User::find($appointment->user_id);

        if ($user) {
            NotificationHelper::send(
                $user,
                'appointment',
                'Lịch hẹn của bạn với Bác sĩ ' . $doctor->name . ' vào ngày ' . date('d/m/Y', strtotime($appointment->date)) . ' lúc ' . $appointment->time . ' đã bị **từ chối**.'
            );
        }

        return back()->with('success', 'Lịch hẹn đã bị từ chối và thông báo đã gửi đến bệnh nhân.');
    }

    public function completeAppointment($id)
    {
        $doctor = Auth::guard('doctor')->user();

        if (!$doctor) {
            return redirect()->route('login');
        }

        $appointment = Appointment::where('doctor_id', $doctor->id)->findOrFail($id);

        if ($appointment->status !== 'Sắp tới' || $appointment->approval_status !== 'Chấp nhận') {
            return back()->with('error', 'Lịch hẹn không thể hoàn thành.');
        }

        $appointment->update([
            'status' => 'Hoàn thành',
        ]);

        $user = User::find($appointment->user_id);

        if ($user) {
            NotificationHelper::send(
                $user,
                'appointment',
                'Lịch hẹn của bạn với Bác sĩ ' . $doctor->name . ' vào ngày ' . date('d/m/Y', strtotime($appointment->date)) . ' đã được **hoàn thành**.'
            );
        }

        return back()->with('success', 'Lịch hẹn đã hoàn thành và thông báo đã gửi đến bệnh nhân.');
    }

    public function cancelAppointment($id)
    {
        $doctor = Auth::guard('doctor')->user();

        if (!$doctor) {
            return redirect()->route('login');
        }

        $appointment = Appointment::where('doctor_id', $doctor->id)->findOrFail($id);

        if ($appointment->status === 'Hoàn thành') {
            return back()->with('error', 'Không thể hủy lịch hẹn đã hoàn thành.');
        }

        $appointment->update([
            'status' => 'Đã Huỷ',
        ]);

        $user = User::find($appointment->user_id);

        if ($user) {
            NotificationHelper::send(
                $user,
                'appointment',
                'Lịch hẹn của bạn với Bác sĩ ' . $doctor->name . ' vào ngày ' . date('d/m/Y', strtotime($appointment->date)) . ' đã bị **hủy**.'
            );
        }

        return back()->with('success', 'Lịch hẹn đã bị hủy và thông báo đã gửi đến bệnh nhân.');
    }
    public function showDetail($id)
    {
        $doctor = Doctor::select(['id', 'name', 'specialization', 'photo', 'email', 'phone', 'bio'])
            ->with(['posts:id,added_by,title,slug,summary,photo,created_at'])
            ->findOrFail($id);

        return view('pages.doctor-detail', compact('doctor'));
    }

    // Statics 
    public function getAppointmentStats()
    {
        // Kiểm tra xem người dùng có phải là bác sĩ không
        if (!Auth::guard('doctor')->check()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $doctorId = Auth::guard('doctor')->id();

        // Lấy dữ liệu lịch hẹn theo trạng thái, sử dụng groupBy và count để tối ưu
        $appointments = Appointment::where('doctor_id', $doctorId)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        // Tính tổng số lịch hẹn
        $totalAppointments = $appointments->sum('count');

        // Chuyển đổi dữ liệu thành dạng JSON phù hợp với CanvasJS
        $appointmentData = $appointments->map(function ($appointment) use ($totalAppointments) {
            return [
                'label' => $appointment->status,
                'y' => (int) $appointment->count,
                'percentage' => $totalAppointments > 0 ? round(($appointment->count / $totalAppointments) * 100, 2) : 0
            ];
        });

        return response()->json($appointmentData);
    }



    //===================Post static============================================
    public function getPostInteractions()
    {
        $doctorId = auth()->guard('doctor')->id();

        $interactions = Post::where('added_by', $doctorId)
            ->withCount(['likes', 'comments'])
            ->get()
            ->reduce(function ($carry, $post) {
                $carry['likes'] += $post->likes_count;
                $carry['comments'] += $post->comments_count;
                $carry['shares'] += rand(5, 20); // Giả sử chưa có cột shares, bạn có thể cập nhật
                $carry['saves'] += rand(3, 15); // Giả sử chưa có cột saves
                return $carry;
            }, ['likes' => 0, 'comments' => 0, 'shares' => 0, 'saves' => 0]);

        return response()->json($interactions);
    }

    public function getAppointmentsByTimeframe(Request $request)
    {
        $doctorId = auth()->guard('doctor')->id();
        $timeframe = $request->query('timeframe', 'week'); // Mặc định là tuần

        // Lấy ngày bắt đầu và kết thúc theo khung thời gian
        $endDate = Carbon::now();
        $startDate = match ($timeframe) {
            'day' => Carbon::now(),
            'week' => Carbon::now()->subDays(7),
            'month' => Carbon::now()->subDays(30),
            'year' => Carbon::now()->subYear(),
            default => Carbon::now()->subDays(7),
        };

        $appointments = Appointment::selectRaw("DATE_FORMAT(date, '%Y-%m-%d') as date, COUNT(*) as total")
            ->where('doctor_id', $doctorId)
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return response()->json($appointments);
    }


    public function getPostKPI()
    {
        $doctorId = Auth::guard('doctor')->id();

        $posts = Post::where('added_by', $doctorId)
            ->withCount(['likes', 'comments'])
            ->get(['id', 'views']);

        $totalPosts = $posts->count();
        $totalViews = $posts->sum('views');
        $totalLikes = $posts->sum('likes_count');
        $totalComments = $posts->sum('comments_count');

        $avgEngagementRate = $totalViews > 0
            ? round((($totalLikes + $totalComments) / $totalViews) * 100, 2)
            : 0;

        return response()->json([
            'total_posts' => $totalPosts,
            'total_views' => $totalViews,
            'total_likes' => $totalLikes,
            'total_comments' => $totalComments,
            'avg_engagement_rate' => $avgEngagementRate,
        ]);
    }

    public function getPostTrend(Request $request)
    {
        $doctorId = Auth::guard('doctor')->id();
        $range = $request->input('range', 'month');

        $dateFormat = match ($range) {
            'day' => '%Y-%m-%d',
            'week' => '%Y-%u',
            'month' => '%Y-%m',
            default => '%Y-%m',
        };

        $trend = Post::selectRaw(
            "DATE_FORMAT(created_at, '$dateFormat') as period, 
                SUM(views) as total_views"
        )
            ->where('added_by', $doctorId)
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $likes = Post::selectRaw(
            "DATE_FORMAT(created_at, '$dateFormat') as period, 
                SUM((SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = posts.id)) as total_likes"
        )
            ->where('added_by', $doctorId)
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        $comments = Post::selectRaw(
            "DATE_FORMAT(created_at, '$dateFormat') as period, 
                SUM((SELECT COUNT(*) FROM post_comments WHERE post_comments.post_id = posts.id)) as total_comments"
        )
            ->where('added_by', $doctorId)
            ->groupBy('period')
            ->orderBy('period')
            ->get();

        return response()->json([
            'views' => $trend,
            'likes' => $likes,
            'comments' => $comments,
        ]);
    }

    public function getTopPosts()
    {
        $doctorId = Auth::guard('doctor')->id();

        $topPosts = Post::where('added_by', $doctorId)
            ->withCount(['likes', 'comments'])
            ->orderByDesc('views')
            ->take(5)
            ->get(['id', 'title', 'views']);

        return response()->json(
            $topPosts->map(function ($post) {
                return [
                    'title' => $post->title,
                    'views' => $post->views,
                    'likes' => $post->likes_count,
                    'comments' => $post->comments_count,
                    'engagement_rate' => $post->views > 0 ? round((($post->likes_count + $post->comments_count) / $post->views) * 100, 2) : 0,
                ];
            })
        );
    }

    public function getCategoryDistribution()
    {
        $doctorId = Auth::guard('doctor')->id();

        $distribution = Post::select('post_cat_id', DB::raw('COUNT(*) as total'))
            ->where('added_by', $doctorId)
            ->groupBy('post_cat_id')
            ->with('cat_info:id,title')
            ->get()
            ->map(function ($item) {
                return [
                    'category' => $item->cat_info->title ?? 'Không rõ',
                    'total' => $item->total
                ];
            });

        return response()->json($distribution);
    }

    public function getPostStatsPerPost()
    {
        $doctorId = Auth::guard('doctor')->id();

        $posts = Post::where('added_by', $doctorId)
            ->withCount(['likes', 'comments'])
            ->orderByDesc('views')
            ->get(['id', 'title', 'views']);

        return response()->json(
            $posts->map(function ($post) {
                return [
                    'title' => $post->title,
                    'views' => $post->views,
                    'likes' => $post->likes_count,
                    'comments' => $post->comments_count,
                    'engagement_rate' => $post->views > 0 ? round((($post->likes_count + $post->comments_count) / $post->views) * 100, 2) : 0,
                ];
            })
        );
    }

    //===================Appointment static============================================


    // public function getAppointmentKPI()
    // {
    //     $doctorId = Auth::guard('doctor')->id();
    //     $totalAppointments = Appointment::where('doctor_id', $doctorId)->count();

    //     // Lấy số lượng các trạng thái lịch khám
    //     $appointmentStatus = Appointment::where('doctor_id', $doctorId)
    //         ->groupBy('status')
    //         ->selectRaw('status, COUNT(*) as total')
    //         ->pluck('total', 'status');  // Tối ưu bằng cách dùng pluck() để lấy kết quả theo dạng mảng

    //     return response()->json([
    //         'total_appointments' => $totalAppointments,
    //         'appointment_status' => $appointmentStatus
    //     ]);
    // }

    public function getAppointmentKPI()
    {
        $doctorId = Auth::guard('doctor')->id();
        $totalAppointments = Appointment::where('doctor_id', $doctorId)->count();

        // Lấy số lượng các trạng thái lịch khám theo đúng giá trị enum trong DB
        $appointmentStatus = Appointment::where('doctor_id', $doctorId)
            ->groupBy('status')
            ->selectRaw('status, COUNT(*) as total')
            ->pluck('total', 'status')->toArray();

        // Đảm bảo các trạng thái luôn có giá trị, kể cả khi không có dữ liệu
        $formattedStatus = [
            'Chờ duyệt' => $appointmentStatus['Chờ duyệt'] ?? 0,
            'Sắp tới' => $appointmentStatus['Sắp tới'] ?? 0,
            'Hoàn thành' => $appointmentStatus['Hoàn thành'] ?? 0,
            'Đã Huỷ' => $appointmentStatus['Đã Huỷ'] ?? 0
        ];

        return response()->json([
            'total_appointments' => $totalAppointments,
            'appointment_status' => $formattedStatus
        ]);
    }
    public function getAppointmentTrend()
    {
        $doctorId = Auth::guard('doctor')->id();
        $appointments = Appointment::where('doctor_id', $doctorId)
            ->groupBy('date')
            ->selectRaw('DATE_FORMAT(date, "%Y-%m-%d") as date, COUNT(*) as total')
            ->orderBy('date', 'ASC')  // Đảm bảo sắp xếp theo ngày
            ->get();

        return response()->json($appointments);
    }
    public function getAppointmentTypeDistribution()
    {
        $doctorId = Auth::guard('doctor')->id();
        $appointmentTypes = Appointment::where('doctor_id', $doctorId)
            ->groupBy('consultation_type')
            ->selectRaw('consultation_type, COUNT(*) as total')
            ->get();

        $totalAppointments = $appointmentTypes->sum('total');
        $appointmentTypes = $appointmentTypes->map(function ($item) use ($totalAppointments) {
            return [
                'type' => $item->consultation_type,
                'percentage' => round(($item->total / $totalAppointments) * 100, 2)
            ];
        });

        return response()->json($appointmentTypes);
    }

    public function getAppointmentComparison()
    {
        $doctorId = Auth::guard('doctor')->id();

        // Lấy tổng số lịch khám của tất cả các tháng
        $totalAppointments = Appointment::where('doctor_id', $doctorId)
            ->count();

        // Lấy số lịch khám theo từng tháng, tuần và năm
        $appointments = Appointment::where('doctor_id', $doctorId)
            ->selectRaw("YEAR(date) as year, WEEK(date) as week, MONTH(date) as month, COUNT(*) as total")
            ->groupBy('year', 'week', 'month')
            ->orderBy('month', 'ASC')  // Đảm bảo có thứ tự theo tháng
            ->get();

        // Tính tỷ lệ phần trăm cho mỗi tháng
        $formattedData = $appointments->map(function ($item) use ($totalAppointments) {
            return [
                'period' => 'Tháng ' . $item->month,
                'rate' => $totalAppointments > 0 ? round(($item->total / $totalAppointments) * 100, 2) : 0
            ];
        });

        return response()->json($formattedData);
    }
}
