@extends('layouts.master')

@section('title', $service->title)
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/post-detail.css') }}">
    <style>
        .service-highlights {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }

        .service-highlights h4 {
            color: #1565c0;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .service-cta {
            background-color: #e8f4fe;
            border-radius: 8px;
            padding: 25px;
            margin: 30px 0;
            border-left: 4px solid #1565c0;
        }

        .service-cta h3 {
            color: #1565c0;
            margin-bottom: 15px;
        }

        .doctor-card {
            border: 1px solid #eee;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .doctor-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .doctor-info {
            display: flex;
            align-items: center;
        }

        .doctor-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
        }

        .service-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 15px 0;
        }

        .related-service-card {
            height: 100%;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .related-service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .contact-form-section {
            background-color: #f8f9fa;
            border-radius: 8px;
            padding: 25px;
            margin-top: 30px;
        }

        /* CSS cho widget bệnh viện trong sidebar */
        .hospital-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            border: none;
        }

        .hospital-card .card-header {
            background-color: #fff;
            padding: 15px 20px;
            border-bottom: 1px solid #e9edf3;
        }

        .hospital-card .card-header i {
            font-size: 18px;
            color: #1565c0;
        }

        .hospital-card .card-title {
            font-weight: 600;

        }

        .hospital-list {
            padding: 0;
        }

        .hospital-item {
            padding: 15px 20px;
            border-bottom: 1px solid #e9edf3;
            transition: all 0.25s ease;
        }

        .hospital-item:last-child {
            border-bottom: none;
        }

        .hospital-item:hover {
            background-color: #f8fbff;
        }

        .hospital-info {
            display: flex;
            margin-bottom: 12px;
        }

        .hospital-logo {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
            margin-right: 15px;
            border: 1px solid #e9edf3;
            background-color: #fff;
            flex-shrink: 0;
        }

        .hospital-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .hospital-logo-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f0f7ff;
            color: #1565c0;
            font-size: 24px;
        }

        .hospital-details {
            flex: 1;
        }

        .hospital-name {
            font-size: 16px;
            font-weight: 600;
            color: #1565c0;
            margin: 0 0 4px 0;
            line-height: 1.3;
        }

        .hospital-type {
            display: inline-block;
            font-size: 12px;
            color: #556677;
            background-color: #f0f7ff;
            padding: 2px 8px;
            border-radius: 4px;
            margin-bottom: 8px;
        }

        .hospital-address,
        .hospital-phone {
            font-size: 13px;
            color: #556677;
            margin-bottom: 4px;
            display: flex;
            align-items: flex-start;
        }

        .hospital-address i,
        .hospital-phone i {
            font-size: 12px;
            color: #1565c0;
            margin-right: 6px;
            margin-top: 3px;
            width: 14px;
        }

        .hospital-phone a {
            color: #556677;
            text-decoration: none;
        }

        .hospital-phone a:hover {
            color: #1565c0;
            text-decoration: underline;
        }

        .hospital-action {
            text-align: right;
        }

        .btn-view-details {
            display: inline-block;
            color: #fff;
            background-color: #1565c0;
            border: none;
            padding: 6px 15px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-view-details:hover {
            background-color: #0d47a1;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(21, 101, 192, 0.2);
        }

        /* Mặc định chỉ hiển thị 3 bệnh viện đầu tiên */
        .hospital-list .hospital-item:nth-child(n+4) {
            display: none;
        }

        /* Khi có class show-all, hiển thị tất cả */
        .hospital-list.show-all .hospital-item {
            display: block;
        }

        .card-footer {
            background-color: #fff;
            border-top: 1px solid #e9edf3;
            padding: 10px;
        }

        .show-more-hospitals {
            background: none;
            border: none;
            color: #1565c0;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            padding: 5px 10px;
            transition: all 0.2s;
        }

        .show-more-hospitals:hover {
            color: #0d47a1;
        }

        .show-more-hospitals i {
            font-size: 12px;
            margin-left: 5px;
            transition: transform 0.2s;
        }

        .show-more-hospitals.expanded i {
            transform: rotate(180deg);
        }

        .card-header {
            background-color: #1565c0 !important;
            color: #ffffff !important;
        }
    </style>
@endsection

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs py-2">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="bread-list">
                        <li><a href="{{ route('home') }}">Trang chủ <i class="fas fa-chevron-right mx-2"></i></a></li>
                        <li><a href="{{ route('treatment.index') }}">Phương pháp điều trị <i
                                    class="fas fa-chevron-right mx-2"></i></a></li>
                        @if ($service->cat_info)
                            <li><a href="{{ route('treatment.category', $service->cat_info->slug) }}">{{ $service->cat_info->name }}
                                    <i class="fas fa-chevron-right mx-2"></i></a></li>
                        @endif
                        <li class="active"><a href="javascript:void(0);">{{ $service->title }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <div class="service-detail-container py-5">
        <div class="container">
            <div class="row">
                <!-- Nội dung chính -->
                <div class="col-lg-8 col-12">
                    <!-- Card bài viết chính -->
                    <div class="service-article-card">
                        <div class="service-header">
                            <div class="service-category-badge">
                                @if ($service->cat_info)
                                    <a href="{{ route('treatment.category', $service->cat_info->slug) }}"
                                        class="category-badge">
                                        {{ $service->cat_info->name }}
                                    </a>
                                @endif
                            </div>
                            @if ($service->photo)
                                <img src="{{ asset($service->photo) }}" alt="{{ $service->title }}"
                                    class="service-featured-image img-fluid rounded" loading="lazy">
                            @endif
                        </div>

                        <div class="service-content-wrapper">
                            <h1 class="service-title mt-4">{{ $service->title }}</h1>

                            <div class="service-meta mb-4">
                                <div class="service-meta-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    Cập nhật: {{ $service->updated_at->format('d/m/Y') }}
                                </div>
                                <div class="service-meta-item">
                                    <i class="fas fa-eye"></i>
                                    {{ $service->views ?? 0 }} lượt xem
                                </div>
                            </div>

                            <!-- Tóm tắt dịch vụ -->
                            <div class="service-highlights">
                                <h4>Tóm tắt phương pháp điều trị</h4>
                                <p>{{ $service->summary }}</p>
                            </div>

                            <!-- Nội dung dịch vụ -->
                            <div class="service-content">
                                {!! $service->description !!}
                            </div>

                            <!-- Chia sẻ mạng xã hội -->
                            <div class="service-article-footer">
                                <div class="service-share">
                                    <h5>Chia sẻ:</h5>
                                    <div class="sharethis-inline-share-buttons"></div>
                                </div>

                                <!-- Tags -->
                                @if (isset($service->tags) && !empty($service->tags))
                                    <div class="service-tags">
                                        <h5>Thẻ:</h5>
                                        <div class="tag-inner">
                                            @foreach (explode(',', $service->tags) as $tag)
                                                <a href="javascript:void(0);">{{ trim($tag) }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Phần bác sĩ chuyên khoa -->
                    @if (isset($specialists) && $specialists->count() > 0)
                        <div class="specialists-section mt-5">
                            <h3 class="section-title mb-4">Đội ngũ chuyên gia</h3>
                            <div class="row">
                                @foreach ($specialists as $doctor)
                                    <div class="col-md-6 mb-4">
                                        <div class="doctor-card">
                                            <div class="doctor-info">
                                                <img src="{{ asset($doctor->photo ?? 'images/default-doctor.jpg') }}"
                                                    alt="{{ $doctor->name }}" class="doctor-avatar" loading="lazy">
                                                <div>
                                                    <h5 class="mb-1">{{ $doctor->name }}</h5>
                                                    <p class="text-muted mb-0">{{ $doctor->department ?? 'Chuyên khoa' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="doctor-details mt-3">
                                                <p>{{ Str::limit($doctor->short_bio ?? 'Chuyên gia với nhiều năm kinh nghiệm.', 100) }}
                                                </p>
                                                <a href="{{ route('doctor.detail', $doctor->id) }}"
                                                    class="btn btn-outline-primary btn-sm">Xem hồ sơ</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4 col-12">
                    <div class="service-sidebar">
                        <!-- Widget: Danh mục dịch vụ -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title h5 mb-0">Phương pháp điều trị</h3>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    @foreach ($serviceCategories as $cat)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <a
                                                href="{{ route('treatment.category', $cat->slug) }}">{{ $cat->name }}</a>
                                            <span class="badge bg-primary rounded-pill">
                                                {{ $cat->posts_count }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Widget: Bệnh viện/Phòng khám cung cấp -->
                        @if ($isTreatmentPost && isset($service->clinics) && $service->clinics->count() > 0)
                            <div class="card hospital-card mb-4">
                                <div class="card-header d-flex align-items-center">
                                    <h3 class="card-title h5 mb-0">Cơ sở y tế cung cấp</h3>
                                </div>
                                <div class="card-body p-0">
                                    <div class="hospital-list">
                                        @foreach ($service->clinics as $index => $clinic)
                                            <div class="hospital-item {{ $index >= 3 ? 'hidden-clinic' : '' }}">
                                                <div class="hospital-info">
                                                    <div class="hospital-logo">
                                                        @if ($clinic->photo)
                                                            <img src="{{ asset($clinic->photo) }}"
                                                                alt="{{ $clinic->name }}" loading="lazy">
                                                        @else
                                                            <div class="hospital-logo-placeholder">
                                                                <i class="fas fa-hospital"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="hospital-details">
                                                        <h4 class="hospital-name">{{ $clinic->name }}</h4>
                                                        <div class="hospital-type">{{ $clinic->type }}</div>

                                                        @if ($clinic->address)
                                                            <div class="hospital-address">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                                <span>{{ $clinic->address }}</span>
                                                            </div>
                                                        @endif

                                                        @if ($clinic->phone)
                                                            <div class="hospital-phone">
                                                                <i class="fas fa-phone-alt"></i>
                                                                <a
                                                                    href="tel:{{ $clinic->phone }}">{{ $clinic->phone }}</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="hospital-action">
                                                    <a href="{{ route('clinics.detail', $clinic->slug) }}"
                                                        class="btn-view-details">
                                                        Xem chi tiết
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                @if ($service->clinics->count() > 3)
                                    <div class="card-footer text-center">
                                        <button class="show-more-hospitals" type="button">
                                            <span class="show-more-text">Xem thêm</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Widget: Phương pháp điều trị liên quan -->
                        @if (isset($relatedServices) && $relatedServices->count() > 0)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h3 class="card-title h5 mb-0">Phương pháp liên quan</h3>
                                </div>
                                <div class="card-body p-0">
                                    <ul class="list-group list-group-flush">
                                        @foreach ($relatedServices as $related)
                                            <li class="list-group-item">
                                                <div class="d-flex align-items-center">
                                                    @if ($related->photo)
                                                        <div class="me-3 flex-shrink-0">
                                                            <img src="{{ asset($related->photo) }}"
                                                                alt="{{ $related->title }}"
                                                                class="img-fluid rounded"
                                                                style="width: 60px; height: 45px; object-fit: cover;"
                                                                loading="lazy">
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <h6 class="mb-0">
                                                            <a href="{{ route('treatment.detail', $related->slug) }}"
                                                                class="text-decoration-none text-dark">
                                                                {{ Str::limit($related->title, 50) }}
                                                            </a>
                                                        </h6>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script
        src="https://platform-api.sharethis.com/js/sharethis.js#property=5f2e5abf393fa400144f24a5&product=inline-share-buttons"
        async="async"></script>
@endsection
