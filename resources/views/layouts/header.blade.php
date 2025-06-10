<header class="main-header">
    <div class="header-wrapper">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Logo và thương hiệu -->
                <div id="logo">
                    <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                        <img src="{{ asset('asset/images/logo-new.png') }}" alt="CodyHealth Logo" class="logo me-2"
                            style="height: 50px; width: 50px; border-radius: 50%;" />
                        {{-- <span class="navbar-brand fs-4 fw-bold mb-0 text-white">CodyHealth</span> --}}
                        <div class="logo-text ms-2">
                            {{-- <span class="toi">T</span><span class="plus-sign">O<span class="toi-i">I</span><span
                                    class="khoe">KH</span><span class="plus-sign">O</span><span
                                    class="khoe-e">E</span> --}}

                            <span>TOIKHOE</span>
                        </div>
                    </a>
                </div>

                <!-- Nút toggle cho mobile -->
                <button class="navbar-toggler border-0" type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarMobile"
                    aria-label="Toggle navigation"
                    aria-expanded="false"
                    aria-controls="navbarMobile">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Menu chính -->
                <div class="navbar-collapse collapse" id="navbarMobile">
                    <ul class="navbar-nav ms-auto">
                        <!-- Giữ các mục menu gốc -->
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

                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'services' ? 'active' : '' }} px-3 text-white"
                                href="{{ route('services') }}">Dịch vụ</a>
                        </li>

                        <!-- Phần dành cho bác sĩ -->
                        @if ($role === 'doctor')
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteName() == 'doctor.profile' ? 'active' : '' }} px-3 text-white"
                                    href="{{ route('doctor.profile') }}">Trang tổng quan bác sĩ</a>
                            </li>
                        @endif

                        <!-- Phần dành cho người dùng -->
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
                                    <a class="dropdown-item view-all-notifications text-center" href="#">Xem tất
                                        cả</a>
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
        </nav>

        <!-- PHẦN BOTTOMBAR-->
        <div class="bottombar">
            <div class="container">
                <!-- Phần danh mục -->
                <div class="popular-categories d-flex align-items-center">

                    <!-- Danh mục -->
                    <div class="category-items-container flex-grow-1">
                        <div class="category-items d-flex">
                            <!-- Mỗi item có data-category để xác định nội dung dropdown -->
                            <a href="#" class="category-item dropdown-trigger" data-category="clinics">
                                {{-- <i class="fas fa-hospital me-2"></i> --}}
                                Bệnh viện và phòng khám
                                <i class="fas fa-chevron-down small-icon ms-2"></i>
                            </a>


                            <a href="#" class="category-item dropdown-trigger" data-category="services">
                                {{-- <i class="fas fa-procedures me-2"></i> --}}
                                Phương pháp chữa bệnh
                                <i class="fas fa-chevron-down small-icon ms-2"></i>
                            </a>

                            <a href="{{ route('forum.index') }}" class="category-item">
                                Diễn đàn
                            </a>

                            <a href="#" class="category-item dropdown-trigger"
                                data-category="doctor-specialties">
                                Chuyên môn bác sĩ
                                <i class="fas fa-chevron-down small-icon ms-2"></i>
                            </a>
                            <a href="#" class="category-item dropdown-trigger" data-category="posts">
                                {{-- <i class="fas fa-newspaper me-2"></i> --}}
                                Bài viết
                                <i class="fas fa-chevron-down small-icon ms-2"></i>
                            </a>

                            <a href="#" class="category-item dropdown-trigger" data-category="tools">
                                Công cụ đo lường sức khỏe
                                <i class="fas fa-chevron-down small-icon ms-2"></i>
                            </a>

                            <a href="#" class="category-item" id="open-ai-advisor">
                                <i class="fas fa-robot me-1"></i> Tư vấn sức khỏe AI
                            </a>


                        </div>
                    </div>

                    <!-- Nút điều hướng phải -->
                    {{-- <button class="slider-nav slider-nav-next me-3" id="sliderNext">
                        <i class="fas fa-chevron-right"></i>
                    </button> --}}

                    <!-- Tìm kiếm -->
                    {{-- <div class="search-container">
                        <div class="search-input-group">
                            <input type="text" class="search-form-control" placeholder="Tìm kiếm...">
                            <button class="search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div> --}}
                </div>

                <!-- Phần dropdown sẽ mở rộng trong bottombar -->
                <div class="bottombar-dropdown" id="bottombar-dropdown">
                    <div class="dropdown-content" id="dropdown-content"></div>
                </div>
            </div>
        </div>

        <div class="dropdown-templates" style="display: none;">
            @include('layouts.partials.dropdown-templates.clinics')
            @include('layouts.partials.dropdown-templates.posts')
            @include('layouts.partials.dropdown-templates.tools')
            @include('layouts.partials.dropdown-templates.doctor-specialties')
            @include('layouts.partials.dropdown-templates.services')
        </div>
    </div>
</header>



<link rel="stylesheet" href="{{ asset('css/header.css') }}">
<script src="{{ asset('js/header.js') }}"></script>
<script>
    window.csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    console.log('{{ csrf_token() }}');
</script>
