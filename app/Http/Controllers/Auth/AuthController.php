<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Doctor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }
    // Xử lý đăng nhập
    public function processLogin(Request $request)
    {
        $credentials = $request->validate([
            'phone' => 'required|string',
            'password' => 'required|min:6',
            'role' => 'required|string|in:user,doctor',  // Kiểm tra role
        ]);

        // Kiểm tra vai trò người dùng
        if ($credentials['role'] == 'user') {
            // Đăng nhập người dùng
            $user = User::where('phone', $credentials['phone'])->first();

            if ($user && Hash::check($credentials['password'], $user->password)) {
                Auth::login($user);
                session(['role' => 'user']); // Lưu role vào session
                return redirect()->intended(route('home')); // Điều hướng đến trang home
            }
        } elseif ($credentials['role'] == 'doctor') {
            // Đăng nhập bác sĩ
            $doctor = Doctor::where('phone', $credentials['phone'])->first();

            if ($doctor && Hash::check($credentials['password'], $doctor->password)) {
                Auth::guard('doctor')->login($doctor); // Đăng nhập bác sĩ với guard 'doctor'
                session(['role' => 'doctor']); // Lưu role bác sĩ vào session
                session()->save();
                // dd(session('role'));
                return redirect()->intended(route('home')); // Điều hướng đến trang bác sĩ
            }
        }

        return back()->withErrors(['phone' => 'Thông tin đăng nhập không đúng']);
    }






    // Hiển thị form đăng ký
    public function showRegister()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký
    public function processRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|unique:users|min:10|max:15',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:6|confirmed',
        ]);

        // Tạo tài khoản cho người dùng
        User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    // Xử lý đăng xuất
    public function logout()
    {
        // Đăng xuất cả hai guard
        if (Auth::guard('doctor')->check()) {
            Auth::guard('doctor')->logout();
        }

        if (Auth::check()) {
            Auth::logout();
        }

        session()->forget('role'); // Xóa role khỏi session khi đăng xuất
        return redirect()->route('login');
    }
}
