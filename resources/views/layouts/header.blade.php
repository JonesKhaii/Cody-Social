@php
    $isLoggedInAsDoctor = Auth::guard('doctor')->check();
    $isLoggedInAsUser = Auth::guard('web')->check();

    $role = $isLoggedInAsDoctor ? 'doctor' : ($isLoggedInAsUser ? 'user' : session('role'));
    $notificationCount = 0;
    if ($isLoggedInAsDoctor) {
        $notificationCount = Auth::guard('doctor')->user()->unreadNotifications->count();
    } elseif ($isLoggedInAsUser) {
        $notificationCount = Auth::guard('web')->user()->unreadNotifications->count();
    }
@endphp

<header class="navbar navbar-expand-lg navbar-dark shadow-sm" id="mainHeader">
    <div class="container">
        <!-- Logo và thương hiệu -->
        <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
            <img src="{{ asset('asset/images/logo1.png') }}" alt="CodyHealth Logo" class="logo me-2"
                style="height: 50px; width: 50px; border-radius: 50%;" />
            <span class="navbar-brand fs-4 fw-bold mb-0 text-white">ToiKhoeBlog</span>
        </a>

        <!-- Nút toggle cho mobile -->
        <button class="navbar-toggler border-0" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarMobile"
            aria-label="Toggle navigation"
            aria-expanded="false"
            aria-controls="navbarMobile">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar cho Desktop và Mobile -->
        <div class="navbar-collapse collapse" id="navbarMobile">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'home' ? 'active' : '' }} px-3 text-white"
                        href="{{ route('home') }}">Trang chủ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'about' ? 'active' : '' }} px-3 text-white"
                        href="{{ route('about') }}">Về chúng tôi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'doctors.list' ? 'active' : '' }} px-3 text-white"
                        href="{{ route('doctors.list') }}">Bác sĩ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 text-white" target="_blank"
                        href="https://toikhoe.vn/">Sản phẩm của chúng tôi</a>
                </li>

                @if ($role === 'doctor')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'doctor.profile' ? 'active' : '' }} px-3 text-white"
                            href="{{ route('doctor.profile') }}">Trang tổng quan bác sĩ</a>
                    </li>
                @endif

                @if ($role === 'user')
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'user.appointments' ? 'active' : '' }} px-3 text-white"
                            href="{{ route('user.appointments') }}">Lịch khám</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName() == 'user.profile' ? 'active' : '' }} px-3 text-white"
                            href="{{ route('user.profile') }}">Hồ sơ người dùng</a>
                    </li>
                @endif

                <!-- Thông báo -->
                @if ($role === 'doctor' || $role === 'user')
                    <li class="nav-item dropdown notification-wrapper">
                        <a class="nav-link position-relative dropdown-toggle notification-trigger px-3 text-white"
                            href="#" id="notificationDropdown" role="button" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            @if ($notificationCount > 0)
                                <span class="badge rounded-pill bg-danger notification-badge">
                                    {{ $notificationCount > 99 ? '99+' : $notificationCount }}
                                </span>
                            @endif
                        </a>

                        <div class="dropdown-menu dropdown-menu-end notification-dropdown shadow"
                            aria-labelledby="notificationDropdown">
                            <div class="dropdown-header d-flex justify-content-between align-items-center">
                                <span>Thông báo mới</span>
                                @if ($notificationCount > 0)
                                    <button type="button" class="btn btn-sm text-primary mark-all-read-btn"
                                        style="font-size: 0.8rem;">Đánh dấu đã đọc</button>
                                @endif
                            </div>
                            <div id="notification-list" class="notification-content-list scrollable-menu">
                                <div class="p-2 text-center"><small>Đang tải thông báo...</small></div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item view-all-notifications text-center" href="#">Xem tất cả</a>
                        </div>
                    </li>
                @endif

                <!-- Đăng xuất/Đăng nhập -->
                @if ($isLoggedInAsDoctor || $isLoggedInAsUser)
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link logout-btn text-white" href="{{ route('logout') }}">
                            <i class="fas fa-sign-out-alt d-none d-lg-inline-block me-1"></i>Đăng xuất
                        </a>
                    </li>
                @else
                    <li class="nav-item ms-lg-2">
                        <a class="nav-link login-btn text-white" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt d-none d-lg-inline-block me-1"></i>Đăng nhập
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</header>
