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
                <input id="phone" type="text" name="phone" class="form-control" required autofocus>
            </div>

            <div class="input-group">
                <label for="password">Mật khẩu:</label>
                <input id="password" type="password" name="password" class="form-control" required>
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
            Chưa có tài khoản? <a href="#">Đăng ký ngay</a>
        </div>
    </div>

    <div class="welcome-text">
        <h1>Chào mừng trở lại!</h1>
        <p>Rất vui được gặp lại bạn. Hãy đăng nhập để tiếp tục trải nghiệm dịch vụ của chúng tôi và nhận được sự chăm
            sóc
            tốt nhất từ đội ngũ bác sĩ chuyên nghiệp.</p>
    </div>
</div>

<!-- CSS -->
<style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: "Poppins", sans-serif;
    }

    body {
        background-color: #f8f9fa;
        min-height: 100vh;
    }

    .login-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 50px;
        max-width: 1200px;
        margin: 50px auto;
        padding: 20px;
    }

    .container-login {
        background: white;
        width: 380px;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
    }

    .container-login h2 {
        font-weight: 500;
        text-align: center;
        margin-bottom: 20px;
        font-size: 22px;
        color: #333;
    }

    .input-group {
        margin-bottom: 15px;
    }

    .input-group label {
        font-size: 14px;
        font-weight: 500;
        color: #555;
        display: block;
        margin-bottom: 5px;
    }

    .input-group input {
        width: 100%;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
        font-size: 14px;
        transition: 0.3s ease-in-out;
    }

    .input-group input:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.3);
        outline: none;
    }

    .btn-login {
        margin-top: 20px;
        padding: 12px;
        width: 100%;
        background-color: #007bff;
        border: none;
        color: white;
        font-size: 15px;
        font-weight: 500;
        border-radius: 6px;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-login:hover {
        background-color: #0056b3;
        transform: translateY(-1px);
    }

    .remember-forgot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        margin: 15px 0;
    }

    .remember-forgot a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    .remember-forgot a:hover {
        text-decoration: underline;
    }

    .footer-text {
        text-align: center;
        font-size: 13px;
        margin-top: 20px;
    }

    .footer-text a {
        font-weight: 500;
        color: #007bff;
        text-decoration: none;
    }

    .footer-text a:hover {
        text-decoration: underline;
    }

    .form-check {
        margin: 10px 0;
        display: flex;
        align-items: center;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        border: 2px solid #007bff;
        border-radius: 50%;
        transition: all 0.3s ease;
        margin-right: 8px;
    }

    .form-check-input[type="checkbox"] {
        border-radius: 4px;
    }

    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
    }

    .form-check-input:hover {
        border-color: #0056b3;
        cursor: pointer;
    }

    .form-check-label {
        font-size: 14px;
        color: #333;
        cursor: pointer;
    }

    .welcome-text {
        max-width: 400px;
        padding: 20px;
    }

    .welcome-text h1 {
        color: #333;
        font-size: 2.5rem;
        margin-bottom: 1rem;
        line-height: 1.2;
        opacity: 0;
        animation: fadeInDown 2s ease-out forwards;
    }

    .welcome-text p {
        color: #666;
        font-size: 1.1rem;
        line-height: 1.6;
        opacity: 0;
        animation: fadeInRight 1s ease-out forwards;
        /* Đợi animation của h1 hoàn thành (1s) rồi mới bắt đầu */
        animation-delay: 1s;
    }

    @keyframes fadeInDown {
        0% {
            opacity: 0;
            transform: translateY(-30px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInRight {
        0% {
            opacity: 0;
            transform: translateX(-30px);
        }

        100% {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* Responsive */
    @media (max-width: 968px) {
        .login-container {
            flex-direction: column-reverse;
            gap: 30px;
        }

        .welcome-text {
            text-align: center;
            padding: 0 20px;
        }

        .welcome-text h1 {
            font-size: 2rem;
        }
    }

    @media (max-width: 480px) {
        .container-login {
            width: 100%;
            margin: 0 10px;
        }

        .welcome-text h1 {
            font-size: 1.8rem;
        }
    }
</style>
