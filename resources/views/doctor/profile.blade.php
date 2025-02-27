@extends('layouts.master')

@section('title', 'Trang Tổng Quan Bác Sĩ')

@section('main-content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <style>
        /* Reset và biến CSS */
        :root {
            --primary-color: #2377b3;
            --primary-light: #3b82f6;
            --primary-dark: #1d4ed8;
            --secondary-color: #969ea9;
            --bg-light: #f8fafc;
            --text-dark: #1e293b;
            --text-light: #f8fafc;
            --border-radius: 12px;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --transition: all 0.3s ease;
            --sidebar-width: 280px;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f1f5f9;
            color: var(--text-dark);
            margin: 0;
            padding: 0;
        }

        /* Bố cục chung */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: var(--secondary-color);
            color: var(--text-light);
            margin-top: 5px;
            margin-bottom: 5px;
            border-radius: 0 5px 5px 0;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
            z-index: 10;
            height: 100vh;
            position: sticky;
            top: 0;
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar-header {
            padding: 25px 20px;
            /* display: flex; */
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            font-size: 24px;
            color: white;
        }

        .logo-text {
            font-size: 1.2rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            color: white;
        }

        .sidebar .sidebar-wrapper {
            padding: 25px 0;
            background-color: var(--secondary-color);

        }

        .sidebar .nav {
            padding-left: 0;
            list-style-type: none;
            margin: 0;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .sidebar .nav-item {
            margin: 5px 15px;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .sidebar .nav-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .sidebar .nav-item.active {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .sidebar .nav-link {
            color: var(--text-light);
            display: flex;
            align-items: center;
            text-decoration: none;
            padding: 12px 15px;
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            font-size: 18px;
            width: 24px;
            text-align: center;
        }

        .sidebar .nav-link p {
            margin: 0;
            font-weight: 400;
            font-size: 15px;
        }

        .sidebar .nav-item.active .nav-link {
            font-weight: 500;
        }

        /* Submenu styling */
        .submenu {
            padding-left: 40px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .submenu.active {
            max-height: 200px;
        }

        .submenu .nav-item {
            margin: 2px 0;
        }

        .submenu .nav-link {
            padding: 8px 15px;
            font-size: 14px;
        }

        .nav-link[data-toggle="submenu"] .submenu-icon {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .nav-link[data-toggle="submenu"].active .submenu-icon {
            transform: rotate(90deg);
        }

        /* Doctor profile section */
        .doctor-profile {
            padding: 25px 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255, 255, 255, 0.2);
        }

        .profile-info {
            margin-top: 15px;
        }

        .profile-name {
            font-weight: 500;
            font-size: 16px;
            margin-bottom: 5px;
            color: #ffff;
        }

        .profile-role {
            font-size: 13px;
            opacity: 0.8;
            margin: 0;
        }

        /* Main Content */
        .main-panel {
            flex: 1;
            padding: 30px;
            transition: var(--transition);
            display: flex;
            flex-direction: column;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 10px;
        }

        .breadcrumb {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 14px;
        }

        .breadcrumb-item {
            display: flex;
            align-items: center;
        }

        .breadcrumb-item:not(:last-child)::after {
            content: '\f105';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            margin: 0 10px;
            color: var(--secondary-color);
        }

        .breadcrumb-link {
            color: var(--secondary-color);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--primary-color);
            font-weight: 500;
        }

        /* Cards */
        .card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            margin-bottom: 25px;
            overflow: hidden;
            border: none;
            transition: var(--transition);
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #e9ecef;
            padding: 20px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-dark);
            margin: 0;
        }

        .card-header-actions {
            display: flex;
            gap: 10px;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-light);
            color: var(--secondary-color);
            border: none;
            cursor: pointer;
            transition: var(--transition);
        }

        .btn-icon:hover {
            background-color: var(--primary-color);
            color: white;
        }

        .card-body {
            padding: 25px;
        }

        /* Doctor Info Card */
        .doctor-info-card {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background-color: var(--bg-light);
            border-radius: var(--border-radius);
            transition: var(--transition);
        }

        .info-item:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .info-icon {
            width: 45px;
            height: 45px;
            background-color: var(--primary-light);
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 13px;
            color: var(--secondary-color);
            margin-bottom: 5px;
        }

        .info-value {
            font-weight: 500;
            font-size: 16px;
            color: var(--text-dark);
            margin: 0;
        }

        .profile-photo-container {
            grid-column: span 2;
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 5px solid var(--bg-light);
            box-shadow: var(--card-shadow);
        }

        .profile-details {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .profile-name-large {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .profile-specialty {
            font-size: 16px;
            color: var(--secondary-color);
            margin: 0;
        }

        .rating-stars {
            color: #fbbf24;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .rating-value {
            margin-left: 5px;
            font-weight: 500;
        }

        /* Posts Tab */
        .post-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }

        .post-card {
            background: white;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            transition: var(--transition);
        }

        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .post-image {
            height: 180px;
            width: 100%;
            object-fit: cover;
        }

        .post-content {
            padding: 20px;
        }

        .post-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-dark);
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 50px;
        }

        .post-excerpt {
            font-size: 14px;
            color: var(--secondary-color);
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 60px;
        }

        .post-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: var(--secondary-color);
        }

        .post-date {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .post-views {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            padding: 12px 25px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .create-post-container {
            margin-top: 30px;
            text-align: center;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 50%;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: var(--border-radius);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        a {
            text-decoration: none;
            color: black;
        }

        /* Table Styling */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }


        .product-table th,
        .product-table td {
            border: 1px solid #ddd;
            padding: 12px;
        }

        .product-table th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .product-table td {
            vertical-align: middle;
            text-align: center;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }

        .old-price {
            text-decoration: line-through;
            color: #888;
            margin-right: 5px;
        }

        .discounted-price {
            font-weight: bold;
            color: #ff5722;
        }

        .delete-btn {
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 6px 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 70px;
            }

            .sidebar .nav-link p,
            .sidebar .logo-text,
            .sidebar .doctor-profile {
                display: none;
            }

            .sidebar .nav-link {
                justify-content: center;
            }

            .sidebar .nav-link i {
                margin-right: 0;
            }

            .profile-photo-container {
                grid-column: span 1;
            }
        }

        @media (max-width: 768px) {
            .main-panel {
                padding: 20px;
            }

            .doctor-info-card {
                grid-template-columns: 1fr;
            }

            .profile-photo-container {
                flex-direction: column;
                align-items: flex-start;
            }


            /* Table static */
            .card {
                border-radius: 12px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transition: all 0.3s ease-in-out;
                background: white;
            }

            .card:hover {
                transform: translateY(-3px);
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            }

            .card-header {
                background: linear-gradient(135deg, #5e72e4, #825ee4);
                color: white;
                border-radius: 12px 12px 0 0;
                padding: 15px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .card-header h2 {
                margin: 0;
                font-size: 1.4rem;
            }

            .card-header-actions {
                display: flex;
                gap: 10px;
            }

            .btn-icon {
                width: 36px;
                height: 36px;
                border-radius: 50%;
                background: white;
                color: #5e72e4;
                border: none;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.3s ease-in-out;
            }

            .btn-icon:hover {
                background: #5e72e4;
                color: white;
            }

            /* ===== Thẻ dữ liệu tài chính ===== */
            .stat-card {
                background: white;
                padding: 20px;
                border-radius: 12px;
                text-align: center;
                transition: all 0.3s ease-in-out;
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            }

            .stat-card:hover {
                transform: translateY(-3px);
            }

            .stat-value {
                font-size: 22px;
                font-weight: bold;
                color: #2dce89;
            }

            .stat-label {
                font-size: 14px;
                color: #8898aa;
            }

            /* ===== Cải tiến biểu đồ ===== */
            .chart-container {
                background: white;
                padding: 20px;
                border-radius: 12px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            }

            .chart-title {
                font-size: 16px;
                font-weight: 600;
                color: #32325d;
                margin-bottom: 15px;
            }

            .btn-group .btn {
                border-radius: 20px;
                padding: 8px 20px;
                transition: all 0.3s ease-in-out;
            }

            .btn-group .btn:hover {
                background: #5e72e4;
                color: white;
            }

            /* ===== Cải thiện bảng doanh thu ===== */
            .table {
                border-collapse: separate;
                border-spacing: 0 10px;
            }

            .table thead th {
                background: #5e72e4;
                color: white;
                padding: 12px;
                border-radius: 10px 10px 0 0;
            }

            .table tbody tr {
                background: white;
                border-radius: 10px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .table tbody tr td {
                padding: 12px;
                border-bottom: 1px solid #e9ecef;
            }

            .table tbody tr:last-child td {
                border-bottom: none;
            }

            .table-active {
                font-weight: bold;
                background: #f7fafc !important;
            }
        }
    </style>

    @if (session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#info-personal" data-toggle="tab">
                            <i class="fas fa-user-md"></i>
                            <p>Thông tin cá nhân</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#appointments" data-toggle="tab">
                            <i class="fas fa-calendar-check"></i>
                            <p>Lịch hẹn</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#posts" data-toggle="tab">
                            <i class="fas fa-newspaper"></i>
                            <p>Bài viết</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#marketing-products" data-toggle="tab">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Sản phẩm tiếp thị</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#financial-stats" data-toggle="submenu">
                            <i class="fas fa-chart-line"></i>
                            <p>Tài chính & Thống kê</p>
                            <i class="fas fa-chevron-right submenu-icon ml-auto"></i>
                        </a>
                        <ul class="submenu nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#income" data-toggle="tab">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <p>Thu nhập</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#statistics" data-toggle="tab">
                                    <i class="fas fa-chart-pie"></i>
                                    <p>Báo cáo thống kê</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-panel">
            <div class="page-header">
                <h1 class="page-title">Tổng Quan</h1>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="#" class="breadcrumb-link">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item active">Tổng Quan</li>
                </ul>
            </div>

            <div class="content">
                <div class="tab-content">
                    <!-- Thông tin cá nhân bác sĩ -->
                    <div class="tab-pane active" id="info-personal">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Thông tin cá nhân</h2>
                                <div class="card-header-actions">
                                    <button class="btn-icon" id="edit-info-btn" title="Chỉnh sửa thông tin">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn-icon" title="Làm mới">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="doctor-info-card">
                                    <div class="profile-photo-container">
                                        <img src="{{ $doctor->photo }}" alt="Doctor" class="profile-photo">
                                        <div class="profile-details">
                                            <h3 class="profile-name-large">{{ $doctor->name }}</h3>
                                            <p class="profile-specialty">{{ $doctor->specialization }}</p>
                                            <div class="rating-stars">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    @if ($i <= $doctor->rating)
                                                        <i class="fas fa-star"></i>
                                                    @elseif ($i - 0.5 <= $doctor->rating)
                                                        <i class="fas fa-star-half-alt"></i>
                                                    @else
                                                        <i class="far fa-star"></i>
                                                    @endif
                                                @endfor
                                                <span class="rating-value">{{ $doctor->rating }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div class="info-content">
                                            <div class="info-label">Số điện thoại</div>
                                            <p class="info-value">{{ $doctor->phone }}</p>
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="info-content">
                                            <div class="info-label">Email</div>
                                            <p class="info-value">{{ $doctor->email }}</p>
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="info-content">
                                            <div class="info-label">Địa chỉ làm việc</div>
                                            <p class="info-value">{{ $doctor->workplace }}</p>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="fa-solid fa-user-doctor"></i>
                                        </div>
                                        <div class="info-content">
                                            <div class="info-label">Chuyên ngành</div>
                                            <p class="info-value">{{ $doctor->specialization }}</p>
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <div class="info-content">
                                            <div class="info-label">Người theo dõi</div>
                                            <p class="info-value">{{ number_format($doctor->followers_count) }}</p>
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-icon">
                                            <i class="fas fa-award"></i>
                                        </div>
                                        <div class="info-content">
                                            <div class="info-label">Điểm tiếp thị</div>
                                            <p class="info-value">{{ number_format($doctor->points) }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="appointments">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h2 class="card-title m-0">Lịch hẹn của bạn</h2>
                                <div>
                                    <button class="btn btn-light btn-sm me-2">Lọc</button>
                                    <button class="btn btn-light btn-sm">Xuất</button>
                                </div>
                            </div>

                            <div class="card-body">
                                @if ($appointments->count() > 0)
                                    <div class="table-responsive">
                                        <table class="table-hover table">
                                            <thead>
                                                <tr>
                                                    <th>Bệnh nhân</th>
                                                    <th>Thời gian</th>
                                                    <th>Hình thức khám</th>
                                                    <th>Trạng thái</th>
                                                    <th>Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($appointments as $appointment)
                                                    <tr>
                                                        <td>
                                                            <div>{{ $appointment->user->name }}</div>
                                                            <span
                                                                class="text-muted d-block">{{ $appointment->user->email }}</span>
                                                            <span
                                                                class="text-muted d-block">{{ $appointment->user->phone }}</span>
                                                        </td>
                                                        <td>
                                                            <div>
                                                                {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}
                                                            </div>
                                                            <small
                                                                class="text-muted">{{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}</small>
                                                        </td>

                                                        <td>
                                                            @switch($appointment->consultation_type)
                                                                @case('Online')
                                                                    <span class="badge text-bg-info">Trực tuyến</span>
                                                                @break

                                                                @case('Offline')
                                                                    <span class="badge text-bg-primary">Tại phòng khám</span>
                                                                @break

                                                                @case('At Home')
                                                                    <span class="badge text-bg-success">Tại nhà</span>
                                                                @break
                                                            @endswitch
                                                        </td>

                                                        <td>
                                                            @switch($appointment->status)
                                                                @case('Chờ duyệt')
                                                                    <span
                                                                        class="badge text-bg-warning">{{ $appointment->status }}</span>
                                                                @break

                                                                @case('Sắp tới')
                                                                    <span
                                                                        class="badge text-bg-info">{{ $appointment->status }}</span>
                                                                @break

                                                                @case('Hoàn thành')
                                                                    <span
                                                                        class="badge text-bg-success">{{ $appointment->status }}</span>
                                                                @break

                                                                @case('Đã Huỷ')
                                                                    <span
                                                                        class="badge text-bg-danger">{{ $appointment->status }}</span>
                                                                @break
                                                            @endswitch
                                                        </td>

                                                        <td>
                                                            @if ($appointment->approval_status === 'Chờ duyệt')
                                                                {{-- <form method="POST"
                                                                    action="{{ route('doctor.appointments.approve', ['id' => $appointment->id]) }}"
                                                                    class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-success me-1"
                                                                        title="Xác nhận">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </form> --}}
                                                                <form method="POST"
                                                                    action="{{ route('doctor.appointments.approve', ['id' => $appointment->id]) }}"
                                                                    class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-success me-1"
                                                                        title="Xác nhận">
                                                                        <i class="fas fa-check"></i>
                                                                    </button>
                                                                </form>

                                                                <form method="POST"
                                                                    action="{{ route('doctor.appointments.reject', ['id' => $appointment->id]) }}"
                                                                    class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit"
                                                                        class="btn btn-danger btn-sm">Từ chối</button>
                                                                </form>
                                                            @endif

                                                            @if ($appointment->status === 'Sắp tới' && $appointment->approval_status === 'Chấp nhận')
                                                                <form method="POST"
                                                                    action="{{ route('doctor.appointments.complete', ['id' => $appointment->id]) }}"
                                                                    class="d-inline">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <button type="submit"
                                                                        class="btn btn-primary btn-sm">Hoàn thành</button>
                                                                </form>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="py-5 text-center">
                                        <p class="text-muted mb-0">Chưa có lịch hẹn nào được đặt</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>




                    <!-- Bài viết -->
                    <div class="tab-pane" id="posts">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Bài viết của bạn</h2>
                                <div class="card-header-actions">
                                    <button class="btn-icon" title="Lọc bài viết">
                                        <i class="fas fa-filter"></i>
                                    </button>
                                    <button class="btn-icon" title="Sắp xếp">
                                        <i class="fas fa-sort"></i>
                                    </button>
                                    <button class="btn btn-primary" id="add-post-btn" style="margin-left: auto;">
                                        <i class="fas fa-plus"></i>
                                        Thêm bài viết
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($posts->isEmpty())
                                    <div class="py-5 text-center">
                                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                        <h3 class="text-muted">Chưa có bài viết nào</h3>
                                        <p class="text-secondary mb-4">Hãy bắt đầu chia sẻ kiến thức của bạn với cộng đồng
                                        </p>
                                    </div>
                                @else
                                    <div class="post-list">
                                        @foreach ($posts as $post)
                                            <div class="post-card">

                                                <a href="{{ route('post.detail', ['slug' => $post->slug]) }}">
                                                    <img src="{{ asset($post->photo) }}" alt="Thumbnail"
                                                        class="post-image">
                                                </a>
                                                <div class="post-content">
                                                    <h3 class="post-title">
                                                        <a href="{{ route('post.detail', ['slug' => $post->slug]) }}"
                                                            class="post-link">
                                                            {{ $post->title }}
                                                        </a>
                                                    </h3>
                                                    <p class="post-excerpt">Lorem ipsum dolor sit amet, consectetur
                                                        adipiscing elit. Sed do eiusmod tempor incididunt ut labore et
                                                        dolore magna aliqua.</p>
                                                    <div class="post-meta">
                                                        <div class="post-date">
                                                            <i class="far fa-calendar-alt"></i>
                                                            <span>{{ $post->created_at->format('d/m/Y') }}</span>
                                                        </div>


                                                        <div class="post-views">
                                                            <i class="far fa-eye"></i>
                                                            <span>254</span>
                                                        </div>
                                                        <div class="post-actions">
                                                            <button class="btn btn-sm btn-primary edit-post-btn"
                                                                data-id="{{ $post->id }}"
                                                                data-title="{{ $post->title }}"
                                                                data-summary="{{ $post->summary }}"
                                                                data-description="{{ $post->description }}"
                                                                data-category="{{ $post->post_cat_id }}"
                                                                data-photo="{{ asset($post->photo) }}">
                                                                <i class="fas fa-edit"></i> Chỉnh sửa
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- <div class="create-post-container">
                                    <a href="" class="btn btn-primary">
                                        <i class="fas fa-plus"></i>
                                        Tạo bài viết mới
                                    </a>
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <!-- Sản phẩm tiếp thị -->
                    <div class="tab-pane" id="marketing-products">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Sản phẩm tiếp thị</h2>
                                <div class="card-header-actions">
                                    <button class="btn btn-primary" id="add-product-btn" style="margin-left: auto;">
                                        <i class="fas fa-plus"></i>
                                        Thêm sản phẩm mới
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                @if ($products->isEmpty())
                                    <div class="py-5 text-center">
                                        <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                                        <h3 class="text-muted">Chưa có sản phẩm tiếp thị</h3>
                                        <p class="text-secondary mb-4">Thêm sản phẩm để bắt đầu kiếm thêm thu nhập</p>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="product-table">
                                            <thead>
                                                <tr>
                                                    <th>Ảnh Sản Phẩm</th>
                                                    <th>Tên Sản Phẩm</th>
                                                    <th>Giá</th>
                                                    <th>Hành Động</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($products as $product)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ asset($product->photo) }}"
                                                                alt="{{ $product->title }}" class="product-image">
                                                        </td>
                                                        <td>{{ $product->title }}</td>
                                                        <td>
                                                            @if ($product->discount > 0)
                                                                <span
                                                                    class="old-price">{{ number_format($product->price) }}
                                                                    đ</span>
                                                                <span class="discounted-price">
                                                                    {{ number_format($product->price - ($product->price * $product->discount) / 100) }}
                                                                    đ
                                                                </span>
                                                            @else
                                                                {{ number_format($product->price) }} đ
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <!-- Nút xóa sản phẩm -->
                                                            <form action="" method="POST" class="delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="btn btn-danger btn-sm delete-btn">
                                                                    <i class="fas fa-trash"></i> Xóa
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                @endif
                            </div>
                        </div>
                    </div>


                    <!-- Thu nhập -->
                    <div class="tab-pane" id="income">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Tài chính & Doanh thu</h2>
                                <div class="card-header-actions">
                                    <button class="btn-icon" title="Xuất báo cáo">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button class="btn-icon" title="Làm mới dữ liệu">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="stat-card bg-primary-gradient">
                                                <i class="fas fa-stethoscope"></i>
                                                <div class="stat-value">76,500,000 ₫</div>
                                                <div class="stat-label">
                                                    Tổng doanh thu từ lịch hẹn khám
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="stat-card bg-success-gradient">
                                                <i class="fas fa-shopping-cart"></i>
                                                <div class="stat-value">28,450,000 ₫</div>
                                                <div class="stat-label">
                                                    Tổng doanh thu từ tiếp thị sản phẩm
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="chart-container mb-4">
                                    <h4 class="chart-title">Biểu đồ doanh thu theo thời gian</h4>
                                    <div class="btn-group mb-3">
                                        <button class="btn btn-sm btn-primary">Tuần</button>
                                        <button class="btn btn-sm btn-outline-primary">
                                            Tháng
                                        </button>
                                        <button class="btn btn-sm btn-outline-primary">Năm</button>
                                    </div>
                                    <canvas id="revenueTimeChart"></canvas>
                                </div>

                                <div class="table-responsive">
                                    <h4 class="mb-3">Bảng chi tiết doanh thu theo nguồn</h4>
                                    <table class="revenue-table table">
                                        <thead>
                                            <tr>
                                                <th>Nguồn doanh thu</th>
                                                <th>Tháng 1/2025</th>
                                                <th>Tháng 2/2025</th>
                                                <th>% Thay đổi</th>
                                                <th>Tổng cộng</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Khám tổng quát</td>
                                                <td>12,500,000 ₫</td>
                                                <td>15,250,000 ₫</td>
                                                <td class="text-success">+22%</td>
                                                <td>27,750,000 ₫</td>
                                            </tr>
                                            <tr>
                                                <td>Khám chuyên khoa</td>
                                                <td>18,750,000 ₫</td>
                                                <td>21,250,000 ₫</td>
                                                <td class="text-success">+13.3%</td>
                                                <td>40,000,000 ₫</td>
                                            </tr>
                                            <tr>
                                                <td>Tư vấn dinh dưỡng</td>
                                                <td>4,250,000 ₫</td>
                                                <td>4,500,000 ₫</td>
                                                <td class="text-success">+5.9%</td>
                                                <td>8,750,000 ₫</td>
                                            </tr>
                                            <tr>
                                                <td>Vitamin tổng hợp ABC</td>
                                                <td>3,450,000 ₫</td>
                                                <td>4,400,000 ₫</td>
                                                <td class="text-success">+27.5%</td>
                                                <td>7,850,000 ₫</td>
                                            </tr>
                                            <tr>
                                                <td>Máy đo huyết áp XYZ</td>
                                                <td>2,850,000 ₫</td>
                                                <td>3,570,000 ₫</td>
                                                <td class="text-success">+25.3%</td>
                                                <td>6,420,000 ₫</td>
                                            </tr>
                                            <tr>
                                                <td>Thực phẩm chức năng DEF</td>
                                                <td>2,180,000 ₫</td>
                                                <td>3,500,000 ₫</td>
                                                <td class="text-success">+60.6%</td>
                                                <td>5,680,000 ₫</td>
                                            </tr>
                                            <tr>
                                                <td>Bộ kit xét nghiệm tại nhà</td>
                                                <td>1,850,000 ₫</td>
                                                <td>2,400,000 ₫</td>
                                                <td class="text-success">+29.7%</td>
                                                <td>4,250,000 ₫</td>
                                            </tr>
                                            <tr>
                                                <td>Sản phẩm khác</td>
                                                <td>1,800,000 ₫</td>
                                                <td>2,450,000 ₫</td>
                                                <td class="text-success">+36.1%</td>
                                                <td>4,250,000 ₫</td>
                                            </tr>
                                            <tr class="table-active font-weight-bold">
                                                <td>Tổng cộng</td>
                                                <td>47,630,000 ₫</td>
                                                <td>57,320,000 ₫</td>
                                                <td class="text-success">+20.3%</td>
                                                <td>104,950,000 ₫</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane" id="statistics">
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Thống kê & Báo cáo</h2>
                                <div class="card-header-actions">
                                    <button class="btn-icon" title="Tùy chỉnh báo cáo">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <button class="btn-icon" title="Xuất báo cáo">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Phần Lịch hẹn -->
                                <div class="mb-5">
                                    <h4 class="section-title mb-4">
                                        <i class="fas fa-calendar-check mr-2"></i>Lịch hẹn
                                    </h4>
                                    <div class="row mb-4">
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="stat-card">
                                                    <div class="stat-value">156</div>
                                                    <div class="stat-label">
                                                        Tổng số lịch hẹn đã đặt
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="stat-card">
                                                    <div class="stat-value">127</div>
                                                    <div class="stat-label">
                                                        Số lịch hẹn đã hoàn thành
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="stat-card">
                                                    <div class="stat-value">14</div>
                                                    <div class="stat-label">
                                                        Số lịch hẹn đã bị hủy
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="stat-card">
                                                    <div class="stat-value">15</div>
                                                    <div class="stat-label">Lịch hẹn đang chờ</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chart-container mb-4">
                                        <h5 class="chart-title">
                                            Biểu đồ thể hiện số lượng lịch hẹn theo trạng thái
                                        </h5>
                                        <canvas id="appointmentStatusChartStats"></canvas>
                                    </div>
                                </div>

                                <!-- Phần Bài viết -->
                                <div class="mb-5">
                                    <h4 class="section-title mb-4">
                                        <i class="fas fa-newspaper mr-2"></i>Bài viết
                                    </h4>
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="stat-card">
                                                    <div class="stat-value">47</div>
                                                    <div class="stat-label">
                                                        Tổng số bài viết đã đăng
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="stat-card">
                                                    <div class="stat-value">1,247</div>
                                                    <div class="stat-label">
                                                        Lượt xem trung bình mỗi bài
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="stat-card">
                                                    <div class="stat-value">358</div>
                                                    <div class="stat-label">
                                                        Tổng lượt tương tác
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chart-container mb-4">
                                        <h5 class="chart-title">
                                            Biểu đồ thể hiện lượng tương tác trên bài viết
                                        </h5>
                                        <canvas id="postInteractionChartStats"></canvas>
                                    </div>
                                </div>

                                <!-- Phần Sản phẩm tiếp thị -->
                                <div class="mb-5">
                                    <h4 class="section-title mb-4">
                                        <i class="fas fa-shopping-cart mr-2"></i>Sản phẩm tiếp thị
                                    </h4>
                                    <div class="row mb-4">
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="stat-card">
                                                    <div class="stat-value">24</div>
                                                    <div class="stat-label">
                                                        Tổng số sản phẩm đã tiếp thị
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="stat-card">
                                                    <div class="stat-value">3,782</div>
                                                    <div class="stat-label">
                                                        Số lượt click vào liên kết
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="stat-card">
                                                    <div class="stat-value">28,450,000 ₫</div>
                                                    <div class="stat-label">
                                                        Doanh thu từ sản phẩm
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="chart-container mb-4">
                                        <h5 class="chart-title">
                                            Biểu đồ thể hiện doanh thu theo từng sản phẩm
                                        </h5>
                                        <canvas id="productRevenueChartStats"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <span class="close" id="close-modal">&times;</span>
            <h2>Chỉnh sửa thông tin cá nhân</h2>
            <form id="edit-form" method="POST" action="{{ route('doctor.update', $doctor->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="name">Tên bác sĩ</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ $doctor->name }}">
                </div>
                <div class="form-group">
                    <label for="phone">Số điện thoại</label>
                    <input type="text" id="phone" name="phone" class="form-control"
                        value="{{ $doctor->phone }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ $doctor->email }}">
                </div>
                <div class="form-group">
                    <label for="workplace">Địa chỉ làm việc</label>
                    <input type="text" id="workplace" name="workplace" class="form-control"
                        value="{{ $doctor->workplace }}">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                    <button type="button" class="btn btn-secondary" id="cancel-modal">Hủy</button>
                </div>
            </form>
        </div>
    </div>
    <div id="add-post-modal" class="modal">
        <div class="modal-content">
            <span class="close" id="close-add-post-modal">&times;</span>
            <h2>Thêm bài viết mới</h2>
            <form id="add-post-form" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Tiêu đề</label>
                    <input type="text" id="title" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="summary">Tóm tắt</label>
                    <textarea id="summary" name="summary" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="description">Nội dung</label>
                    <textarea id="description" name="description" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="post_cat_id">Danh mục bài viết</label>
                    <select id="post_cat_id" name="post_cat_id" class="form-control" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="photo">Ảnh bài viết</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Đăng bài</button>
                    <button type="button" class="btn btn-secondary" id="cancel-add-post">Hủy</button>
                </div>
            </form>

        </div>
    </div>

    <div id="edit-post-modal" class="modal">
        <div class="modal-content">
            <span class="close" id="close-edit-post-modal">&times;</span>
            <h2>Chỉnh sửa bài viết</h2>
            <form id="edit-post-form" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit-post-id" name="post_id">

                <div class="form-group">
                    <label for="edit-title">Tiêu đề</label>
                    <input type="text" id="edit-title" name="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="edit-summary">Tóm tắt</label>
                    <textarea id="edit-summary" name="summary" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-description">Nội dung</label>
                    <textarea id="edit-description" name="description" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-post-cat-id">Danh mục bài viết</label>
                    <select id="edit-post-cat-id" name="post_cat_id" class="form-control" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Xem trước ảnh hiện tại -->
                <div class="form-group">
                    <label>Ảnh hiện tại</label>
                    <br>
                    <img id="edit-preview-image" src="" alt="Ảnh bài viết"
                        style="max-width: 200px; display: block;">
                </div>

                <!-- Input chọn ảnh mới -->
                <div class="form-group">
                    <label for="edit-photo">Chọn ảnh mới (nếu có)</label>
                    <input type="file" id="edit-photo" name="photo" class="form-control" accept="image/*">
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
                    <button type="button" class="btn btn-secondary" id="cancel-edit-post">Hủy</button>
                </div>
            </form>
        </div>
    </div>


    {{-- @if (session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.nav-item');
            const tabPanes = document.querySelectorAll('.tab-pane');
            const submenuToggles = document.querySelectorAll('.nav-link[data-toggle="submenu"]');

            navItems.forEach(item => {
                const link = item.querySelector('.nav-link');
                if (link.getAttribute('data-toggle') === 'tab') {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const target = this.getAttribute('href').substring(1);

                        // Remove active class from all nav items and tab panes
                        navItems.forEach(nav => {
                            if (nav.querySelector('.nav-link').getAttribute(
                                    'data-toggle') === 'tab') {
                                nav.classList.remove('active');
                            }
                        });
                        tabPanes.forEach(tab => tab.classList.remove("active"));

                        // Add active class to the clicked nav item and corresponding tab pane
                        item.classList.add('active');
                        document.getElementById(target)
                            .classList.add('active');
                    });
                }
            });

            submenuToggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    const submenu = this.nextElementSibling;

                    if (submenu.classList.contains('active')) {
                        submenu.classList.remove('active');
                        this.classList.remove('active');
                    } else {
                        submenu.classList.add('active');
                        this.classList.add('active');
                    }
                });
            });
            const editModal = document.getElementById('edit-modal');
            const editBtn = document.getElementById('edit-info-btn');
            const closeModal = document.getElementById('close-modal');
            const cancelModal = document.getElementById('cancel-modal');

            if (editBtn) {
                editBtn.addEventListener('click', function() {
                    editModal.style.display = 'block';
                });
            }

            if (closeModal) {
                closeModal.addEventListener('click', function() {
                    editModal.style.display = 'none';
                });
            }

            if (cancelModal) {
                cancelModal.addEventListener('click', function() {
                    editModal.style.display = 'none';
                });
            }

            const addPostModal = document.getElementById('add-post-modal');
            const addPostBtn = document.getElementById('add-post-btn');
            const closeAddPostModal = document.getElementById('close-add-post-modal');
            const cancelAddPost = document.getElementById('cancel-add-post');

            addPostBtn.addEventListener('click', function() {
                addPostModal.style.display = 'block';
            });

            closeAddPostModal.addEventListener('click', function() {
                addPostModal.style.display = 'none';
            });

            cancelAddPost.addEventListener('click', function() {
                addPostModal.style.display = 'none';
            });


            setTimeout(function() {
                let alertBox = document.getElementById('success-alert');
                if (alertBox) {
                    alertBox.style.transition = "opacity 0.5s";
                    alertBox.style.opacity = "0";
                    setTimeout(() => alertBox.remove(), 500);
                }
            }, 3000);




            const editPostBtns = document.querySelectorAll('.edit-post-btn');
            const editPostModal = document.getElementById('edit-post-modal');
            const closeEditPostModal = document.getElementById('close-edit-post-modal');
            const cancelEditPost = document.getElementById('cancel-edit-post');
            const editPostForm = document.getElementById('edit-post-form');

            editPostBtns.forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-id');
                    const title = this.getAttribute('data-title');
                    const summary = this.getAttribute('data-summary');
                    const description = this.getAttribute('data-description');
                    const category = this.getAttribute('data-category');

                    document.getElementById('edit-post-id').value = postId;
                    document.getElementById('edit-title').value = title;
                    document.getElementById('edit-summary').value = summary;
                    document.getElementById('edit-description').value = description;
                    document.getElementById('edit-post-cat-id').value = category;

                    editPostForm.action = `/posts/${postId}`;
                    let previewImage = document.getElementById('edit-preview-image');
                    previewImage.src = this.getAttribute('data-photo');
                    previewImage.style.display = 'block';
                    editPostModal.style.display = 'block';
                });
            });

            closeEditPostModal.addEventListener('click', () => editPostModal.style.display = 'none');
            cancelEditPost.addEventListener('click', () => editPostModal.style.display = 'none');
        });
    </script>
    <script>
        // Mã JavaScript cho việc tạo biểu đồ sẽ được thêm vào cuối trang
        document.addEventListener("DOMContentLoaded", function() {
            // Biểu đồ cho lịch hẹn
            var appointmentCtx = document
                .getElementById("appointmentStatusChartStats")
                .getContext("2d");
            var appointmentChart = new Chart(appointmentCtx, {
                type: "pie",
                data: {
                    labels: ["Hoàn thành", "Đang chờ", "Đã hủy"],
                    datasets: [{
                        data: [127, 15, 14],
                        backgroundColor: [
                            "#2dce89",
                            "#11cdef",
                            "#f5365c",
                        ],
                    }, ],
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: "right",
                        },
                    },
                },
            });

            // Biểu đồ cho bài viết
            var postCtx = document
                .getElementById("postInteractionChartStats")
                .getContext("2d");
            var postChart = new Chart(postCtx, {
                type: "bar",
                data: {
                    labels: [
                        "10 cách tăng cường miễn dịch",
                        "Chế độ dinh dưỡng",
                        "Dấu hiệu đột quỵ",
                        "Bí quyết ngủ ngon",
                        "Tập luyện tại nhà",
                    ],
                    datasets: [{
                            label: "Lượt thích",
                            data: [187, 156, 143, 132, 98],
                            backgroundColor: "#5e72e4",
                        },
                        {
                            label: "Bình luận",
                            data: [42, 38, 35, 28, 22],
                            backgroundColor: "#11cdef",
                        },
                    ],
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            stacked: false,
                        },
                        y: {
                            stacked: false,
                        },
                    },
                },
            });

            // Biểu đồ cho sản phẩm
            var productCtx = document
                .getElementById("productRevenueChartStats")
                .getContext("2d");
            var productChart = new Chart(productCtx, {
                type: "horizontalBar",
                data: {
                    labels: [
                        "Vitamin tổng hợp ABC",
                        "Máy đo huyết áp XYZ",
                        "Thực phẩm chức năng DEF",
                        "Bộ kit xét nghiệm",
                        "Sản phẩm khác",
                    ],
                    datasets: [{
                        label: "Doanh thu (triệu đồng)",
                        data: [7.85, 6.42, 5.68, 4.25, 4.25],
                        backgroundColor: [
                            "#2dce89",
                            "#5e72e4",
                            "#11cdef",
                            "#fb6340",
                            "#f5365c",
                        ],
                    }, ],
                },
                options: {
                    indexAxis: "y",
                    responsive: true,
                },
            });

            // Biểu đồ doanh thu theo thời gian
            var revenueCtx = document
                .getElementById("revenueTimeChart")
                .getContext("2d");
            var revenueChart = new Chart(revenueCtx, {
                type: "line",
                data: {
                    labels: ["T2", "T3", "T4", "T5", "T6", "T7", "CN"],
                    datasets: [{
                            label: "Doanh thu từ lịch hẹn",
                            data: [4.5, 5.2, 6.8, 7.5, 7.2, 6.5, 3.8],
                            borderColor: "#5e72e4",
                            backgroundColor: "rgba(94, 114, 228, 0.1)",
                            fill: true,
                        },
                        {
                            label: "Doanh thu từ sản phẩm",
                            data: [1.2, 1.5, 1.8, 2.1, 1.9, 1.7, 1.1],
                            borderColor: "#2dce89",
                            backgroundColor: "rgba(45, 206, 137, 0.1)",
                            fill: true,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: "Doanh thu (triệu đồng)",
                            },
                        },
                    },
                },
            });
        });
    </script>

@endsection
