@extends('layouts.master')

@section('title', 'Trang Tổng Quan Bác Sĩ')

@section('main-content')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/doctors.css') }}">

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
                                                    <p class="card-text">
                                                        {{ Str::limit(strip_tags($post->summary), 120) }}
                                                    </p>
                                                    <div class="post-meta">
                                                        <div class="post-date">
                                                            <i class="far fa-calendar-alt"></i>
                                                            <span>{{ $post->created_at->format('d/m/Y') }}</span>
                                                        </div>


                                                        <div class="post-views">
                                                            <i class="far fa-eye"></i>
                                                            <span>254</span>
                                                        </div>
                                                        <div class="post-action-buttons">
                                                            <button class="btn btn-sm btn-outline-primary edit-post-btn"
                                                                data-id="{{ $post->id }}"
                                                                data-title="{{ $post->title }}"
                                                                data-summary="{{ $post->summary }}"
                                                                data-description="{{ $post->description }}"
                                                                data-category="{{ $post->post_cat_id }}"
                                                                data-photo="{{ asset($post->photo) }}">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-outline-danger delete-post-btn"
                                                                data-id="{{ $post->id }}">
                                                                <i class="fas fa-trash"></i>
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

                        <!-- Danh sách sản phẩm -->
                        <div class="card mb-4 shadow">
                            <div class="card-header py-3">
                                <h2 class="card-title">Danh sách sản phẩm </h2>
                            </div>

                            <div class="table-responsive">
                                <table class="table-bordered table-hover table" id="product-dataTable" width="100%">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tiêu đề</th>
                                            <th>Loại</th>
                                            <th>Giá</th>
                                            <th>Giảm giá</th>
                                            <th>Loại</th>
                                            <th>Thương hiệu</th>
                                            <th>Ảnh</th>
                                            <th>Chức năng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($productss as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->title }}</td>
                                                <td>{{ optional($product->cat_info)->title }}
                                                    <sub>{{ optional($product->sub_cat_info)->title ?? '' }}</sub>
                                                </td>
                                                <td>{{ number_format($product->price, 0, ',', '.') }}đ</td>
                                                <td>{{ $product->discount }}%</td>
                                                <td>{{ $product->size }}</td>
                                                <td>{{ ucfirst(optional($product->brand)->title) }}</td>
                                                <td>
                                                    @if ($product->photo)
                                                        @php
                                                            $photo = explode(',', $product->photo);
                                                        @endphp
                                                        <img src="{{ $photo[0] }}" class="img-fluid zoom"
                                                            style="max-width:80px" alt="{{ $product->photo }}">
                                                    @else
                                                        <img src="{{ asset('backend/img/thumbnail-default.jpg') }}"
                                                            class="img-fluid" style="max-width:80px" alt="avatar.png">
                                                    @endif
                                                </td>
                                                <td>

                                                    @if ($products->contains('id', $product->id))
                                                        <!-- Nút tạo tiếp thị đã có -->
                                                        <button class="btn btn-secondary btn-sm"
                                                            id="copy-link-btn-{{ $product->id }}"
                                                            data-id="{{ $product->id }}"
                                                            data-slug="{{ $product->slug }}"
                                                            data-link="{{ $product->existingLink->product_link }}">
                                                            <i class="fa-solid fa-link"></i> Đã liên kết
                                                        </button>
                                                    @else
                                                        <!-- Nút tạo tiếp thị chưa có -->
                                                        <button class="btn btn-success btn-sm create-affiliate-btn"
                                                            id="generate-affiliate-link"
                                                            data-id="{{ $product->id }}"
                                                            data-slug="{{ $product->slug }}"
                                                            title="Tạo tiếp thị">
                                                            <i class="fa-solid fa-link"></i> Tạo tiếp thị
                                                        </button>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Sản phẩm bác sĩ đã tiếp thị -->
                        <div class="card">
                            <div class="card-header">
                                <h2 class="card-title">Sản phẩm đã có trong danh sách tiếp thị </h2>
                                <div class="card-header-actions">
                                    <button class="btn btn-primary" id="open-add-product-modal"
                                        style="margin-left: auto;">
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

                    <!-- Doanh thu -->
                    <div class="tab-pane" id="income">
                        <h4 class="chart-title">Biểu đồ doanh thu theo thời gian</h4>
                        <div class="btn-group mb-3">
                            <button class="btn btn-sm btn-primary">Tuần</button>
                            <button class="btn btn-sm btn-outline-primary">Tháng</button>
                            <button class="btn btn-sm btn-outline-primary">Năm</button>
                        </div>
                        <div class="chart-container">
                            <div id="revenueTimeChart"></div>
                        </div>
                    </div>

                    <!-- Thống kê -->
                    <div class="tab-pane" id="statistics">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('doctor.add')
    @include('doctor.edit')

    {{-- @if (session('success'))
        <div id="success-alert" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif --}}

@endsection

@section('scripts')
    <script src="{{ asset('js/doctor.js') }}"></script>
@endsection
