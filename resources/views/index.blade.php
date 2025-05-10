@extends('layouts.master')

@section('title', 'Trang Chủ')

@section('main-content')
    <div class="container-fluid mt-4">
        <div class="container">

            <!-- Hero Section -->
            <section class="modern-hero">
                <!-- Overlay tối -->
                <div class="hero-overlay"></div>

                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <!-- Nội dung hero -->
                            <div class="hero-content">
                                <h5 class="hero-subtitle">Chăm sóc sức khỏe tận tâm</h5>
                                <h1 class="hero-title">Sức khỏe là mối quan tâm hàng đầu của chúng tôi</h1>
                                <p class="hero-description">Thông tin y tế chuẩn xác kết hợp dịch vụ khám chữa bệnh chất
                                    lượng từ đội ngũ bác sĩ chuyên khoa hàng đầu.</p>
                                <a href="{{ route('doctors.list') }}" class="hero-button">Đặt lịch khám ngay</a>

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
                        <!-- Item -->
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

                    <div class="row">
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

                    <div class="mt-4 text-center">
                        <a href="#" class="btn btn-outline-primary service-view-all">Xem tất cả dịch vụ <i
                                class="fas fa-arrow-right ms-2"></i></a>
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

            <!-- Explore Categories -->
            <div class="explore-section mb-4 mt-5">
                <div class="explore-header d-flex justify-content-between align-items-center mb-4 pb-2">
                    <h3 class="fw-bold mb-0"> Khám phá theo danh mục</h3>
                    <a href="" class="view-all-link">
                        Xem tất cả <i class="fas fa-arrow-right"></i>
                    </a>
                </div>


                <div class="explore-categories d-flex flex-wrap gap-4">
                    @foreach ($popularCategories as $category)
                        <div class="explore-item-wrapper">
                            <a href="{{ route('filter.posts', ['category' => $category->title]) }}"
                                class="explore-item text-decoration-none text-center">
                                <div class="explore-icon">
                                    <img src="{{ asset($category->photo ?? 'images/category-default.png') }}"
                                        alt="{{ $category->title }}">
                                </div>
                                <div class="explore-label">{{ $category->title }}</div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="explore-header d-flex justify-content-between align-items-center mb-4 pb-2">
                <h3>Bài viết mới</h3>
            </div>
            <!-- Danh sách bài viết -->
            <div class="container mt-3" id="postsContainer">
                @include('partials.posts', ['posts' => $posts])
            </div>


            @foreach ($popularCategories as $category)
                <div class="category-container">
                    <div class="category-header">
                        <span>{{ $category->title }}</span>
                        @if ($category && $category->slug)
                            <a href="{{ route('category.show', ['slug' => $category->slug]) }}"><span>Xem tất cả <i
                                        class="fas fa-arrow-right"></i></span></a>
                        @endif
                    </div>

                    <div class="categories">

                    </div>

                    <div class="articles">
                        @php
                            $posts = $category->posts()->latest()->take(5)->get();
                            $firstPost = $posts->shift();
                        @endphp


                        @if ($firstPost)
                            <div class="first-row">
                                <a href="{{ route('post.detail', $firstPost->slug) }}" class="post-link">
                                    <div class="featured-image">
                                        <img src="{{ asset($firstPost->photo) }}" alt="{{ $firstPost->title }}" />
                                    </div>
                                    <div class="text-content">
                                        <span class="badge">{{ $category->title }}</span>
                                        <h3>{{ $firstPost->title }}</h3>
                                        <p>{{ Str::limit($firstPost->summary, 100) }}</p>
                                    </div>
                                </a>
                            </div>
                        @endif

                        @foreach ($posts as $post)
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
            @endforeach

            <div class="doctor-category container mt-5">
                <h2 class="section-title mt-5 text-center">Bác Sĩ Nổi Bật</h2>
                <div class="row mt-4">
                    @foreach ($topDoctors as $doctor)
                        <div class="col-md-3 mb-4">
                            <a href="{{ route('doctor.detail', $doctor->id) }}" class="text-decoration-none">
                                <div class="doctor-card p-4 text-center">
                                    <img src="{{ asset($doctor->photo) }}" class="doctor-photo mb-3"
                                        alt="{{ $doctor->name }}">
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
            // Danh sách từ khóa hàng đầu (bạn có thể thay bằng dữ liệu lấy từ backend nếu cần)
            var topKeywords = [
                'Bệnh tim mạch',
                'Tiêm chủng',
                'Chăm sóc sức khỏe',
                'Dinh dưỡng'
            ];

            // Hàm hiển thị danh mục từ khóa hàng đầu trong dropdown
            function showTopKeywords() {
                var dropdown = $('#autocompleteDropdown');
                dropdown.empty();
                dropdown.append('<li class="dropdown-header">Từ khóa tìm kiếm hàng đầu:</li>');
                topKeywords.forEach(function(keyword) {
                    var li = $('<li></li>');
                    li.text(keyword);
                    li.css('cursor', 'pointer');
                    li.on('click', function() {
                        $('#Pesquisar').val(keyword);
                        // Nếu click vào từ khóa, có thể gọi tìm kiếm hoặc chuyển hướng trang kết quả
                        performSearch(keyword);
                    });
                    dropdown.append(li);
                });
                dropdown.show();
            }

            // Hàm gọi API tìm kiếm và cập nhật dropdown với kết quả
            function performSearch(query) {
                $.ajax({
                    url: '{{ route('search') }}', // Route API tìm kiếm đã đăng ký trong Laravel
                    method: 'GET',
                    data: {
                        q: query
                    },
                    dataType: 'json',
                    success: function(data) {
                        var dropdown = $('#autocompleteDropdown');
                        dropdown.empty(); // Xóa nội dung cũ
                        if (data.results && data.results.length) {
                            dropdown.append('<li class="dropdown-header">Tìm thấy ' + data.count +
                                ' kết quả</li>');
                            // Hiển thị tối đa 6 kết quả
                            data.results.slice(0, 6).forEach(function(item) {
                                var li = $('<li></li>');
                                li.text(item.title + ' - ' + item.author);
                                li.on('click', function() {
                                    // Chuyển hướng đến trang chi tiết bài viết
                                    window.location.href = '/post/' + item.slug;
                                });
                                dropdown.append(li);
                            });
                            // Thêm mục "Xem thêm kết quả" nếu muốn chuyển đến trang kết quả tìm kiếm riêng
                            dropdown.append(
                                '<li style="text-align: center; font-weight: bold; border-top: 1px solid #ccc;" onclick="window.location.href=\'/search-results?q=' +
                                encodeURIComponent(query) + '\'">Xem thêm kết quả</li>');

                            dropdown.show();
                        } else {
                            dropdown.append('<li>Không tìm thấy kết quả nào.</li>');
                            dropdown.show();
                        }
                    },
                    error: function() {
                        $('#autocompleteDropdown').hide();
                    }
                });
            }

            // Khi người dùng nhập liệu trong ô tìm kiếm
            $('#Pesquisar').on('input', function() {
                var query = $(this).val().trim();
                if (query.length >= 2) {
                    performSearch(query);
                } else {
                    showTopKeywords();
                }
            });

            // Khi ô tìm kiếm được focus, nếu trống thì hiển thị top keywords
            $('#Pesquisar').on('focus', function() {
                if ($(this).val().trim() === '') {
                    showTopKeywords();
                }
            });

            // Xử lý sự kiện click nút tìm kiếm
            $('#searchBtn').on('click', function() {
                var query = $('#Pesquisar').val().trim();
                if (query !== '') {
                    // Chuyển hướng trực tiếp sang trang kết quả tìm kiếm
                    window.location.href = '/search-results?q=' + encodeURIComponent(query);
                } else {
                    showTopKeywords();
                }
            });


            // Ẩn dropdown khi click bên ngoài khối tìm kiếm
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.search-container').length) {
                    $('#autocompleteDropdown').hide();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.category-card').on('click', function() {
                var categoryTitle = $(this).data('title'); // Lấy tên danh mục từ thuộc tính data-title
                console.log("Danh mục được chọn:", categoryTitle)


                // Hiển thị loading indicator
                $('#postsContainer').html('<p class="text-center">Đang tải...</p>');

                $.ajax({
                    url: '{{ route('filter.posts') }}',
                    type: 'GET',
                    data: {
                        category: categoryTitle
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Cập nhật nội dung của postsContainer bằng HTML trả về từ controller
                        $('#postsContainer').html(response.html);
                    },
                    error: function() {
                        alert('Có lỗi xảy ra khi tải bài viết theo danh mục.');
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Lắng nghe sự kiện khi người dùng thay đổi danh mục trong dropdown
            $('#Genero').on('change', function() {
                var selectedCategory = $(this).val(); // Lấy giá trị danh mục được chọn
                console.log('Danh mục được chọn:', selectedCategory); // Kiểm tra log

                // Hiển thị loading indicator
                $('#postsContainer').html('<p class="text-center">Đang tải...</p>');

                $.ajax({
                    url: '{{ route('filter.posts') }}',
                    type: 'GET',
                    data: {
                        category: selectedCategory
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#postsContainer').html(response.html);
                    },
                    error: function() {
                        alert('Có lỗi xảy ra khi tải bài viết theo danh mục.');
                    }
                });
            });
        });
    </script>

@endsection

<style>
    .doctor-category {
        background-color: #fff;
        border-radius: 8px;
    }

    .doctor-card {
        border: none;
        border-radius: 15px;
        transition: all 0.3s ease;
    }

    .doctor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .doctor-photo {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #f8f9fa;
        margin: 0 auto;
    }

    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 2rem;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 50px;
        height: 3px;
        background: #0984e3;
    }

    .dropdown-menu {
        background-color: #fff;
        border: 1px solid #ccc;
        border-top: none;
        max-height: 250px;
        overflow-y: auto;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .dropdown-menu li {
        padding: 10px;
        cursor: pointer;
    }

    .dropdown-menu li:hover,
    .dropdown-menu .dropdown-header:hover {
        background-color: #f8f9fa;
    }

    .dropdown-header {
        font-weight: bold;
        padding: 10px;
        background-color: #eee;
    }

    .category-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        flex-wrap: wrap;
        gap: 10px;
    }

    .category-header a {
        text-decoration: none;
    }

    .category-header span {
        font-size: 20px;
        font-weight: bold;
        color: #0a58ca;
    }

    .category-container {
        width: 100%;
        padding: 15px;
        background-color: #fff;
        padding-right: calc(var(--bs-gutter-x)* .5);
        padding-left: calc(var(--bs-gutter-x)* .5);
        margin-right: auto;
        margin-left: auto;
        margin-bottom: 10px;
        border-radius: 8px;
    }

    .categories {
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        padding-left: 10px;
        padding-right: 10px;
        margin-bottom: 20px;
    }

    .categories span {
        font-size: 14px;
        color: #666;
        white-space: nowrap;
        padding: 3px 0;
    }

    .articles {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .article {
        display: flex;
        flex-direction: column;
        gap: 10px;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .article:hover {
        transform: translateY(-3px);
    }

    .article img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        object-fit: cover;
    }

    .badge {
        background: #2377b3;
        padding: 5px 10px;
        font-size: 12px;
        border-radius: 15px;
        align-self: flex-start;
        color: #ffff;
    }

    .article h3 {
        font-size: 16px;
        margin: 0;
        line-height: 1.4;
    }

    .article p {
        font-size: 14px;
        color: #6c757d;
        margin: 0;
    }

    .first-row {
        grid-column: span 2;
        display: flex;
        gap: 20px;
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .first-row img {
        width: 45%;
        max-width: 300px;
        height: auto;
        border-radius: 8px;
        object-fit: cover;
    }

    .first-row .text-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 10px;
        justify-content: center;
    }

    .post-link {
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        width: 100%;
        height: 100%;
    }

    .first-row .post-link {
        flex-direction: row;
        gap: 20px;
    }

    .article:hover,
    .first-row:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        transition: all 0.3s ease;
    }

    /* Cải thiện bố cục danh mục */
    .explore-categories {
        display: flex;
        flex-wrap: wrap;
        gap: 24px;
        justify-content: center;
    }

    .explore-item-wrapper {
        flex: 0 1 200px;
        text-align: center;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: transform 0.3s ease;
    }

    .explore-item-wrapper:hover {
        transform: scale(1.05);
    }

    /* Tăng kích thước hình ảnh và đảm bảo chúng không bị vỡ */
    .explore-icon {
        width: 150px;
        height: 150px;
        background-color: #f0f0f0;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .explore-icon img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    /* Thêm hiệu ứng khi hover lên hình ảnh */
    .explore-item-wrapper:hover .explore-icon img {
        transform: scale(1.1);

    }


    .explore-label {
        font-weight: bolder;
        font-size: 20px;
        color: #333;
        margin-top: 10px;
        display: block;
        transition: color 0.3s ease;
    }


    .explore-item-wrapper:hover .explore-label {
        color: #1e90ff;

    }


    @media (max-width: 768px) {
        .explore-item-wrapper {
            flex: 0 1 150px;

        }

        .explore-icon {
            width: 120px;
            height: 120px;
        }

        .explore-label {
            font-size: 14px;

        }
    }

    @media (max-width: 480px) {
        .explore-item-wrapper {
            flex: 0 1 120px;

        }

        .explore-icon {
            width: 100px;
            height: 100px;
        }
    }


    .explore-header {
        border-bottom: 2px solid #1565c0 !important;
    }

    .view-all-link {
        font-weight: bold;
        color: #1565c0;
        text-decoration: none;
    }



    /* Responsive cho tablet */
    @media (max-width: 992px) {
        .articles {
            grid-template-columns: repeat(2, 1fr);
        }

        .first-row {
            grid-column: span 2;
        }
    }

    /* Responsive cho điện thoại */
    @media (max-width: 768px) {
        .category-header {
            justify-content: center;
            text-align: center;
        }

        .categories {
            justify-content: center;
        }

        .articles {
            grid-template-columns: 1fr;
        }

        .first-row {
            grid-column: span 1;
            flex-direction: column;
        }

        .first-row img {
            width: 100%;
            max-width: 100%;
        }
    }

    /* Responsive cho điện thoại nhỏ */
    @media (max-width: 480px) {
        .category-header span {
            font-size: 18px;
        }

        .categories span {
            font-size: 13px;
        }

        .article {
            padding: 12px;
        }

        .article h3 {
            font-size: 15px;
        }

        .article p {
            font-size: 13px;
        }
    }
</style>
