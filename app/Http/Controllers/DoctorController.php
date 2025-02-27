<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PostCategory;
use App\Models\Product;
use App\Models\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;



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
            ->orderBy('date', 'asc')
            ->orderBy('time', 'asc')
            ->get(['id', 'user_id', 'date', 'time', 'status', 'approval_status', 'notes', 'consultation_type']);


        return view('doctor.profile', compact('doctor', 'posts', 'categories', 'products', 'appointments'));
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

        return back()->with('success', 'Lịch hẹn đã được xác nhận.');
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

        return back()->with('success', 'Lịch hẹn đã bị từ chối.');
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

        return back()->with('success', 'Lịch hẹn đã hoàn thành thành công.');
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

        return back()->with('success', 'Lịch hẹn đã bị hủy.');
    }

    public function showDetail($id)
    {
        $doctor = Doctor::select(['id', 'name', 'specialization', 'photo', 'email', 'phone', 'bio'])
            ->with(['posts:id,added_by,title,slug,summary,photo,created_at'])
            ->findOrFail($id);

        return view('pages.doctor-detail', compact('doctor'));
    }
}
