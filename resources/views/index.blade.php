@extends('layouts.master')

@section('title', 'Trang Chủ')

@section('main-content')
    <div class="container-fluid mt-4">
        <div class="container">
            <!-- Banner -->
            <div class="row mb-3 text-center" id="bannerRow">
                <div class="col-md-3"><img src="{{ asset('asset/images/banners/banner1.webp') }}" class="small-banner"
                        alt="Khuyến mãi dịch vụ y tế" /></div>
                <div class="col-md-3"><img src="{{ asset('asset/images/banners/banner2.webp') }}" class="small-banner"
                        alt="Tư vấn sức khỏe miễn phí" /></div>
                <div class="col-md-3"><img src="{{ asset('asset/images/banners/banner3.webp') }}" class="small-banner"
                        alt="Lịch khám ưu đãi tháng này" /></div>
                <div class="col-md-3"><img src="{{ asset('asset/images/banners/banner4.webp') }}" class="small-banner"
                        alt="Tầm soát bệnh lý sớm" /></div>
            </div>

            <!-- Ô tìm kiếm với nút tìm kiếm và dropdown gợi ý -->
            <div class="search-container" style="position: relative;">
                <form class="nosubmit" onsubmit="return false;">
                    <div class="input-group">
                        <input
                            type="text"
                            class="form-control"
                            id="Pesquisar"
                            placeholder="Tìm kiếm từ khóa, tên bài viết, tác giả"
                            autocomplete="off" />
                        <button class="btn btn-primary" type="button" id="searchBtn">
                            <i class="fas fa-search"></i> Tìm kiếm
                        </button>
                    </div>
                </form>
                <!-- Dropdown suggestion box -->
                <ul id="autocompleteDropdown" class="dropdown-menu"
                    style="display: none; position: absolute; width: 100%; z-index: 1000;"></ul>
            </div>


            <!-- Tiêu đề và bộ lọc -->
            <div class="row mt-3">
                <div class="col-6">
                    <h1>Thông Tin Y Tế Nổi Bật</h1>
                </div>
                {{-- <div class="col-6 text-end">
                    <select class="btn btn-light" id="Genero">
                        <option value="">Tất cả</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->title }}">{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div> --}}
                <div class="col-12 col-md-6">
                    <div class="d-flex justify-content-md-end">
                        <select class="form-select filter-select" id="Genero" aria-label="Lọc theo danh mục">
                            <option value="">Tất cả danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->title }}">{{ $category->title }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <!-- Danh sách bài viết -->
            <div class="container mt-5" id="postsContainer">
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
                        {{-- @foreach ($category->subcategories->take(5) as $subcategory)
                            <span>{{ $subcategory->title }}</span>
                        @endforeach --}}
                    </div>

                    <div class="articles">
                        @php
                            $posts = $category->posts()->latest()->take(5)->get();
                            $firstPost = $posts->shift();
                        @endphp

                        {{-- @if ($firstPost)
                            <div class="first-row">
                                <a href="{{ route('post.detail', $firstPost->slug) }}" class="post-link">
                                    <img src="{{ asset($firstPost->photo) }}" alt="{{ $firstPost->title }}" />
                                    <div class="text-content">
                                        <span class="badge">{{ $category->title }}</span>
                                        <h3>{{ $firstPost->title }}</h3>
                                        <p>{{ Str::limit($firstPost->summary, 100) }}</p>
                                    </div>
                                </a>
                            </div>
                        @endif --}}
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
                                    <p class="text-muted mb-0">{{ $doctor->field }}</p>
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
