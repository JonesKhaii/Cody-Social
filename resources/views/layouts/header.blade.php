<header class="main-header">
    <div class="header-wrapper">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <!-- Logo và thương hiệu -->
                <div id="logo">
                    <a href="{{ route('home') }}" class="d-flex align-items-center text-decoration-none">
                        <img src="{{ asset('asset/images/toikhoe_logo.jpg') }}" alt="CodyHealth Logo" class="logo me-2"
                            style="height: 50px; width: 50px; border-radius: 50%;" />
                        <span class="navbar-brand fs-4 fw-bold mb-0 text-white">CodyHealth</span>
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

                        <!-- Bổ sung 2 mục mới -->
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName() == 'services' ? 'active' : '' }} px-3 text-white"
                                href="">Dịch vụ</a>
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
                    <!-- Tiêu đề -->
                    <div class="popular-title-container me-2">
                        <h6 class="popular-title mb-0">Danh mục phổ biến:</h6>
                    </div>

                    <!-- Nút điều hướng trái -->
                    <button class="slider-nav slider-nav-prev me-2" id="sliderPrev">
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <!-- Danh mục -->
                    <div class="category-items-container flex-grow-1">
                        <div class="category-items d-flex">
                            <!-- Mỗi item có data-category để xác định nội dung dropdown -->
                            <a href="#" class="category-item dropdown-trigger" data-category="clinics">
                                <i class="fas fa-hospital me-2"></i>
                                Bệnh viện và phòng khám
                                <i class="fas fa-chevron-down small-icon ms-2"></i>
                            </a>

                            <a href="#" class="category-item dropdown-trigger" data-category="posts">
                                <i class="fas fa-newspaper me-2"></i>
                                Tin tức và bài viết
                                <i class="fas fa-chevron-down small-icon ms-2"></i>
                            </a>

                            <a href="#" class="category-item dropdown-trigger" data-category="tools">
                                <i class="fas fa-heartbeat me-2"></i>
                                Công cụ đo lường sức khỏe
                                <i class="fas fa-chevron-down small-icon ms-2"></i>
                            </a>

                            <a href="#" class="category-item dropdown-trigger" data-category="services">
                                <i class="fas fa-procedures me-2"></i>
                                Dịch vụ
                                <i class="fas fa-chevron-down small-icon ms-2"></i>
                            </a>

                            <a href="#" class="category-item dropdown-trigger" data-category="specialties">
                                <i class="fas fa-stethoscope me-2"></i>
                                Chuyên khoa
                                <i class="fas fa-chevron-down small-icon ms-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Nút điều hướng phải -->
                    <button class="slider-nav slider-nav-next me-3" id="sliderNext">
                        <i class="fas fa-chevron-right"></i>
                    </button>

                    <!-- Tìm kiếm -->
                    <div class="search-container">
                        <div class="search-input-group">
                            <input type="text" class="search-form-control" placeholder="Tìm kiếm...">
                            <button class="search-btn">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Phần dropdown sẽ mở rộng trong bottombar -->
                <div class="bottombar-dropdown" id="bottombar-dropdown">
                    <div class="dropdown-content" id="dropdown-content"></div>
                </div>
            </div>
        </div>

        <div class="dropdown-templates" style="display: none;">

            <template id="dropdown-template-clinics">
                <div class="row py-4">
                    <div class="col-md-4">
                        <h6 class="dropdown-header">Bệnh viện</h6>
                        <div class="dropdown-divider"></div>
                        <div class="clinic-list">
                            @foreach ($dropdownData['clinics']['hospitals'] as $hospital)
                                <a href="/clinic/{{ $hospital->id }}"
                                    class="clinic-item d-flex align-items-center mb-2">
                                    <div class="clinic-logo me-2">
                                        @if ($hospital->photo)
                                            <img src="{{ $hospital->photo }}" alt="{{ $hospital->name }}"
                                                class="img-fluid clinic-thumbnail">
                                        @else
                                            <div class="clinic-thumbnail-placeholder">
                                                <i class="fas fa-hospital"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="clinic-name">{{ $hospital->name }}</span>
                                </a>
                            @endforeach

                            <a href="/clinics?type=hospital" class="item-viewall dropdown-item view-all mt-2">
                                <i class="fas fa-angle-right me-1"></i> Xem tất cả
                                ({{ $dropdownData['clinics']['totalHospitals'] }})
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h6 class="dropdown-header">Phòng khám</h6>
                        <div class="dropdown-divider"></div>
                        <div class="clinic-list">
                            @foreach ($dropdownData['clinics']['clinics'] as $clinic)
                                <a href="/clinic/{{ $clinic->id }}"
                                    class="clinic-item d-flex align-items-center mb-2">
                                    <div class="clinic-logo me-2">
                                        @if ($clinic->photo)
                                            <img src="{{ $clinic->photo }}" alt="{{ $clinic->name }}"
                                                class="img-fluid clinic-thumbnail">
                                        @else
                                            <div class="clinic-thumbnail-placeholder">
                                                <i class="fas fa-clinic-medical"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <span class="clinic-name">{{ $clinic->name }}</span>
                                </a>
                            @endforeach

                            <a href="/clinics?type=clinic" class="item-viewall dropdown-item view-all mt-2">
                                <i class="fas fa-angle-right me-1"></i> Xem tất cả
                                ({{ $dropdownData['clinics']['totalClinics'] }})
                            </a>
                        </div>

                    </div>
                    <div class="col-md-4">
                        <div class="dropdown-image-container">
                            <img src="https://plus.unsplash.com/premium_photo-1682130157004-057c137d96d5?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                                alt="Bệnh viện và phòng khám" class="dropdown-image">
                            <div class="dropdown-cta">
                                <p>Tìm kiếm bệnh viện và phòng khám phù hợp với nhu cầu của bạn</p>
                                <a href="/clinics" class="btn btn-primary btn-sm">Xem tất cả</a>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            {{-- <template id="dropdown-template-posts">
                <div class="row py-4">
                    <!-- Cột các danh mục bài viết chính -->
                    <div class="col-md-8">
                        <div class="row">
                            <!-- Danh mục bài viết -->
                            @foreach ($dropdownData['posts']['categories'] as $category)
                                <div class="col-md-6 mb-3">
                                    <div class="category-item-container">
                                        <div class="d-flex align-items-center mb-2">
                                            @if ($category->photo)
                                                <div class="category-image me-2">
                                                    <img src="{{ $category->photo }}" alt="{{ $category->name }}"
                                                        class="img-fluid category-thumbnail">
                                                </div>
                                            @else
                                                <div class="category-icon me-2">
                                                    <i class="fas fa-folder"></i>
                                                </div>
                                            @endif
                                            <h6 class="category-title mb-0">{{ $category->name }}</h6>
                                            <span class="post-count ms-2">({{ $category->total_posts_count }})</span>
                                        </div>

                                        @if ($category->children_with_posts->count() > 0)
                                            <div class="subcategories ms-4">
                                                @foreach ($category->children_with_posts as $child)
                                                    <a href="/category/{{ $child->slug }}"
                                                        class="subcategory-link d-block mb-1">
                                                        {{ $child->name }} <span
                                                            class="post-count">({{ $child->posts_count }})</span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @endif

                                        <a href="/category/{{ $category->slug }}" class="category-view-all">
                                            Xem tất cả <i class="fas fa-angle-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Cột bài viết mới nhất -->
                    <div class="col-md-4">
                        <h6 class="dropdown-header">Bài viết mới nhất</h6>
                        <div class="dropdown-divider"></div>

                        <div class="recent-posts">
                            @foreach ($dropdownData['posts']['recentPosts'] as $post)
                                <a href="/post/{{ $post->slug }}"
                                    class="recent-post-item d-flex align-items-center mb-2">
                                    <div class="post-image-container me-2">
                                        @if ($post->photo)
                                            <img src="{{ $post->photo }}" alt="{{ $post->title }}"
                                                class="img-fluid post-thumbnail">
                                        @else
                                            <div class="post-thumbnail-placeholder">
                                                <i class="fas fa-newspaper"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="post-info">
                                        <div class="post-title">{{ $post->title }}</div>
                                        <div class="post-meta">
                                            <span
                                                class="post-category">{{ $post->cat_info->title ?? 'Chưa phân loại' }}</span>
                                            <span
                                                class="post-date">{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            <a href="/blog" class="dropdown-item view-all mt-2">
                                <i class="fas fa-angle-right me-1"></i> Xem tất cả
                                ({{ $dropdownData['posts']['totalPosts'] }})
                            </a>
                        </div>
                    </div>
                </div>
            </template> --}}
            <template id="dropdown-template-posts">
                <div class="row py-4">
                    <!-- Cột các danh mục bài viết chính -->
                    <div class="col-md-8">
                        <div class="row">
                            <!-- Danh mục bài viết -->
                            @foreach ($dropdownData['posts']['categories'] as $category)
                                <div class="col-md-6 mb-3">
                                    <div class="category-item-container">
                                        <div class="d-flex align-items-center mb-2">
                                            @if ($category->photo)
                                                <div class="category-image me-2">
                                                    <img src="{{ $category->photo }}" alt="{{ $category->name }}"
                                                        class="img-fluid category-thumbnail">
                                                </div>
                                            @else
                                                <div class="category-icon me-2">
                                                    <i class="{{ $category->icon ?? 'fas fa-folder' }}"></i>
                                                </div>
                                            @endif

                                            <!-- Nếu có danh mục con thì thêm lớp dropdown -->
                                            <h6
                                                class="category-title {{ $category->children_with_posts->count() > 0 ? 'has-subcategories' : '' }} mb-0">
                                                <a href="/category/{{ $category->slug }}"
                                                    class="category-link">{{ $category->name }}</a>
                                                @if ($category->children_with_posts->count() > 0)
                                                    <span class="subcategory-toggle ms-1">
                                                        <i class="fas fa-chevron-down small-icon"></i>
                                                    </span>
                                                @endif
                                            </h6>
                                            <span class="post-count ms-2">({{ $category->total_posts_count }})</span>
                                        </div>

                                        @if ($category->children_with_posts->count() > 0)
                                            <div class="subcategories ms-4" style="display: none;">
                                                @foreach ($category->children_with_posts as $child)
                                                    <a href="/category/{{ $child->slug }}"
                                                        class="subcategory-link d-block mb-1">
                                                        {{ $child->name }} <span
                                                            class="post-count">({{ $child->posts_count }})</span>
                                                    </a>
                                                @endforeach

                                                <a href="/category/{{ $category->slug }}"
                                                    class="category-view-all mt-2">
                                                    Xem tất cả <i class="fas fa-angle-right ms-1"></i>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Cột bài viết mới nhất -->
                    <div class="col-md-4">
                        <h6 class="dropdown-header">Bài viết mới nhất</h6>
                        <div class="dropdown-divider"></div>

                        <div class="recent-posts">
                            @foreach ($dropdownData['posts']['recentPosts'] as $post)
                                <a href="/post/{{ $post->slug }}"
                                    class="recent-post-item d-flex align-items-center mb-2">
                                    <div class="post-image-container me-2">
                                        @if ($post->photo)
                                            <img src="{{ $post->photo }}" alt="{{ $post->title }}"
                                                class="img-fluid post-thumbnail">
                                        @else
                                            <div class="post-thumbnail-placeholder">
                                                <i class="fas fa-newspaper"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="post-info">
                                        <div class="post-title">{{ $post->title }}</div>
                                        <div class="post-meta">
                                            <span
                                                class="post-category">{{ $post->cat_info->title ?? 'Chưa phân loại' }}</span>
                                            <span
                                                class="post-date">{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </a>
                            @endforeach

                            <a href="/blog" class="dropdown-item view-all mt-2">
                                <i class="fas fa-angle-right me-1"></i> Xem tất cả
                                ({{ $dropdownData['posts']['totalPosts'] }})
                            </a>
                        </div>
                    </div>
                </div>
            </template>







            <!-- Tương tự cho các template khác... -->
            {{-- 
            @include('layouts.partials.dropdown-templates.clinics')
            @include('layouts.partials.dropdown-templates.posts') --}}
        </div>
    </div>
</header>

<style>
    /* Variables */
    :root {
        --primary-color: #1565C0;
        /* Xanh dương đậm cho navbar */
        --primary-dark: #0D47A1;
        /* Xanh dương đậm hơn cho top bar */
        --primary-text: #1565C0;
        /* Màu chữ chính (xanh) */
        --white: #ffffff;
        --light-gray: #f8f9fa;
        --border-color: #e9ecef;
        --text-gray: #6c757d;
        --transition: all 0.3s ease-in-out;
        --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
        --shadow-md: 0 6px 12px rgba(0, 0, 0, 0.15);
    }

    /* ===== HEADER STRUCTURE ===== */
    .main-header {
        position: sticky;
        top: 0;
        width: 100%;
        z-index: 1000;
        background-color: var(--white);
        animation: fadeIn 0.6s ease-in-out;
    }

    .header-wrapper {
        display: flex;
        flex-direction: column;
        position: relative;
    }

    /* ===== NAVBAR STYLING ===== */
    .navbar {
        background: var(--primary-color);
        padding: 15px 0 0;
        transition: var(--transition);
        border: none;
        box-shadow: var(--shadow-sm);
        margin-bottom: 0;
    }

    .nav-link.active::after,
    .nav-item .active::after,
    .nav-link::after {
        display: none !important;
    }

    /* Logo styling */
    #logo {
        margin-bottom: 10px;
    }

    .logo {
        height: 50px;
        width: 50px;
        border-radius: 50%;
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }

    .navbar-brand {
        color: var(--white);
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: var(--transition);
    }

    /* Navbar toggle button */
    .navbar-toggler {
        border-color: rgba(255, 255, 255, 0.5);
        transition: var(--transition);
    }

    .navbar-toggler:focus {
        box-shadow: 0 0 0 0.15rem rgba(255, 255, 255, 0.25);
    }

    .navbar-toggler-icon {
        filter: invert(1);
    }

    /* Nav links styling */
    .nav-link {
        color: rgba(255, 255, 255, 0.9);
        transition: var(--transition);
        position: relative;
        font-weight: 500;
    }

    .nav-link:hover {
        color: var(--white);
        background-color: rgba(255, 255, 255, 0.1);
    }

    .nav-link.active {
        color: var(--white);
        background-color: rgba(255, 255, 255, 0.15);
        font-weight: 600;
    }

    .nav-link:after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 50%;
        width: 0;
        height: 2px;
        background-color: var(--white);
        transition: var(--transition);
        transform: translateX(-50%);
    }

    .nav-link:hover:after,
    .nav-link.active:after {
        width: 60%;
    }

    /* Login/Logout buttons */
    .login-btn,
    .logout-btn {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 6px;
        padding: 8px 16px;
        transition: var(--transition);
    }

    .login-btn:hover,
    .logout-btn:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    /* Notification styling */
    .notification-badge {
        position: absolute;
        top: 2px;
        right: 2px;
        font-size: 10px;
        background-color: #FF5252;
        color: var(--white);
        min-width: 18px;
        height: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        padding: 0 4px;
        font-weight: bold;
    }

    .notification-dropdown {
        min-width: 500px;
        padding: 0;
        border: none;
        margin-top: 10px;
    }

    .notification-content-list {
        max-height: 350px;
        overflow-y: auto;
    }


    /* Submenu list styling */
    .submenu-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .submenu-list li {
        margin-bottom: 12px;
    }

    .submenu-list li a {
        color: var(--primary-text);
        text-decoration: none;
        font-size: 14px;
        display: block;
        padding: 4px 0;
        transition: var(--transition);
        position: relative;
    }

    .submenu-list li a:hover {
        color: var(--primary-color);
        transform: translateX(5px);
        font-weight: 500;
    }

    /* Responsive adjustments for submenu */
    @media (max-width: 991.98px) {
        .dropdown-body .row {
            flex-direction: column;
        }

        .category-image {
            margin-bottom: 20px;
        }

        .submenu-panel {
            position: fixed;
            height: 80vh;
            overflow-y: auto;
            top: 60px;
            /* Điều chỉnh vị trí để không che phủ navbar và nút toggle */
            bottom: 0;
        }

        /* Tối ưu vị trí dropdown trên mobile */
        .navbar .container {
            position: relative;
        }

        .navbar-brand {
            max-width: 80%;
        }

        /* Đảm bảo logo và toggle không bị che khuất */
        #logo {
            z-index: 1050;
            position: relative;
        }

        .navbar-toggler {
            margin-left: auto;
        }
    }

    @media (max-width: 767.98px) {
        .dropdown-content {
            padding: 15px 0;
        }

        .submenu-list {
            margin-bottom: 20px;
        }
    }


    /* =======================Dropdown ====================*/
    /* Cải tiến cho bottombar */
    .bottombar {
        background-color: var(--white);
        padding: 20px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .popular-categories {
        display: flex;
        align-items: center;
    }

    .popular-title {
        color: var(--primary-text);
        font-weight: 600;
        margin: 0;
        white-space: nowrap;
    }

    /* Container cho danh mục */
    .category-items-container {
        overflow: hidden;
    }

    .category-items {
        display: flex;
        gap: 10px;
        overflow-x: auto;
        -ms-overflow-style: none;
        /* IE và Edge */
        scrollbar-width: none;
        /* Firefox */
        scroll-behavior: smooth;
    }

    .category-items::-webkit-scrollbar {
        display: none;
        /* Chrome, Safari, Opera */
    }

    .category-item {
        display: inline-flex;
        align-items: center;
        color: var(--primary-text);
        text-decoration: none;
        padding: 8px 15px;
        font-size: 14px;
        font-weight: 500;
        background-color: rgba(21, 101, 192, 0.08);
        border-radius: 20px;
        transition: all 0.3s ease;
        white-space: nowrap;
        height: 36px;
        flex-shrink: 0;
    }

    .category-item:hover {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(21, 101, 192, 0.2);
    }

    .category-item i {
        font-size: 12px;
        opacity: 0.8;
    }

    /* Nút điều hướng */
    .slider-nav {
        width: 30px;
        height: 30px;
        min-width: 30px;
        border-radius: 50%;
        background-color: var(--white);
        border: 1px solid var(--border-color);
        color: var(--primary-text);
        font-size: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        flex-shrink: 0;
    }

    .slider-nav:hover {
        background-color: var(--primary-color);
        color: var(--white);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }

    /* Cải tiến cho search container */
    .search-container {
        flex-shrink: 0;
        width: 220px;
    }

    .search-input-group {
        display: flex;
        position: relative;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
        border-radius: 20px;
        overflow: hidden;
        height: 36px;
    }

    .search-form-control {
        width: 100%;
        height: 36px;
        padding: 8px 15px;
        border: 1px solid var(--border-color);
        border-right: none;
        border-radius: 20px 0 0 20px;
        outline: none;
        font-size: 14px;
        background-color: var(--white);
        transition: var(--transition);
    }

    .search-btn {
        background-color: var(--primary-color);
        color: var(--white);
        border: none;
        padding: 0 15px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
        border-radius: 0 20px 20px 0;
        flex-shrink: 0;
    }

    .search-btn:hover {
        background-color: var(--primary-dark);
    }

    /* Bottombar dropdown */
    .bottombar-dropdown {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.5s ease, opacity 0.3s ease;
        opacity: 0;
        border-top: 1px solid transparent;
        margin-top: 0;
    }

    .bottombar-dropdown.show {
        max-height: 450px;

        opacity: 1;
        border-top: 1px solid var(--border-color);
        margin-top: 15px;
    }

    /* Dropdown content styling */
    .dropdown-header {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .dropdown-divider {
        margin: 8px 0;
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    .dropdown-item {
        color: #555;
        padding: 6px 0;
        font-size: 14px;
        text-decoration: none;
        display: block;
        transition: all 0.2s ease;
    }

    .dropdown-item:hover {
        color: var(--primary-color);
        transform: translateX(5px);
    }

    .dropdown-image-container {
        height: 100%;
        padding: 10px;
    }

    .dropdown-image {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 6px;
    }

    .dropdown-cta {
        margin-top: 15px;
    }

    .dropdown-cta p {
        font-size: 13px;
        color: #555;
        margin-bottom: 10px;
    }

    .view-all {
        font-weight: 500;
        color: var(--primary-color) !important;
    }

    /* .item-viewall {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-right: 30px;
    } */

    /* Responsive styles */
    @media (max-width: 992px) {
        .popular-categories {
            flex-wrap: wrap;
        }

        .popular-title-container {
            width: 100%;
            margin-bottom: 10px;
        }

        .category-items-container {
            order: 3;
            width: 100%;
            margin: 10px 0;
        }

        .search-container {
            order: 4;
            width: 100%;
        }

        .slider-nav {
            order: 2;
        }

        .slider-nav-next {
            order: 5;
        }

        .bottombar-dropdown.show {
            max-height: 600px;
        }

        .dropdown-image-container {
            display: none;
        }
    }

    @media (max-width: 576px) {
        .category-item {
            padding: 6px 12px;
            font-size: 13px;
        }
    }

    /* Styling cho danh sách bệnh viện/phòng khám */
    .clinic-list {
        padding: 0;
    }

    .clinic-item {
        padding: 8px 60px;
        text-decoration: none;
        color: #333;
        border-radius: 6px;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
    }

    .clinic-item:hover {
        background-color: rgba(21, 101, 192, 0.08);
        transform: translateX(5px);
        color: var(--primary-color);
    }

    .clinic-thumbnail {
        width: 36px;
        height: 36px;
        object-fit: cover;
        border-radius: 4px;
        border: 1px solid #eee;
    }

    .clinic-thumbnail-placeholder {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f5f5;
        border-radius: 4px;
        color: #777;
        font-size: 16px;
    }

    .clinic-name {
        font-size: 14px;
        margin-left: 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 200px;
    }

    /* Styling cho danh mục bài viết */
    .category-item-container {
        padding: 10px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }

    .category-item-container:hover {
        background-color: rgba(21, 101, 192, 0.05);
    }

    .category-thumbnail,
    .category-icon {
        width: 36px;
        height: 36px;
        border-radius: 4px;
    }

    .category-thumbnail {
        object-fit: cover;
    }

    .category-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: rgba(21, 101, 192, 0.1);
        color: var(--primary-color);
        font-size: 16px;
    }

    .category-title {
        font-size: 16px;
        font-weight: 600;
        color: var(--primary-text);
    }

    .post-count {
        font-size: 13px;
        color: #777;
        font-weight: normal;
    }

    .subcategories {
        margin-bottom: 10px;
    }

    .subcategory-link {
        color: #555;
        font-size: 14px;
        text-decoration: none;
        transition: all 0.2s ease;
        display: inline-block;
    }

    .subcategory-link:hover {
        color: var(--primary-color);
        transform: translateX(3px);
    }

    .category-view-all {
        font-size: 14px;
        color: var(--primary-color);
        text-decoration: none;
        font-weight: 500;
        display: inline-block;
        margin-top: 5px;
    }

    .category-view-all:hover {
        text-decoration: underline;
    }

    /* Recent posts styling */
    .recent-post-item {
        padding: 8px;
        border-radius: 6px;
        text-decoration: none;
        color: #333;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
    }

    .recent-post-item:hover {
        background-color: rgba(21, 101, 192, 0.05);
    }

    .post-thumbnail,
    .post-thumbnail-placeholder {
        width: 60px;
        height: 45px;
        border-radius: 4px;
    }

    .post-thumbnail {
        object-fit: cover;
    }

    .post-thumbnail-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f5f5;
        color: #777;
        font-size: 20px;
    }

    .post-info {
        flex: 1;
        min-width: 0;
        margin-left: 10px;
    }

    .post-title {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 3px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .post-meta {
        font-size: 12px;
        color: #777;
    }

    .post-category {
        color: var(--primary-color);
    }

    .post-date {
        margin-left: 8px;
        position: relative;
    }

    .post-date:before {
        content: '•';
        position: absolute;
        left: -6px;
    }

    .category-title.has-subcategories {
        cursor: pointer;
        position: relative;
    }

    .category-link {
        text-decoration: none;
        color: inherit;
    }

    .category-link:hover {
        color: var(--primary-color);
    }

    .subcategory-toggle {
        cursor: pointer;
        font-size: 12px;
        opacity: 0.7;
        transition: all 0.3s;
    }

    .subcategory-toggle.active i {
        transform: rotate(180deg);
    }

    .category-title.has-subcategories:hover .subcategory-toggle {
        opacity: 1;
    }

    .subcategories {
        padding-left: 10px;
        margin-top: 6px;
        margin-bottom: 10px;
        border-left: 2px solid rgba(21, 101, 192, 0.1);
        transition: all 0.3s ease;
    }

    /* Animation cho dropdown */
    .subcategories.show {
        display: block !important;
        animation: fadeInDown 0.3s ease;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    // Thêm hiệu ứng sticky và thu nhỏ khi cuộn
    document.addEventListener('DOMContentLoaded', function() {
        const navbar = document.querySelector('.navbar');
        const bottombar = document.querySelector('.bottombar');

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 50) {
                navbar.classList.add('sticky');
            } else {
                navbar.classList.remove('sticky');
            }
        });

        // Xử lý slider cho categories
        const categoryList = document.querySelector('.category-list');

        // Kiểm tra overflow
        function checkOverflow() {
            if (categoryList && categoryList.scrollWidth > categoryList.clientWidth) {
                categoryList.parentElement.classList.add('has-overflow');
            } else if (categoryList) {
                categoryList.parentElement.classList.remove('has-overflow');
            }
        }

        checkOverflow();
        window.addEventListener('resize', checkOverflow);

        // Xử lý hover cho danh mục
        const dropdownCategories = document.querySelectorAll('.dropdown-category');
        const submenuOverlay = document.querySelector('.submenu-overlay');

        if (dropdownCategories && submenuOverlay) {
            dropdownCategories.forEach(category => {
                const categoryId = category.getAttribute('data-category');
                const submenuPanel = document.getElementById('submenu-panel-' + categoryId);

                if (submenuPanel) {
                    // Khi hover vào danh mục
                    category.addEventListener('mouseenter', function() {
                        // Ẩn tất cả các submenu panel trước
                        document.querySelectorAll('.submenu-panel').forEach(panel => {
                            panel.classList.remove('active');
                            panel.style.display = 'none';
                        });

                        // Hiển thị submenu hiện tại
                        submenuPanel.style.display = 'block';

                        // Thêm timeout nhỏ để tạo hiệu ứng mượt mà
                        setTimeout(() => {
                            submenuPanel.classList.add('active');
                        }, 10);
                    });

                    // Khi di chuột ra khỏi danh mục
                    category.addEventListener('mouseleave', function(e) {
                        // Kiểm tra xem chuột có di chuyển vào submenu panel hay không
                        const toElement = e.relatedTarget;

                        if (!toElement || !submenuPanel.contains(toElement)) {
                            if (!submenuOverlay.contains(toElement)) {
                                submenuPanel.classList.remove('active');

                                // Đợi hiệu ứng fade out hoàn tất rồi mới ẩn panel
                                setTimeout(() => {
                                    if (!submenuPanel.classList.contains('active')) {
                                        submenuPanel.style.display = 'none';
                                    }
                                }, 200);
                            }
                        }
                    });
                }
            });

            // Xử lý hover cho submenu panel
            const submenuPanels = document.querySelectorAll('.submenu-panel');
            submenuPanels.forEach(panel => {
                // Khi hover vào submenu panel
                panel.addEventListener('mouseenter', function() {
                    panel.classList.add('active');
                });

                // Khi rời khỏi submenu panel
                panel.addEventListener('mouseleave', function() {
                    panel.classList.remove('active');

                    setTimeout(() => {
                        if (!panel.classList.contains('active')) {
                            panel.style.display = 'none';
                        }
                    }, 200);
                });
            });

            // Đóng tất cả submenu khi click ra ngoài
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.dropdown-category') && !e.target.closest('.submenu-panel')) {
                    document.querySelectorAll('.submenu-panel').forEach(panel => {
                        panel.classList.remove('active');
                        setTimeout(() => {
                            panel.style.display = 'none';
                        }, 200);
                    });
                }
            });
        }

        // Xử lý cho mobile - đảm bảo submenu đóng khi click vào đường dẫn
        const submenuLinks = document.querySelectorAll('.submenu-list a');
        submenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth < 992) {
                    document.querySelectorAll('.submenu-panel').forEach(panel => {
                        panel.classList.remove('active');
                        panel.style.display = 'none';
                    });
                }
            });
        });

        // ======================== MỚI: Xử lý dropdown danh mục con trong template posts ========================
        // Xử lý dropdown danh mục con khi click
        const categoryToggles = document.querySelectorAll('.subcategory-toggle');

        categoryToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Lấy container cha
                const categoryContainer = this.closest('.category-item-container');
                const subcategoriesElem = categoryContainer.querySelector('.subcategories');
                const icon = this.querySelector('i');

                // Toggle hiển thị
                if (subcategoriesElem.style.display === 'none' || !subcategoriesElem.classList
                    .contains('show')) {
                    subcategoriesElem.style.display = 'block';
                    subcategoriesElem.classList.add('show');
                    icon.style.transform = 'rotate(180deg)';
                    this.classList.add('active');
                } else {
                    subcategoriesElem.classList.remove('show');
                    setTimeout(() => {
                        subcategoriesElem.style.display = 'none';
                    }, 300);
                    icon.style.transform = 'rotate(0)';
                    this.classList.remove('active');
                }
            });
        });

        // Xử lý hover (cho desktop)
        if (window.matchMedia('(min-width: 992px)').matches) {
            const categoryContainers = document.querySelectorAll('.category-item-container');

            categoryContainers.forEach(container => {
                const hasSubcategories = container.querySelector('.has-subcategories');
                if (hasSubcategories) {
                    const subcategoriesElem = container.querySelector('.subcategories');

                    // Hiện khi hover
                    container.addEventListener('mouseenter', function() {
                        subcategoriesElem.style.display = 'block';
                        subcategoriesElem.classList.add('show');
                        const icon = container.querySelector('.subcategory-toggle i');
                        if (icon) {
                            icon.style.transform = 'rotate(180deg)';
                        }
                    });

                    // Ẩn khi rời chuột
                    container.addEventListener('mouseleave', function() {
                        subcategoriesElem.classList.remove('show');
                        setTimeout(() => {
                            subcategoriesElem.style.display = 'none';
                        }, 300);
                        const icon = container.querySelector('.subcategory-toggle i');
                        if (icon) {
                            icon.style.transform = 'rotate(0)';
                        }
                    });
                }
            });
        }
        // ======================== HẾT PHẦN MỚI ========================
    });

    document.addEventListener('DOMContentLoaded', function() {
        const categoryItems = document.querySelector('.category-items');
        const prevBtn = document.getElementById('sliderPrev');
        const nextBtn = document.getElementById('sliderNext');

        if (categoryItems && prevBtn && nextBtn) {
            // Kiểm tra xem có cần hiển thị nút điều hướng không
            function checkOverflow() {
                const isOverflowing = categoryItems.scrollWidth > categoryItems.clientWidth;
                prevBtn.style.display = isOverflowing ? 'flex' : 'none';
                nextBtn.style.display = isOverflowing ? 'flex' : 'none';
            }

            // Thiết lập ban đầu
            checkOverflow();

            // Kiểm tra lại khi cửa sổ thay đổi kích thước
            window.addEventListener('resize', checkOverflow);

            // Xử lý sự kiện nút trước
            prevBtn.addEventListener('click', function() {
                categoryItems.scrollBy({
                    left: -200,
                    behavior: 'smooth'
                });
            });

            // Xử lý sự kiện nút sau
            nextBtn.addEventListener('click', function() {
                categoryItems.scrollBy({
                    left: 200,
                    behavior: 'smooth'
                });
            });
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Khởi tạo dropdown trong bottombar
        initBottombarDropdown();

        // Xử lý slider cho danh mục
        initCategorySlider();
    });

    function initBottombarDropdown() {
        const dropdownTriggers = document.querySelectorAll('.dropdown-trigger');
        const bottombarDropdown = document.getElementById('bottombar-dropdown');
        const dropdownContent = document.getElementById('dropdown-content');

        if (!dropdownTriggers.length || !bottombarDropdown || !dropdownContent) return;

        // Biến để lưu trạng thái
        let activeCategory = null;
        let dropdownTimeout = null;
        let isDropdownOpen = false;

        // Xử lý cho từng trigger button
        dropdownTriggers.forEach(trigger => {
            const categoryType = trigger.getAttribute('data-category');

            // Cả desktop và mobile đều xử lý click
            trigger.addEventListener('click', function(e) {
                e.preventDefault();

                // Kiểm tra xem item hiện tại có đang active không
                const isCurrentlyActive = activeCategory === categoryType;

                // Dọn dẹp timeout nếu có
                if (dropdownTimeout) {
                    clearTimeout(dropdownTimeout);
                    dropdownTimeout = null;
                }

                if (isCurrentlyActive && isDropdownOpen) {
                    // Đang active, đóng dropdown
                    bottombarDropdown.classList.remove('show');
                    clearActiveItems();
                    isDropdownOpen = false;
                    activeCategory = null;
                } else {
                    // Nếu chưa active hoặc dropdown đang đóng, mở dropdown
                    clearActiveItems();
                    trigger.classList.add('active');
                    showDropdownContent(categoryType, dropdownContent);
                    bottombarDropdown.classList.add('show');
                    isDropdownOpen = true;
                    activeCategory = categoryType;
                }
            });

            // Desktop: Thêm hover
            if (window.matchMedia('(min-width: 992px)').matches) {
                // Hover vào menu item
                trigger.addEventListener('mouseenter', function() {
                    // Hủy timeout nếu có
                    if (dropdownTimeout) {
                        clearTimeout(dropdownTimeout);
                        dropdownTimeout = null;
                    }

                    // Đánh dấu item đang active
                    clearActiveItems();
                    trigger.classList.add('active');

                    // Hiển thị nội dung dropdown
                    showDropdownContent(categoryType, dropdownContent);

                    // Mở rộng dropdown container
                    bottombarDropdown.classList.add('show');
                    isDropdownOpen = true;
                    activeCategory = categoryType;
                });
            }
        });

        // Xử lý hover cho toàn bộ khu vực bottombar
        const bottombarArea = document.querySelector('.bottombar');

        if (bottombarArea && window.matchMedia('(min-width: 992px)').matches) {
            // Khi rời khỏi bottombar
            bottombarArea.addEventListener('mouseleave', function() {
                // Đặt timeout để đóng dropdown sau một thời gian
                dropdownTimeout = setTimeout(() => {
                    bottombarDropdown.classList.remove('show');
                    clearActiveItems();
                    isDropdownOpen = false;
                    activeCategory = null;
                }, 300); // Timeout dài hơn để người dùng có thể di chuyển thoải mái
            });

            // Khi quay lại bottombar
            bottombarArea.addEventListener('mouseenter', function() {
                // Nếu có timeout đang chờ đóng dropdown, hủy nó
                if (dropdownTimeout) {
                    clearTimeout(dropdownTimeout);
                    dropdownTimeout = null;
                }
            });
        }

        // Xử lý click ra ngoài để đóng dropdown
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.bottombar')) {
                bottombarDropdown.classList.remove('show');
                clearActiveItems();
                isDropdownOpen = false;
                activeCategory = null;
            }
        });
    }

    function clearActiveItems() {
        document.querySelectorAll('.dropdown-trigger').forEach(item => {
            item.classList.remove('active');
        });
    }

    function showDropdownContent(categoryType, container) {
        // Lấy template tương ứng
        const template = document.getElementById(`dropdown-template-${categoryType}`);

        if (template) {
            // Clone template vào container
            container.innerHTML = template.innerHTML;

            // Nạp dữ liệu động vào template
            loadDynamicContent(categoryType, container);

            // =============== MỚI: Khởi tạo handlers cho phần dropdown danh mục con ===============
            if (categoryType === 'posts') {
                // Chạy lại các handlers cho toggles trong dropdown vừa được render
                initSubcategoryToggles(container);
            }
            // =============== HẾT PHẦN MỚI ===============
        } else {
            container.innerHTML = '<div class="p-4 text-center">Nội dung đang được cập nhật</div>';
        }
    }


    function initSubcategoryToggles(container) {
        // Xử lý click vào toggle icons
        const categoryToggles = container.querySelectorAll('.subcategory-toggle');

        categoryToggles.forEach(toggle => {
            toggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Lấy container cha
                const categoryContainer = this.closest('.category-item-container');
                const subcategoriesElem = categoryContainer.querySelector('.subcategories');
                const icon = this.querySelector('i');

                // Toggle hiển thị
                if (subcategoriesElem.style.display === 'none' || !subcategoriesElem.classList.contains(
                        'show')) {
                    subcategoriesElem.style.display = 'block';
                    subcategoriesElem.classList.add('show');
                    icon.style.transform = 'rotate(180deg)';
                    this.classList.add('active');
                } else {
                    subcategoriesElem.classList.remove('show');
                    setTimeout(() => {
                        subcategoriesElem.style.display = 'none';
                    }, 300);
                    icon.style.transform = 'rotate(0)';
                    this.classList.remove('active');
                }
            });
        });

        // Xử lý hover (cho desktop)
        if (window.matchMedia('(min-width: 992px)').matches) {
            const categoryContainers = container.querySelectorAll('.category-item-container');

            categoryContainers.forEach(container => {
                const hasSubcategories = container.querySelector('.has-subcategories');
                if (hasSubcategories) {
                    const subcategoriesElem = container.querySelector('.subcategories');

                    // Hiện khi hover
                    container.addEventListener('mouseenter', function() {
                        subcategoriesElem.style.display = 'block';
                        subcategoriesElem.classList.add('show');
                        const icon = container.querySelector('.subcategory-toggle i');
                        if (icon) {
                            icon.style.transform = 'rotate(180deg)';
                        }
                    });

                    // Ẩn khi rời chuột
                    container.addEventListener('mouseleave', function() {
                        subcategoriesElem.classList.remove('show');
                        setTimeout(() => {
                            subcategoriesElem.style.display = 'none';
                        }, 300);
                        const icon = container.querySelector('.subcategory-toggle i');
                        if (icon) {
                            icon.style.transform = 'rotate(0)';
                        }
                    });
                }
            });
        }
    }


    function loadDynamicContent(categoryType, container) {

        if (categoryType === 'clinics' && window.dropdownData && window.dropdownData.clinics) {
            const hospitalsList = container.querySelector('.hospitals-list');
            const clinicsList = container.querySelector('.clinics-list');

            if (hospitalsList && window.dropdownData.clinics.hospitals) {
                hospitalsList.innerHTML = window.dropdownData.clinics.hospitals.map(hospital =>
                    `<a class="dropdown-item" href="/clinic/${hospital.id}">${hospital.name}</a>`
                ).join('');
            }

            if (clinicsList && window.dropdownData.clinics.clinics) {
                clinicsList.innerHTML = window.dropdownData.clinics.clinics.map(clinic =>
                    `<a class="dropdown-item" href="/clinic/${clinic.id}">${clinic.name}</a>`
                ).join('');
            }
        }

        // Tương tự cho các loại khác
    }

    // Khởi tạo slider cho danh mục
    function initCategorySlider() {
        const categoryItems = document.querySelector('.category-items');
        const prevBtn = document.getElementById('sliderPrev');
        const nextBtn = document.getElementById('sliderNext');

        if (categoryItems && prevBtn && nextBtn) {
            // Kiểm tra xem có cần hiển thị nút điều hướng không
            function checkOverflow() {
                const isOverflowing = categoryItems.scrollWidth > categoryItems.clientWidth;
                prevBtn.style.display = isOverflowing ? 'flex' : 'none';
                nextBtn.style.display = isOverflowing ? 'flex' : 'none';
            }

            // Thiết lập ban đầu
            checkOverflow();

            // Kiểm tra lại khi cửa sổ thay đổi kích thước
            window.addEventListener('resize', checkOverflow);

            // Xử lý sự kiện nút trước
            prevBtn.addEventListener('click', function() {
                categoryItems.scrollBy({
                    left: -200,
                    behavior: 'smooth'
                });
            });

            // Xử lý sự kiện nút sau
            nextBtn.addEventListener('click', function() {
                categoryItems.scrollBy({
                    left: 200,
                    behavior: 'smooth'
                });
            });
        }
    }
</script>
