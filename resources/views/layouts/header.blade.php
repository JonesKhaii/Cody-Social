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


        <!-- PHẦN BOTTOMBAR - Với dropdown cho danh mục -->
        <div class="bottombar">
            <div class="container">
                <div class="popular-categories">
                    <div class="row">
                        <div class="col-md-2 d-flex align-items-center">
                            <h6 class="popular-title mb-0">Danh mục phổ biến:</h6>
                        </div>
                        <div class="col-md-10">
                            <ul class="category-list">
                                @foreach ($parentCategories as $category)
                                    <li class="dropdown-category" data-category="{{ $category->id }}">
                                        <a href="{{ route('category.show', $category->slug) }}"
                                            class="{{ request()->is('category/' . $category->slug . '*') ? 'active' : '' }}">
                                            {{ $category->title }}
                                            @if ($category->children->count() > 0)
                                                <i class="fas fa-chevron-down small-icon"></i>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submenu panels - cải tiến để hiển thị overlay -->
        <div class="submenu-overlay">
            @foreach ($parentCategories as $category)
                @if ($category->children->count() > 0)
                    <!-- Phần submenu-panel trong submenu-overlay -->
                    <div class="submenu-panel" id="submenu-panel-{{ $category->id }}">
                        <div class="container">
                            <div class="dropdown-content">
                                <div class="dropdown-header">
                                    <h6>{{ $category->title }}</h6>
                                </div>
                                <div class="dropdown-body">
                                    <div class="row">
                                        <div class="col-md-3 mb-4">
                                            <div class="category-image">
                                                <div class="image-container">
                                                    <img src="{{ $category->photo }}"
                                                        alt="{{ $category->title }}"
                                                        class="img-fluid w-100 object-fit-cover h-auto rounded">
                                                </div>
                                                <div class="category-description mt-2">
                                                    <p class="text-muted small">
                                                        {{ $category->description ?? 'Khám phá chủ đề và bài viết về ' . $category->title }}
                                                    </p>
                                                    <a href="{{ route('category.show', $category->slug) }}"
                                                        class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="row">
                                                @php
                                                    $totalChildren = $category->children->count();
                                                    $perColumn = ceil($totalChildren / 3);
                                                @endphp

                                                @for ($col = 0; $col < 3; $col++)
                                                    <div class="col-md-4">
                                                        <ul class="submenu-list">
                                                            @foreach ($category->children as $index => $child)
                                                                @if ($index >= $col * $perColumn && $index < ($col + 1) * $perColumn)
                                                                    <li>
                                                                        <a
                                                                            href="{{ route('category.show', $child->slug) }}">
                                                                            {{ $child->title }}
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
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
        min-width: 300px;
        padding: 0;
        border: none;
        margin-top: 10px;
    }

    .notification-content-list {
        max-height: 350px;
        overflow-y: auto;
    }

    /* ===== BOTTOMBAR - CATEGORIES ===== */
    .bottombar {
        background-color: var(--white);
        padding: 10px 0;
        border-bottom: 1px solid var(--border-color);
        margin-top: 0;
        position: relative;
        z-index: 990;
    }

    .popular-title {
        color: var(--primary-text);
        font-weight: 600;
        margin-right: 10px;
    }

    /* Category list styling */
    .category-list {
        display: flex;
        list-style: none;
        margin: 0;
        padding: 0;
        overflow-x: auto;
        -ms-overflow-style: none;
        /* IE và Edge */
        scrollbar-width: none;
        /* Firefox */
        scroll-behavior: smooth;
        white-space: nowrap;
        padding-bottom: 5px;
    }

    .category-list::-webkit-scrollbar {
        display: none;
        /* Ẩn thanh cuộn trên Chrome, Safari */
    }

    .category-list li {
        margin: 0;
        padding: 0;
        flex-shrink: 0;
    }

    .category-list a {
        color: var(--primary-text);
        text-decoration: none;
        padding: 5px 15px;
        font-size: 14px;
        display: inline-block;
        transition: var(--transition);
        border-radius: 20px;
    }

    .category-list a:hover {
        background-color: var(--light-gray);
        transform: translateY(-2px);
    }

    .category-list a.active {
        background-color: var(--primary-color);
        color: var(--white);
        font-weight: 600;
        box-shadow: var(--shadow-sm);
    }

    /* Category slider styling */
    .category-slider {
        position: relative;
        overflow: hidden;
        padding: 0 30px;
        /* Thêm padding để có không gian cho nút điều hướng */
    }

    .slider-controls {
        display: none;
        /* Ẩn mặc định */
    }

    .slider-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: var(--white);
        border: 1px solid var(--border-color);
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: var(--shadow-sm);
        z-index: 1;
        font-size: 12px;
        color: var(--primary-text);
    }

    .slider-prev {
        left: 0;
    }

    .slider-next {
        right: 0;
    }

    .category-slider.has-overflow:hover .slider-controls {
        display: block;
    }

    /* Header shrink effect on scroll */
    .navbar.sticky {
        padding-top: 8px;
    }

    .navbar.sticky .logo {
        height: 40px;
        width: 40px;
    }

    .navbar.sticky .navbar-brand {
        font-size: 1.25rem;
    }

    .category-image .image-container {
        width: 100%;
        height: 180px;
        overflow: hidden;
        position: relative;
    }

    .category-image .image-container img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    /* ===== RESPONSIVE STYLES ===== */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background-color: var(--primary-color);
            border-radius: 0 0 8px 8px;
            padding: 15px;
            box-shadow: var(--shadow-md);
        }

        .nav-item {
            margin: 5px 0;
        }

        /* Đảm bảo nút toggle luôn hiển thị trên cùng */
        .navbar-toggler {
            position: relative;
            z-index: 1050;
            /* Cao hơn so với submenu overlay */
        }

        /* Đảm bảo submenu overlay không che phủ nút toggle */
        .submenu-overlay {
            z-index: 990;
            /* Thấp hơn so với nút toggle */
        }
    }

    @media (max-width: 767.98px) {
        .popular-title {
            margin-bottom: 10px !important;
        }

        .category-list {
            justify-content: flex-start;
        }
    }

    @media (max-width: 575.98px) {
        .category-list a {
            padding: 3px 10px;
            font-size: 13px;
        }
    }

    /* Tìm kiếm trong bottombar */
    .search-container {
        position: relative;
        max-width: 100%;
    }

    .search-input-group {
        display: flex;
        position: relative;
    }

    .search-form-control {
        width: 100%;
        height: 38px;
        padding: 8px 15px;
        border: 1px solid var(--border-color);
        border-radius: 10px 0 0 10px;
        outline: none;
        font-size: 14px;
        background-color: var(--white);
        transition: var(--transition);
    }

    .search-form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(21, 101, 192, 0.25);
    }

    .search-btn {
        border-radius: 0 10px 10px 0;
        background-color: var(--primary-color);
        color: var(--white);
        border: none;
        padding: 0 15px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition);
    }

    .search-btn:hover {
        background-color: var(--primary-dark);
    }

    #autocompleteDropdown {
        display: none;
        position: absolute;
        width: 100%;
        z-index: 1000;
        top: 100%;
        left: 0;
        margin-top: 5px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        max-height: 300px;
        overflow-y: auto;
    }

    /* Responsive adjustments for search */
    @media (max-width: 991.98px) {
        .bottombar .row {
            flex-direction: column;
        }

        .bottombar .col-md-2,
        .bottombar .col-md-7,
        .bottombar .col-md-3 {
            width: 100%;
            max-width: 100%;
            flex: 0 0 100%;
        }

        .search-container {
            margin-top: 15px;
        }
    }

    @media (max-width: 575.98px) {
        .search-btn span {
            display: none;
            /* Hide "Tìm kiếm" text on very small screens */
        }

        .search-form-control {
            font-size: 13px;
            padding: 8px 10px;
        }

        .bottombar .popular-title {
            text-align: center;
            margin-bottom: 10px !important;
        }
    }

    /* ===== SUBMENU OVERLAY STYLING ===== */
    /* Cải tiến phần dropdown menu */
    .dropdown-category {
        position: relative;
        margin: 0;
        padding: 0;
    }

    .small-icon {
        font-size: 8px;
        margin-left: 4px;
        transition: var(--transition);
    }

    .dropdown-category:hover .small-icon {
        transform: rotate(180deg);
    }

    /* Submenu overlay container */
    .submenu-overlay {
        position: absolute;
        width: 100%;
        left: 0;
        top: 100%;
        /* Thay đổi vị trí để nằm phía trên nội dung */
        z-index: 990;
        /* Giảm z-index để không che phủ nút toggle */
    }

    /* Dropdown panel styling - cải tiến */
    .submenu-panel {
        display: none;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        background-color: var(--white);
        border-bottom: 1px solid var(--border-color);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: opacity 0.2s ease, transform 0.2s ease, visibility 0.2s;
    }

    .submenu-panel.active {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    /* Dropdown content styling */
    .dropdown-content {
        padding: 25px 0;
    }

    .dropdown-header {
        margin-bottom: 20px;
    }

    .dropdown-header h6 {
        color: var(--primary-text);
        font-weight: 600;
        font-size: 18px;
        margin-bottom: 0;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--border-color);
    }

    .dropdown-body {
        padding: 0;
    }

    /* Category image and description */
    .category-image img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
        box-shadow: var(--shadow-sm);
    }

    .category-description {
        padding: 10px 0;
    }

    .category-description p {
        margin-bottom: 10px;
        font-size: 13px;
        line-height: 1.4;
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
    });
</script>
