@extends('layouts.master')

@section('title', 'Trang Đăng Nhập')

@section('main-content')
    <!-- HTML -->
    <div class="login-container">
        <div class="container-login">
            <h2>Đăng Nhập</h2>
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group">
                    <label for="phone">Số điện thoại:</label>
                    <input id="phone" type="text" name="phone" class="form-control" placeholder="Nhập số điện thoại"
                        required autofocus>
                </div>

                <div class="input-group">
                    <label for="password">Mật khẩu:</label>
                    <input id="password" type="password" name="password" class="form-control"placeholder="Nhập mật khẩu"
                        required>
                </div>

                <div class="remember-forgot">
                    <div class="form-check">
                        <input type="checkbox" name="remember" id="remember" class="form-check-input">
                        <label for="remember" class="form-check-label">Ghi nhớ đăng nhập</label>
                    </div>
                    <a href="#">Quên mật khẩu?</a>
                </div>

                <div class="form-check">
                    <input type="radio" name="role" id="role_user" value="user" class="form-check-input" checked>
                    <label for="role_user" class="form-check-label">Đăng Nhập Người Dùng</label>
                </div>

                <div class="form-check">
                    <input type="radio" name="role" id="role_doctor" value="doctor" class="form-check-input">
                    <label for="role_doctor" class="form-check-label">Đăng Nhập Bác Sĩ</label>
                </div>

                <button type="submit" class="btn-login">Đăng Nhập</button>
            </form>

            <div class="footer-text">
                Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký ngay</a>
            </div>
        </div>

        <div class="welcome-text">
            <h1>Chào mừng trở lại!</h1>
            <p>Rất vui được gặp lại bạn. Hãy đăng nhập để tiếp tục trải nghiệm dịch vụ của chúng tôi và nhận được sự chăm
                sóc
                tốt nhất từ đội ngũ bác sĩ chuyên nghiệp.</p>
        </div>
    </div>
@endsection
