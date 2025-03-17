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

        // Lấy danh sách lịch khám của bác sĩ hiện tại (bạn có thể uncomment phần code gốc)
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

    // public function rejectAppointment($id)
    // {
    //     $doctor = Auth::guard('doctor')->user();

    //     if (!$doctor) {
    //         return redirect()->route('login');
    //     }

    //     $appointment = Appointment::where('doctor_id', $doctor->id)->findOrFail($id);

    //     if ($appointment->approval_status !== 'Chờ duyệt' || $appointment->status !== 'Chờ duyệt') {
    //         return back()->with('error', 'Lịch hẹn đã được xử lý trước đó.');
    //     }

    //     $appointment->update([
    //         'status' => 'Đã Huỷ',
    //         'approval_status' => 'Từ chối',
    //     ]);

    //     return back()->with('success', 'Lịch hẹn đã bị từ chối.');
    // }
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

    // public function completeAppointment($id)
    // {
    //     $doctor = Auth::guard('doctor')->user();

    //     if (!$doctor) {
    //         return redirect()->route('login');
    //     }

    //     $appointment = Appointment::where('doctor_id', $doctor->id)->findOrFail($id);

    //     if ($appointment->status !== 'Sắp tới' || $appointment->approval_status !== 'Chấp nhận') {
    //         return back()->with('error', 'Lịch hẹn không thể hoàn thành.');
    //     }

    //     $appointment->update([
    //         'status' => 'Hoàn thành',
    //     ]);

    //     return back()->with('success', 'Lịch hẹn đã hoàn thành thành công.');
    // }

    // public function cancelAppointment($id)
    // {
    //     $doctor = Auth::guard('doctor')->user();

    //     if (!$doctor) {
    //         return redirect()->route('login');
    //     }

    //     $appointment = Appointment::where('doctor_id', $doctor->id)->findOrFail($id);

    //     if ($appointment->status === 'Hoàn thành') {
    //         return back()->with('error', 'Không thể hủy lịch hẹn đã hoàn thành.');
    //     }

    //     $appointment->update([
    //         'status' => 'Đã Huỷ',
    //     ]);

    //     return back()->with('success', 'Lịch hẹn đã bị hủy.');
    // }
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

        $appointments = DB::table('appointments')
            ->selectRaw("DATE_FORMAT(date, '%Y-%m-%d') as date, COUNT(*) as total")
            ->where('doctor_id', $doctorId)
            ->whereBetween('date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        return response()->json($appointments);
    }
}
