@extends('layouts.master')

@section('title', 'Trang Tổng Quan Bác Sĩ')

@section('main-content')


    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/doctors.css') }}">


    @if (session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="wrapper">

        <!-- Overlay khi mở sidebar trên mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <button class="sidebar-toggle-middle" id="sidebarToggleMiddle">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="sidebar-header">
                <div class="logo-sidebar">
                    <span class="logo-text">Danh mục </span>
                </div>
            </div>
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
                    <li class="nav-item submenu-container">
                        <a class="nav-link" href="#financial-stats" data-toggle="submenu">
                            <i class="fas fa-chart-line"></i>
                            <p>Tài chính & Thống kê </p>
                            <i class="fas fa-chevron-right submenu-icon"></i>
                        </a>
                        <ul class="submenu nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#income" data-toggle="tab">
                                    <i class="fas fa-money-bill-wave"></i>
                                    <p>Thu nhập</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#statistics" data-toggle="tab" data-bs-toggle="tab">
                                    <i class="fas fa-chart-pie"></i>
                                    <p>Báo cáo thống kê</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <div class="sidebar-divider"></div>

                <ul class="nav bottom-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#settings" data-toggle="tab">
                            <i class="fas fa-cog"></i>
                            <p>Cài đặt</p>
                        </a>
                    </li>
                </ul>

                <div class="user-profile">
                    <div class="user-avatar">
                        <img src="{{ $doctor->photo }}" alt="Doctor" class="profile-photo">
                        <div class="status-indicator online"></div>
                    </div>
                    <div class="user-info">
                        <h5 class="profile-name-small">{{ $doctor->name }}</h5>
                        <p class="user-role">Bác sĩ</p>
                    </div>
                    <a href="{{ route('logout') }}" class="logout-button">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-panel">
            <div class="page-header d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="page-title">Tổng Quan</h1>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}" class="breadcrumb-link">Trang chủ</a>
                        </li>
                        <li class="breadcrumb-item active">Tổng Quan</li>
                    </ul>
                </div>

                <div class="notification-container">
                    @php
                        $unreadNotificationsCount = 0;
                        $user = null;

                        if (Auth::guard('doctor')->check()) {
                            $user = Auth::guard('doctor')->user();
                        } elseif (Auth::guard('web')->check()) {
                            $user = Auth::guard('web')->user();
                        }

                        if ($user) {
                            $unreadNotificationsCount = $user->unreadNotifications->count();
                        }
                    @endphp

                </div>


            </div>

            <div class="content">
                <div class="tab-content">
                    <!-- Thông tin cá nhân bác sĩ -->
                    <div class="tab-pane active" id="info-personal">
                        <div class="card" id="info-personal-card">
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
                    <!-- Lịch khám -->
                    <div class="tab-pane" id="appointments">
                        @include('doctor.profile.appointments')
                    </div>

                    <!-- Bài viết -->
                    <div class="tab-pane" id="posts">
                        @include('doctor.profile.posts', ['posts' => $posts])
                    </div>

                    <!-- Sản phẩm tiếp thị -->
                    <div class="tab-pane" id="marketing-products">
                        @include('doctor.profile.affiliate')

                    </div>


                    @include('doctor.profile.statistics')

                    <!-- Doanh thu -->
                    {{-- <div class="tab-pane" id="income">
                        <h4 class="chart-title">Biểu đồ doanh thu theo thời gian</h4>
                        <div class="btn-group mb-3">
                            <button class="btn btn-sm btn-primary">Tuần</button>
                            <button class="btn btn-sm btn-outline-primary">Tháng</button>
                            <button class="btn btn-sm btn-outline-primary">Năm</button>
                        </div>
                        <div class="chart-container">
                            <div id="revenueTimeChart"></div>
                        </div>
                    </div> --}}

                    <!-- Thống kê -->
                    {{-- <div class="tab-pane" id="statistics">
                        <div class="container-fluid p-4">
                            <h4 class="section-title mb-4">Thống kê & Báo cáo</h4>

                            <div class="row mb-4">
                                <div class="col-lg-6 col-md-12 mb-lg-0 mb-4">
                                    <div class="card h-100 shadow">
                                        <div class="card-header bg-white py-3">
                                            <h6 class="font-weight-bold text-primary m-0">Lịch hẹn theo trạng thái</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container" style="height: 300px; position: relative;">
                                                <div id="appointmentStatusChartStats" style="width: 100%; height: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="card h-100 shadow">
                                        <div class="card-header bg-white py-3">
                                            <h6 class="font-weight-bold text-primary m-0">Tương tác trên bài viết</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container" style="height: 300px; position: relative;">
                                                <div id="postInteractionChartStats" style="width: 100%; height: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card shadow">
                                        <div
                                            class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                                            <h6 class="font-weight-bold text-primary m-0">Lịch hẹn theo thời gian</h6>
                                            <div class="calendar-controls">
                                                <div class="btn-group" role="group">
                                                    <button type="button" id="btn-day"
                                                        class="btn btn-outline-primary time-view-btn active"
                                                        data-view="day">Ngày</button>
                                                    <button type="button" id="btn-week"
                                                        class="btn btn-outline-primary time-view-btn"
                                                        data-view="week">Tuần</button>
                                                    <button type="button" id="btn-month"
                                                        class="btn btn-outline-primary time-view-btn"
                                                        data-view="month">Tháng</button>
                                                    <button type="button" id="btn-year"
                                                        class="btn btn-outline-primary time-view-btn"
                                                        data-view="year">Năm</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container" style="height: 400px; position: relative;">
                                                <div id="appointmentScheduleChart" style="width: 100%; height: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow">
                                        <div class="card-header bg-white py-3">
                                            <h6 class="font-weight-bold text-primary m-0">Doanh thu theo sản phẩm</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container" style="height: 400px; position: relative;">
                                                <div id="productRevenueChartStats" style="width: 100%; height: 100%;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    {{-- <div class="tab-pane" id="statistics">
                        <div class="container-fluid p-4">
                            <h4 class="section-title mb-4">Thống kê & Báo cáo</h4>

                            <div class="row mb-4">
                                <div class="col-lg-6 col-md-12 mb-lg-0 mb-4">
                                    <div class="card h-100 shadow">
                                        <div class="card-header bg-white py-3">
                                            <h6 class="font-weight-bold text-primary m-0">Lịch hẹn theo trạng thái</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container" style="height: 300px; position: relative;">
                                                <canvas id="appointmentStatusChartStats"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-12">
                                    <div class="card h-100 shadow">
                                        <div class="card-header bg-white py-3">
                                            <h6 class="font-weight-bold text-primary m-0">Tương tác trên bài viết</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container" style="height: 300px; position: relative;">
                                                <canvas id="postInteractionChartStats"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="card shadow">
                                        <div
                                            class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                                            <h6 class="font-weight-bold text-primary m-0">Lịch hẹn theo thời gian</h6>
                                            <div class="calendar-controls">
                                                <div class="btn-group" role="group">
                                                    <button type="button" id="btn-day"
                                                        class="btn btn-outline-primary time-view-btn active"
                                                        data-view="day">Ngày</button>
                                                    <button type="button" id="btn-week"
                                                        class="btn btn-outline-primary time-view-btn"
                                                        data-view="week">Tuần</button>
                                                    <button type="button" id="btn-month"
                                                        class="btn btn-outline-primary time-view-btn"
                                                        data-view="month">Tháng</button>
                                                    <button type="button" id="btn-year"
                                                        class="btn btn-outline-primary time-view-btn"
                                                        data-view="year">Năm</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container" style="height: 400px; position: relative;">
                                                <canvas id="appointmentScheduleChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="card shadow">
                                        <div class="card-header bg-white py-3">
                                            <h6 class="font-weight-bold text-primary m-0">Doanh thu theo sản phẩm</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container" style="height: 400px; position: relative;">
                                                <canvas id="productRevenueChartStats"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    @include('doctor.add')
    @include('doctor.edit')
    @include('doctor.appointment-details')


@endsection

@section('scripts')
    <script src="{{ asset('js/doctor.js') }}"></script>
@endsection
