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
                        <li><a href="{{ route('services.index') }}">Phương pháp điều trị <i
                                    class="fas fa-chevron-right mx-2"></i></a></li>
                        @if ($service->cat_info)
                            <li><a href="{{ route('services.category', $service->cat_info->slug) }}">{{ $service->cat_info->name }}
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
                                    <a href="{{ route('services.category', $service->cat_info->slug) }}"
                                        class="category-badge">
                                        {{ $service->cat_info->name }}
                                    </a>
                                @endif
                            </div>
                            @if ($service->photo)
                                <img src="{{ asset($service->photo) }}" alt="{{ $service->title }}"
                                    class="service-featured-image img-fluid rounded">
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
                                <h4>Tóm tắt dịch vụ</h4>
                                <p>{{ $service->summary }}</p>
                            </div>

                            <!-- Nội dung dịch vụ -->
                            <div class="service-content">
                                {!! $service->description !!}
                            </div>

                            <!-- Call to Action -->
                            {{-- <div class="service-cta text-center">
                                <h3>Bạn quan tâm đến phương pháp điều trị này?</h3>
                                <p>Hãy đặt lịch tư vấn với chuyên gia của chúng tôi để được giải đáp chi tiết.</p>
                                <a href="{{ route('booking.appointment') }}" class="btn btn-primary btn-lg">Đặt lịch tư vấn
                                    ngay</a>
                            </div> --}}

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
                                            @php
                                                $tags = explode(',', $service->tags);
                                            @endphp
                                            @foreach ($tags as $tag)
                                                <a href="javascript:void(0);">{{ trim($tag) }}</a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Phần bác sĩ chuyên khoa -->
                    <div class="specialists-section mt-5">
                        <h3 class="section-title mb-4">Đội ngũ chuyên gia</h3>
                        <div class="row">
                            <!-- Hiển thị danh sách bác sĩ liên quan đến dịch vụ này (có thể thay thế bằng dữ liệu thực) -->
                            @php
                                // Giả định có một số bác sĩ liên quan, có thể thay bằng truy vấn thực tế
                                $specialists = App\Models\Doctor::where('status', 'active')->take(2)->get();
                            @endphp

                            @if (isset($specialists) && $specialists->count() > 0)
                                @foreach ($specialists as $doctor)
                                    <div class="col-md-6 mb-4">
                                        <div class="doctor-card">
                                            <div class="doctor-info">
                                                <img src="{{ asset($doctor->photo ?? 'images/default-doctor.jpg') }}"
                                                    alt="{{ $doctor->name }}" class="doctor-avatar">
                                                <div>
                                                    <h5 class="mb-1">{{ $doctor->name }}</h5>
                                                    <p class="text-muted mb-0">{{ $doctor->department ?? 'Chuyên khoa' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="doctor-details mt-3">
                                                <p>{{ Str::limit($doctor->short_bio ?? 'Chuyên gia với nhiều năm kinh nghiệm.', 100) }}
                                                </p>
                                                <a href=""
                                                    class="btn btn-outline-primary btn-sm">Xem hồ sơ</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        Hiện chưa có thông tin về chuyên gia phụ trách dịch vụ này.
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Form đăng ký tư vấn -->
                    {{-- <div class="contact-form-section">
                        <h3 class="mb-4 text-center">Đăng ký tư vấn</h3>
                        <form action="{{ route('service.register.consultation') }}" method="POST">
                            @csrf
                            <input type="hidden" name="service_id" value="{{ $service->id }}">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Họ và tên <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="name" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="phone" class="form-label">Số điện thoại <span
                                            class="text-danger">*</span></label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Nội dung tư vấn</label>
                                <textarea class="form-control" id="message" name="message" rows="4"></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4 py-2">Gửi yêu cầu tư vấn</button>
                            </div>
                        </form>
                    </div> --}}

                    <!-- Dịch vụ liên quan -->
                    {{-- @if (isset($relatedServices) && $relatedServices->count() > 0)
                        <div class="related-services mt-5">
                            <h3 class="section-title mb-4">Phương pháp điều trị liên quan</h3>
                            <div class="row">
                                @foreach ($relatedServices as $related)
                                    <div class="col-md-4 mb-4">
                                        <div class="card related-service-card h-100">
                                            @if ($related->photo)
                                                <img src="{{ asset($related->photo) }}" class="card-img-top"
                                                    alt="{{ $related->title }}"
                                                    style="height: 180px; object-fit: cover;">
                                            @else
                                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light"
                                                    style="height: 180px;">
                                                    <i class="fas fa-procedures fa-3x text-primary"></i>
                                                </div>
                                            @endif
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $related->title }}</h5>
                                                <p class="card-text">{{ Str::limit($related->summary, 80) }}</p>
                                            </div>
                                            <div class="card-footer border-top-0 bg-transparent">
                                                <a href="{{ route('services.detail', $related->slug) }}"
                                                    class="btn btn-outline-primary btn-sm w-100">Xem chi tiết</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif --}}
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4 col-12">
                    <div class="service-sidebar">
                        <!-- Widget: Danh mục dịch vụ -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title h5 mb-0">Phương pháp điều trị</h3>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    @php
                                        // Lấy danh mục cha "Phương pháp điều trị"
                                        $parentCategory = App\Models\Category::where('slug', 'dich-vu-y-te')->first();

                                        // Lấy các danh mục con
                                        $serviceCategories = App\Models\Category::where(
                                            'parent_id',
                                            $parentCategory->id ?? 0,
                                        )
                                            ->orderBy('display_order')
                                            ->get();
                                    @endphp

                                    @foreach ($serviceCategories as $cat)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <a
                                                href="{{ route('services.category', $cat->slug) }}">{{ $cat->name }}</a>
                                            <span class="badge bg-primary rounded-pill">
                                                {{ App\Models\Post::where('post_cat_id', $cat->id)->where('post_type', 'service')->where('status', 'active')->count() }}
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- Widget: Đặt lịch khám -->
                        {{-- <div class="card border-primary mb-4">
                            <div class="card-header bg-primary text-white">
                                <h3 class="card-title h5 mb-0">Đặt lịch khám</h3>
                            </div>
                            <div class="card-body">
                                <p>Đặt lịch khám với chuyên gia để được tư vấn về phương pháp điều trị này.</p>
                                <a href="{{ route('booking.appointment') }}" class="btn btn-primary w-100">Đặt lịch
                                    ngay</a>
                            </div>
                        </div> --}}

                        <!-- Widget: Thông tin liên hệ -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h3 class="card-title h5 mb-0">Thông tin liên hệ</h3>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-3">
                                        <i class="fas fa-phone-alt text-primary me-2"></i>
                                        <a href="tel:+842838000000">028 3800 0000</a>
                                    </li>
                                    <li class="mb-3">
                                        <i class="fas fa-envelope text-primary me-2"></i>
                                        <a href="mailto:info@benhvien.com">info@benhvien.com</a>
                                    </li>
                                    <li>
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        123 Đường Lê Lợi, Quận 1, TP. Hồ Chí Minh
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Widget: Dịch vụ nổi bật -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title h5 mb-0">Dịch vụ nổi bật</h3>
                            </div>
                            <div class="card-body">
                                @php
                                    $featuredServices = App\Models\Post::where('post_type', 'service')
                                        ->where('is_featured', true)
                                        ->where('status', 'active')
                                        ->where('id', '!=', $service->id)
                                        ->take(3)
                                        ->get();
                                @endphp

                                @foreach ($featuredServices as $featuredService)
                                    <div class="single-post {{ $loop->last ? '' : 'border-bottom mb-3 pb-3' }}">
                                        <div class="d-flex">
                                            <div class="image me-3" style="flex: 0 0 80px;">
                                                @if ($featuredService->photo)
                                                    <img src="{{ asset($featuredService->photo) }}"
                                                        alt="{{ $featuredService->title }}" class="img-fluid rounded"
                                                        style="height: 60px; width: 80px; object-fit: cover;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center rounded"
                                                        style="height: 60px; width: 80px;">
                                                        <i class="fas fa-procedures text-primary"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="content">
                                                <h5 class="mb-1" style="font-size: 15px;">
                                                    <a href="{{ route('services.detail', $featuredService->slug) }}">
                                                        {{ Str::limit($featuredService->title, 50) }}
                                                    </a>
                                                </h5>
                                                <div class="small text-muted">
                                                    <i class="fas fa-calendar-alt me-1"></i>
                                                    {{ $featuredService->created_at->format('d/m/Y') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
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
