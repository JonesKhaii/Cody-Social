<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Đảm bảo chỉ người dùng đã đăng nhập mới có thể truy cập
    }

    public function showProfile()
    {
        $user = auth()->user();  // Nếu chưa đăng nhập, sẽ bị lỗi
        // Các thao tác khác với người dùng đã đăng nhập
    }
}

