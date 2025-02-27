<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<section class="h-100">
    <div class="h-100 container">
        <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h1 class="fs-4 card-title fw-bold mb-4">Đăng Ký</h1>

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate=""
                            autocomplete="off">
                            @csrf

                            <div class="mb-3">
                                <label class="text-muted mb-2" for="name">Họ và Tên</label>
                                <input id="name" type="text" class="form-control" name="name"
                                    value="{{ old('name') }}" required autofocus>
                                <div class="invalid-feedback">
                                    Vui lòng nhập họ và tên.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted mb-2" for="phone">Số Điện Thoại</label>
                                <input id="phone" type="text" class="form-control" name="phone"
                                    value="{{ old('phone') }}" required>
                                <div class="invalid-feedback">
                                    Vui lòng nhập số điện thoại hợp lệ.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted mb-2" for="email">Địa chỉ Email</label>
                                <input id="email" type="email" class="form-control" name="email"
                                    value="{{ old('email') }}" required>
                                <div class="invalid-feedback">
                                    Vui lòng nhập email hợp lệ.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted mb-2" for="password">Mật Khẩu</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                                <div class="invalid-feedback">
                                    Vui lòng nhập mật khẩu (tối thiểu 6 ký tự).
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="text-muted mb-2" for="password_confirmation">Xác nhận Mật Khẩu</label>
                                <input id="password_confirmation" type="password" class="form-control"
                                    name="password_confirmation" required>
                                <div class="invalid-feedback">
                                    Vui lòng nhập lại mật khẩu.
                                </div>
                            </div>

                            <p class="form-text text-muted mb-3">
                                Khi đăng ký, bạn đồng ý với các điều khoản của chúng tôi.
                            </p>

                            <div class="align-items-center d-flex">
                                <button type="submit" class="btn btn-primary ms-auto">
                                    Đăng Ký
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer border-0 py-3">
                        <div class="text-center">
                            Đã có tài khoản? <a href="{{ route('login') }}" class="text-dark">Đăng nhập</a>
                        </div>
                    </div>
                </div>

                <div class="text-muted mt-5 text-center">
                    Copyright &copy; 2024 &mdash; Your Company
                </div>
            </div>
        </div>
    </div>
</section>
