@extends('layouts.master')

@section('title', 'Trang Chủ')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main-content')
    <div class="container-fluid mt-4">
        <div class="container">
            <!-- Hero Section -->
            <section class="modern-hero">
                <div class="hero-overlay"></div>
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="hero-content">
                                <h5 class="hero-subtitle">Chăm sóc sức khỏe tận tâm</h5>
                                <h1 class="hero-title">Sức khỏe là mối quan tâm hàng đầu của chúng tôi</h1>
                                <p class="hero-description">Thông tin y tế chuẩn xác kết hợp dịch vụ khám chữa bệnh chất
                                    lượng từ đội ngũ bác sĩ chuyên khoa hàng đầu.</p>
                                <a href="{{ route('doctors.list') }}" class="hero-button">Tìm hiểu ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Feature Shortcuts Section -->
            <div class="feature-shortcuts-wrapper">
                <div class="container">
                    <div
                        class="feature-shortcuts rounded-4 d-flex justify-content-between flex-wrap gap-4 bg-white px-3 py-4 shadow">
                        <div class="shortcut-item text-center">
                            <div class="shortcut-icon bg-purple"><i class="fas fa-calendar-alt"></i></div>
                            <p class="shortcut-label">Đặt lịch khám</p>
                        </div>
                        <div class="shortcut-item text-center">
                            <div class="shortcut-icon bg-blue"><i class="fas fa-user-md"></i></div>
                            <p class="shortcut-label">Liên hệ với bác sĩ</p>
                        </div>
                        <div class="shortcut-item text-center">
                            <div class="shortcut-icon bg-pink"><i class="fas fa-hospital"></i></div>
                            <p class="shortcut-label">Tìm kiếm bệnh viện-phòng khám</p>
                        </div>
                        <div class="shortcut-item text-center">
                            <div class="shortcut-icon bg-cyan"><i class="fas fa-book"></i></div>
                            <p class="shortcut-label">Theo dõi tin tức sức khỏe</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Featured Services Section -->
            <section class="featured-services">
                <div class="container">
                    <div class="section-header">
                        <h2 class="section-title">Dịch vụ y tế</h2>
                        <p class="section-subtitle">Cung cấp đa dạng dịch vụ chăm sóc sức khỏe chất lượng cao</p>
                    </div>
                    <div class="row d-none d-md-flex">
                        <div class="col-md-4 mb-4">
                            <div class="service-card">
                                <div class="service-badge">Phổ biến</div>
                                <div class="service-icon">
                                    <i class="fas fa-heartbeat"></i>
                                </div>
                                <h3 class="service-title">Khám sức khỏe tổng quát</h3>
                                <p class="service-description">Gói khám toàn diện giúp đánh giá tổng thể sức khỏe và phát
                                    hiện sớm các bệnh lý tiềm ẩn</p>
                                <ul class="service-features">
                                    <li><i class="fas fa-check"></i> <span>Kiểm tra toàn diện</span></li>
                                    <li><i class="fas fa-check"></i> <span>Bác sĩ chuyên môn cao</span></li>
                                    <li><i class="fas fa-check"></i> <span>Kết quả chi tiết</span></li>
                                </ul>
                                <div class="service-footer">
                                    <div class="service-price">Từ 1.500.000đ</div>
                                    <a href="#" class="btn service-btn">Đặt lịch ngay</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="service-card">
                                <div class="service-badge">Chuyên sâu</div>
                                <div class="service-icon">
                                    <i class="fas fa-stethoscope"></i>
                                </div>
                                <h3 class="service-title">Khám chuyên khoa</h3>
                                <p class="service-description">Dịch vụ khám chuyên sâu theo từng chuyên khoa với bác sĩ có
                                    chuyên môn cao</p>
                                <ul class="service-features">
                                    <li><i class="fas fa-check"></i> <span>20+ chuyên khoa</span></li>
                                    <li><i class="fas fa-check"></i> <span>Bác sĩ đầu ngành</span></li>
                                    <li><i class="fas fa-check"></i> <span>Thiết bị hiện đại</span></li>
                                </ul>
                                <div class="service-footer">
                                    <div class="service-price">Từ 500.000đ</div>
                                    <a href="#" class="btn service-btn">Đặt lịch ngay</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="service-card">
                                <div class="service-badge">Tiện lợi</div>
                                <div class="service-icon">
                                    <i class="fas fa-comments"></i>
                                </div>
                                <h3 class="service-title">Tư vấn sức khỏe online</h3>
                                <p class="service-description">Giải đáp thắc mắc sức khỏe trực tuyến, tiết kiệm thời gian di
                                    chuyển</p>
                                <ul class="service-features">
                                    <li><i class="fas fa-check"></i> <span>Tư vấn 24/7</span></li>
                                    <li><i class="fas fa-check"></i> <span>Bảo mật thông tin</span></li>
                                    <li><i class="fas fa-check"></i> <span>Kết nối nhanh chóng</span></li>
                                </ul>
                                <div class="service-footer">
                                    <div class="service-price">Từ 300.000đ</div>
                                    <a href="#" class="btn service-btn">Đặt lịch ngay</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Mobile services section --}}
                    <div class="swiper service-swiper d-md-none">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="service-card">
                                    <div class="service-badge">Phổ biến</div>
                                    <div class="service-icon"><i class="fas fa-heartbeat"></i></div>
                                    <h3 class="service-title">Khám sức khỏe tổng quát</h3>
                                    <p class="service-description">Gói khám toàn diện giúp đánh giá tổng thể sức khỏe và
                                        phát hiện
                                        sớm các bệnh lý tiềm ẩn</p>
                                    <ul class="service-features">
                                        <li><i class="fas fa-check"></i> <span>Kiểm tra toàn diện</span></li>
                                        <li><i class="fas fa-check"></i> <span>Bác sĩ chuyên môn cao</span></li>
                                        <li><i class="fas fa-check"></i> <span>Kết quả chi tiết</span></li>
                                    </ul>
                                    <div class="service-footer">
                                        <div class="service-price">Từ 1.500.000đ</div>
                                        <a href="#" class="btn service-btn">Đặt lịch ngay</a>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="service-card">
                                    <div class="service-badge">Chuyên sâu</div>
                                    <div class="service-icon"><i class="fas fa-stethoscope"></i></div>
                                    <h3 class="service-title">Khám chuyên khoa</h3>
                                    <p class="service-description">Dịch vụ khám chuyên sâu theo từng chuyên khoa với bác sĩ
                                        có
                                        chuyên môn cao</p>
                                    <ul class="service-features">
                                        <li><i class="fas fa-check"></i> <span>20+ chuyên khoa</span></li>
                                        <li><i class="fas fa-check"></i> <span>Bác sĩ đầu ngành</span></li>
                                        <li><i class="fas fa-check"></i> <span>Thiết bị hiện đại</span></li>
                                    </ul>
                                    <div class="service-footer">
                                        <div class="service-price">Từ 500.000đ</div>
                                        <a href="#" class="btn service-btn">Đặt lịch ngay</a>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="service-card">
                                    <div class="service-badge">Tiện lợi</div>
                                    <div class="service-icon"><i class="fas fa-comments"></i></div>
                                    <h3 class="service-title">Tư vấn sức khỏe online</h3>
                                    <p class="service-description">Giải đáp thắc mắc sức khỏe trực tuyến, tiết kiệm thời
                                        gian di
                                        chuyển</p>
                                    <ul class="service-features">
                                        <li><i class="fas fa-check"></i> <span>Tư vấn 24/7</span></li>
                                        <li><i class="fas fa-check"></i> <span>Bảo mật thông tin</span></li>
                                        <li><i class="fas fa-check"></i> <span>Kết nối nhanh chóng</span></li>
                                    </ul>
                                    <div class="service-footer">
                                        <div class="service-price">Từ 300.000đ</div>
                                        <a href="#" class="btn service-btn">Đặt lịch ngay</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination mt-2"></div>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="#" class="btn btn-outline-primary service-view-all">Xem tất cả dịch vụ <i
                                class="fas fa-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </section>


            <!-- Search Section -->
            <section class="search-section bg-light py-4">
                <div class="container">
                    <div class="search-container">
                        <form action="{{ route('search.results') }}" method="GET" class="search-form">
                            <div class="input-group">
                                <input type="text" name="q" id="Pesquisar" class="form-control"
                                    placeholder="Tìm kiếm bài viết, bác sĩ..." aria-label="Tìm kiếm">
                                <button class="btn btn-primary" type="submit" id="searchBtn">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <ul id="autocompleteDropdown" class="dropdown-menu w-100" style="display:none;"></ul>
                        </form>
                    </div>
                </div>
            </section>

            <!-- Trending Articles Section -->
            <div class="trending-articles-container">
                <div class="container">
                    <div class="explore-header d-flex justify-content-between align-items-center mb-4 pb-2">
                        <h3 class="fw-bold mb-0">Bài viết nổi bật</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            @php $mainPost = $topViewedPosts->first(); @endphp
                            @if ($mainPost)
                                <div class="trending-main">
                                    <div class="trending-main-image">
                                        <img src="{{ asset($mainPost->photo) }}" alt="{{ $mainPost->title }}">
                                    </div>
                                    <div class="trending-main-overlay">
                                        <div class="trending-main-content">
                                            <a href="{{ route('post.detail', $mainPost->slug) }}"
                                                class="trending-content d-flex flex-column align-items-start text-decoration-none mt-3">
                                                <h2 class="trending-main-title">{{ $mainPost->title }}</h2>
                                                <p class="trending-main-excerpt">{{ Str::limit($mainPost->summary, 130) }}
                                                </p>
                                            </a>
                                            <div class="trending-author-info d-flex align-items-center mt-3">
                                                <img src="{{ asset($mainPost->author_info->photo ?? asset('images/default-avatar.png')) }}"
                                                    alt="{{ $mainPost->author_info->name }}"
                                                    class="author-photo rounded-circle"
                                                    style="width: 40px; height: 40px; object-fit: cover; margin-right: 10px;">
                                                <span class="author-name">{{ $mainPost->author_info->name }}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endif
                        </div>


                        <div class="col-md-4">
                            <div class="trending-side">
                                @foreach ($topViewedPosts->slice(1) as $post)
                                    <div class="trending-side-item">
                                        <div class="trending-side-image">
                                            <img src="{{ asset($post->photo) }}" alt="{{ $post->title }}">
                                        </div>
                                        <div class="trending-side-content">
                                            <h3 class="trending-side-title">
                                                <a href="{{ route('post.detail', $post->slug) }}">{{ $post->title }}</a>
                                            </h3>
                                            <p class="trending-side-excerpt">{{ Str::limit($post->summary, 60) }}</p>
                                            <div class="trending-side-author">By {{ $post->author_info->name }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile: chỉ hiển thị dưới md -->
            <div class="d-block d-md-none mt-4">
                <div class="swiper post-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($posts as $post)
                            <div class="swiper-slide">
                                <div class="article-card">
                                    <a href="{{ route('post.detail', ['slug' => $post->slug]) }}" class="article-link">
                                        <div class="article-image-container" style="height: 180px;">
                                            <img src="{{ asset($post->photo) }}" alt="{{ $post->title }}"
                                                loading="lazy">
                                        </div>
                                        <div class="article-content" style="padding: 15px;">
                                            <h3 class="article-title" style="font-size: 1rem;">{{ $post->title }}</h3>
                                            <p class="article-excerpt">{{ Str::limit(strip_tags($post->summary), 60) }}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination mt-2"></div>
                </div>
            </div>


            <!-- Explore Categories -->
            <div class="explore-section mb-4 mt-5">
                <div class="explore-header d-flex justify-content-between align-items-center mb-4 pb-2">
                    <h3 class="fw-bold mb-0">Khám phá theo danh mục</h3>
                    <a href="{{ route('categories.all') }}" class="view-all-link">
                        Xem tất cả <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                <div class="explore-categories d-flex flex-wrap gap-4">
                    @foreach ($popularCategories as $category)
                        <div class="explore-item-wrapper">
                            <a href="{{ route('filter.posts', ['category' => $category->title]) }}"
                                class="explore-item text-decoration-none text-center">
                                <div class="explore-icon">
                                    {{-- <img src="{{ asset($category->photo ?? 'asset/images/category/category-default.png') }}"
                                        alt="{{ $category->title }}" loading="lazy"> --}}
                                    <img src="{{ asset('asset/images/category/' . $category->slug . '.png' ?? 'asset/images/category/category-default.png') }}"
                                        class="img-fluid category-thumbnail" alt="{{ $category->title }}"
                                        loading="lazy">
                                </div>
                                <div class="explore-label">{{ $category->title }}</div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Latest Posts Section -->
            <div class="d-none d-md-block">

                <div class="explore-header d-flex justify-content-between align-items-center mb-4 pb-2">
                    <h3>Bài viết mới</h3>
                </div>
                <div class="container mt-3" id="postsContainer">
                    @include('partials.posts', ['posts' => $posts])
                </div>

                <!-- Swiper cho màn hình mobile -->
                <div class="d-block d-md-none mt-4">
                    <div class="swiper post-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($posts as $post)
                                <div class="swiper-slide">
                                    <div class="article-card">
                                        <a href="{{ route('post.detail', ['slug' => $post->slug]) }}"
                                            class="article-link">
                                            <div class="article-image-container" style="height: 180px;">
                                                <img src="{{ asset($post->photo) }}" alt="{{ $post->title }}"
                                                    loading="lazy">
                                            </div>
                                            <div class="article-content" style="padding: 15px;">
                                                <h3 class="article-title" style="font-size: 1rem;">{{ $post->title }}
                                                </h3>
                                                <p class="article-excerpt">
                                                    {{ Str::limit(strip_tags($post->summary), 60) }}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination mt-2"></div>
                    </div>
                </div>

            </div>

            <!-- Category Posts Sections - -->
            @foreach ($popularCategories as $category)
                @if (isset($category->loaded_posts) && $category->loaded_posts->isNotEmpty())
                    <div class="category-container">
                        <div class="category-header">
                            <span>{{ $category->title }}</span>
                            @if ($category->slug)
                                <a href="{{ route('category.show', ['slug' => $category->slug]) }}">
                                    <span>Xem tất cả <i class="fas fa-arrow-right"></i></span>
                                </a>
                            @endif
                        </div>
                        <div class="articles">
                            @php
                                $firstPost = $category->loaded_posts->first();
                                $remainingPosts = $category->loaded_posts->slice(1);
                            @endphp

                            @if ($firstPost)
                                <div class="first-row">
                                    <a href="{{ route('post.detail', $firstPost->slug) }}" class="post-link">
                                        <div class="featured-image">
                                            <img src="{{ asset($firstPost->photo) }}" alt="{{ $firstPost->title }}"
                                                loading="lazy" />
                                        </div>
                                        <div class="text-content">
                                            <span class="badge">{{ $category->title }}</span>
                                            <h3>{{ $firstPost->title }}</h3>
                                            <p>{{ Str::limit($firstPost->summary, 100) }}</p>
                                        </div>
                                    </a>
                                </div>
                            @endif

                            @foreach ($remainingPosts as $post)
                                <div class="article">
                                    <a href="{{ route('post.detail', $post->slug) }}" class="post-link">
                                        <span class="badge">{{ $category->title }}</span>
                                        <h3>{{ $post->title }}</h3>
                                        <p>{{ Str::limit($post->summary, 100) }}</p>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach

            <!-- Top Doctors Section -->
            <div class="doctor-category container mt-5">
                <h2 class="section-title mt-5 text-center">Bác Sĩ Nổi Bật</h2>
                <div class="row mt-4">
                    @foreach ($topDoctors as $doctor)
                        <div class="col-md-3 mb-4">
                            <a href="{{ route('doctor.detail', $doctor->id) }}" class="text-decoration-none">
                                <div class="doctor-card p-4 text-center">
                                    <img src="{{ $doctor->photo ?? asset('asset/images/users/default-doctor.png') }}"
                                        class="doctor-photo mb-3"
                                        alt="{{ $doctor->name }}" loading="lazy">
                                    <h5 class="mb-2">{{ $doctor->name }}</h5>
                                    @if ($doctor->specializations->isNotEmpty())
                                        <p class="text-muted mb-0">{{ $doctor->specializations->first()->name }}</p>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Cache DOM elements để tăng performance
            const $searchInput = $('#Pesquisar');
            const $dropdown = $('#autocompleteDropdown');
            const $searchForm = $('.search-form');
            const $postsContainer = $('#postsContainer');

            // Debounce timeout để giảm số lượng AJAX calls
            let searchTimeout;

            // Top keywords
            const topKeywords = ['Bệnh tim mạch', 'Tiêm chủng', 'Chăm sóc sức khỏe', 'Dinh dưỡng'];

            // Hiển thị top keywords
            function showTopKeywords() {
                $dropdown.empty().append('<li class="dropdown-header">Từ khóa tìm kiếm hàng đầu:</li>');
                topKeywords.forEach(function(keyword) {
                    const li = $('<li></li>').text(keyword).css('cursor', 'pointer');
                    li.on('click', function() {
                        $searchInput.val(keyword);
                        performSearch(keyword);
                    });
                    $dropdown.append(li);
                });
                $dropdown.show();
            }

            // Optimized search function với error handling
            function performSearch(query) {
                if (!query || query.length < 2) return;

                $.ajax({
                    url: '{{ route('search') }}',
                    method: 'GET',
                    data: {
                        q: query
                    },
                    dataType: 'json',
                    timeout: 5000, // 5 second timeout
                    success: function(data) {
                        updateSearchDropdown(data, query);
                    },
                    error: function(xhr, status, error) {
                        console.log('Search error:', error);
                        $dropdown.hide();
                    }
                });
            }

            // Update search dropdown với grouped results
            function updateSearchDropdown(data, query) {
                $dropdown.empty();

                if (data.results && data.results.length) {
                    $dropdown.append(`<li class="dropdown-header">Tìm thấy ${data.count} kết quả</li>`);

                    // Group results by type
                    const posts = data.results.filter(item => item.type === 'post');
                    const doctors = data.results.filter(item => item.type === 'doctor');

                    // Add posts section
                    if (posts.length > 0) {
                        $dropdown.append(
                            '<li class="dropdown-divider"></li><li class="dropdown-header">Bài viết</li>');
                        posts.forEach(function(item) {
                            const li = $('<li class="search-result-item"></li>')
                                .html(`<i class="fas fa-file-alt me-2"></i>${item.title}`)
                                .on('click', () => window.location.href = `/post/${item.slug}`);
                            $dropdown.append(li);
                        });
                    }

                    // Add doctors section
                    if (doctors.length > 0) {
                        $dropdown.append(
                            '<li class="dropdown-divider"></li><li class="dropdown-header">Bác sĩ</li>');
                        doctors.forEach(function(item) {
                            const li = $('<li class="search-result-item"></li>')
                                .html(
                                    `<i class="fas fa-user-md me-2"></i>${item.title} <small>(${item.specialty})</small>`
                                )
                                .on('click', () => window.location.href = `/doctor/${item.id}`);
                            $dropdown.append(li);
                        });
                    }

                    // Add view all results
                    $dropdown.append('<li class="dropdown-divider"></li>')
                        .append(
                            `<li class="view-all-results" onclick="window.location.href='/search-results?q=${encodeURIComponent(query)}'">Xem tất cả kết quả</li>`
                        );

                    $dropdown.show();
                } else {
                    $dropdown.append('<li class="no-results">Không tìm thấy kết quả nào.</li>').show();
                }
            }

            // Search input với debouncing
            $searchInput.on('input', function() {
                const query = $(this).val().trim();
                clearTimeout(searchTimeout);

                if (query.length >= 2) {
                    // Debounce search để giảm số lượng requests
                    searchTimeout = setTimeout(() => performSearch(query), 300);
                } else {
                    showTopKeywords();
                }
            });

            // Focus handler
            $searchInput.on('focus', function() {
                if (!$(this).val().trim()) {
                    showTopKeywords();
                }
            });

            // Form submit handler
            $searchForm.on('submit', function(e) {
                const query = $searchInput.val().trim();
                if (!query) {
                    e.preventDefault();
                    showTopKeywords();
                }
            });

            // Category filter với improved error handling
            $('.category-card, #Genero').on('click change', function() {
                const categoryTitle = $(this).data('title') || $(this).val();
                if (!categoryTitle) return;

                $postsContainer.html(
                    '<div class="text-center"><div class="spinner-border" role="status"></div><p>Đang tải...</p></div>'
                );

                $.ajax({
                    url: '{{ route('filter.posts') }}',
                    type: 'GET',
                    data: {
                        category: categoryTitle
                    },
                    dataType: 'json',
                    timeout: 10000,
                    success: function(response) {
                        $postsContainer.html(response.html);
                    },
                    error: function(xhr, status, error) {
                        console.log('Filter error:', error);
                        $postsContainer.html(
                            '<div class="alert alert-danger text-center">Có lỗi xảy ra khi tải bài viết. Vui lòng thử lại.</div>'
                        );
                    }
                });
            });

            // Hide dropdown khi click outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-container').length) {
                    $dropdown.hide();
                }
            });

            // Keyboard navigation cho search dropdown (bonus optimization)
            $searchInput.on('keydown', function(e) {
                const $items = $dropdown.find('li.search-result-item, li.view-all-results');
                const currentIndex = $items.index($dropdown.find('.highlighted'));

                if (e.keyCode === 40) { // Arrow down
                    e.preventDefault();
                    const nextIndex = currentIndex < $items.length - 1 ? currentIndex + 1 : 0;
                    $items.removeClass('highlighted').eq(nextIndex).addClass('highlighted');
                } else if (e.keyCode === 38) { // Arrow up
                    e.preventDefault();
                    const prevIndex = currentIndex > 0 ? currentIndex - 1 : $items.length - 1;
                    $items.removeClass('highlighted').eq(prevIndex).addClass('highlighted');
                } else if (e.keyCode === 13) { // Enter
                    const $highlighted = $dropdown.find('.highlighted');
                    if ($highlighted.length) {
                        e.preventDefault();
                        $highlighted.click();
                    }
                }
            });
        });
    </script>

    <!-- CSS cho search dropdown navigation (thêm vào file CSS) -->
    <style>
        .search-result-item.highlighted,
        .view-all-results.highlighted {
            background-color: #f8f9fa;
        }

        .search-result-item,
        .view-all-results {
            padding: 8px 15px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .search-result-item:hover,
        .view-all-results:hover {
            background-color: #e9ecef;
        }

        .spinner-border {
            color: #1EABF8;
        }
    </style>

@endsection
@section('scripts')
    <script>
        new Swiper('.service-swiper', {
            slidesPerView: 1.2,
            spaceBetween: 16,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });

        new Swiper('.post-swiper', {
            slidesPerView: 1.2,
            spaceBetween: 16,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
@endsection
