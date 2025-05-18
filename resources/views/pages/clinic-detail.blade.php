@extends('layouts.master')

@section('main-content')
    <div class="clinic-detail-page py-4">
        <div class="container">
            <!-- Breadcrumb đơn giản -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('clinics.list') }}" class="text-decoration-none">Bệnh viện &
                            Phòng khám</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $clinic->name }}</li>
                </ol>
            </nav>

            <!-- Thông tin chính - Thiết kế sạch -->
            <div class="card mb-4 border shadow-sm">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <!-- Ảnh/Logo -->
                        <div class="col-md-3 mb-md-0 mb-3 text-center">
                            @if ($clinic->photo)
                                <img src="{{ $clinic->photo_url }}" alt="{{ $clinic->name }}" class="clinic-img">
                            @else
                                <div class="clinic-placeholder">
                                    <i
                                        class="fas {{ $clinic->type == 'Bệnh viện' ? 'fa-hospital' : 'fa-clinic-medical' }} fa-3x text-secondary"></i>
                                </div>
                            @endif
                        </div>

                        <!-- Thông tin cơ bản -->
                        <div class="col-md-9">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h1 class="h3 mb-0">{{ $clinic->name }}</h1>
                                <span class="badge {{ $clinic->type == 'Bệnh viện' ? 'bg-primary' : 'bg-info' }}">
                                    {{ $clinic->type }}
                                </span>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h5 class="fs-6 mb-1"><i class="fas fa-map-marker-alt text-muted me-2"></i> Địa chỉ</h5>
                                    <p class="mb-0">{{ $clinic->address }}</p>
                                </div>

                                @if ($clinic->phone)
                                    <div class="col-md-6 mb-3">
                                        <h5 class="fs-6 mb-1"><i class="fas fa-phone-alt text-muted me-2"></i> Số điện thoại
                                        </h5>
                                        <p class="mb-0">{{ $clinic->phone }}</p>
                                    </div>
                                @endif

                                @if ($clinic->email)
                                    <div class="col-md-6 mb-3">
                                        <h5 class="fs-6 mb-1"><i class="fas fa-envelope text-muted me-2"></i> Email</h5>
                                        <p class="mb-0">{{ $clinic->email }}</p>
                                    </div>
                                @endif

                                @if ($clinic->website)
                                    <div class="col-md-6 mb-3">
                                        <h5 class="fs-6 mb-1"><i class="fas fa-globe text-muted me-2"></i> Website</h5>
                                        <p class="mb-0">
                                            <a href="{{ $clinic->website }}" target="_blank">{{ $clinic->website }}</a>
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mô tả chi tiết -->
            <div class="card mb-4 border shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Giới thiệu sơ lược</h5>
                </div>
                <div class="card-body p-4">
                    @if (isset($clinic->description) && $clinic->description)
                        {!! $clinic->description !!}
                    @else
                        <p>{{ $clinic->name }} là một {{ strtolower($clinic->type) }} cung cấp dịch vụ y tế chất lượng
                            cao. Với đội ngũ nhân viên chuyên nghiệp và thiết bị hiện đại, {{ $clinic->name }} cam kết mang
                            đến cho bệnh nhân những dịch vụ y tế đạt tiêu chuẩn.</p>
                    @endif
                </div>
            </div>

            <!-- Bản đồ -->
            <div class="card border shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Vị trí</h5>
                </div>
                <div class="card-body p-0">
                    <div class="map-container">
                        <img src="https://maps.googleapis.com/maps/api/staticmap?center={{ urlencode($clinic->address) }}&zoom=15&size=800x300&maptype=roadmap&markers=color:red%7C{{ urlencode($clinic->address) }}&key=YOUR_API_KEY"
                            class="w-100" alt="Vị trí {{ $clinic->name }}">
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($clinic->address) }}"
                        class="btn btn-sm btn-outline-secondary" target="_blank">
                        <i class="fas fa-directions me-1"></i> Xem trên Google Maps
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Simple & clean styles */
        .clinic-img {
            width: 160px;
            height: 160px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #dee2e6;
        }

        .clinic-placeholder {
            width: 160px;
            height: 160px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }

        .map-container {
            height: 300px;
            overflow: hidden;
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, .125);
        }

        .card-footer {
            border-top: 1px solid rgba(0, 0, 0, .125);
        }

        /* Responsive */
        @media (max-width: 768px) {

            .clinic-img,
            .clinic-placeholder {
                width: 120px;
                height: 120px;
            }
        }
    </style>
@endsection
