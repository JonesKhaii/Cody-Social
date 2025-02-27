@extends('layouts.master')

@section('title', 'Chi Tiết Bài Viết')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="bread-inner">
                        <ul class="bread-list d-flex align-items-center m-0 p-0" style="list-style: none;">
                            <li><a href="{{ route('home') }}" class="text-decoration-none">Trang chủ <i
                                        class="ti-arrow-right mx-2"></i></a></li>
                            <li class="active"><a href="javascript:void(0);"
                                    class="text-decoration-none text-muted">{{ $post->title }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <!-- Blog Single -->
    <section class="blog-single section py-5">
        <div class="container">
            <div class="row">
                <!-- Bài viết -->
                <div class="col-lg-8 col-12 mb-lg-0 mb-5">
                    <div class="blog-single-main rounded bg-white shadow-sm">
                        <div class="row">
                            <div class="col-12">
                                <div class="image position-relative">
                                    <img src="{{ asset($post->photo) }}" alt="{{ $post->title }}"
                                        class="img-fluid w-100 rounded-top">
                                    <div class="category-badge position-absolute" style="bottom: 15px; left: 15px;">
                                        <span class="badge bg-primary rounded-pill px-3 py-2">
                                            {{ $post->cat_info->title ?? 'Chưa phân loại' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="blog-detail p-4">
                                    <h1 class="blog-title h2 mb-3">{{ $post->title }}</h1>
                                    <div
                                        class="blog-meta d-flex align-items-center text-muted justify-content-between mb-4 flex-wrap">
                                        <span class="d-flex align-items-center">
                                            <i class="fa fa-user me-1"></i> {{ $post->author_info->name ?? 'N/A' }}
                                        </span>
                                        <span class="d-flex align-items-center">
                                            <i class="fa fa-calendar me-1"></i> {{ $post->created_at->format('d M, Y') }}
                                        </span>
                                        <span class="d-flex align-items-center">
                                            <i class="fa fa-comments me-1"></i> {{ $post->comments->count() }} bình luận
                                        </span>

                                        <!-- Nút Like Bài Viết -->
                                        <div class="d-flex align-items-center">
                                            <button
                                                class="btn like-btn {{ $post->isLikedBy(Auth::guard('web')->user() ?? Auth::guard('doctor')->user()) ? 'btn-success liked' : 'btn-primary' }} me-2"
                                                data-post-id="{{ $post->id }}">
                                                <i class="fas fa-thumbs-up"></i>
                                                <span class="like-text">
                                                    {{ $post->isLikedBy(Auth::guard('web')->user() ?? Auth::guard('doctor')->user()) ? 'Đã thích' : 'Like' }}
                                                </span>
                                            </button>
                                            <span class="like-count">{{ $post->likes->count() }}</span> lượt thích
                                        </div>

                                    </div>

                                    <div class="content lh-lg mb-4">
                                        {!! $post->description !!}
                                    </div>
                                </div>

                                <!-- Chia sẻ mạng xã hội -->
                                <div class="share-social px-4 pb-4">
                                    <h5 class="mb-3">Chia sẻ bài viết:</h5>
                                    <div class="sharethis-inline-share-buttons"></div>
                                </div>

                                <!-- Tags -->
                                <div class="content-tags px-4 pb-4">
                                    <h5 class="mb-3">Thẻ:</h5>
                                    <div class="tag-inner">
                                        @php
                                            $tags = explode(',', $post->tags);
                                        @endphp
                                        @foreach ($tags as $tag)
                                            <a href="javascript:void(0);"
                                                class="badge bg-light text-dark text-decoration-none mb-2 me-2 px-3 py-2">{{ trim($tag) }}</a>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Bình luận -->
                                <!-- Hiển thị bình luận -->
                                <div class="comments border-top mt-4 px-4 pb-4 pt-4">
                                    <h3 class="comment-title h4 mb-4">Bình luận ({{ $post->comments->count() }})</h3>

                                    <!-- Hiển thị danh sách bình luận -->
                                    <div class="comment-list">
                                        @foreach ($post->comments->where('parent_id', null) as $comment)
                                            <div class="single-comment border-bottom mb-4 pb-4">
                                                <div class="d-flex">
                                                    <div class="comment-avatar me-3">
                                                        <img src="{{ asset($comment->user->photo ?? ($comment->doctor->photo ?? 'images/default-avatar.png')) }}"
                                                            alt="Avatar" class="rounded-circle" width="60"
                                                            height="60">
                                                    </div>
                                                    <div class="comment-body flex-grow-1">
                                                        <div class="comment-meta mb-2">
                                                            <span class="fw-bold">
                                                                {{ optional($comment->author_info)->name ?? 'Người dùng ẩn danh' }}
                                                            </span>
                                                            <span class="comment-date text-muted small">
                                                                {{ $comment->created_at->format('d M, Y H:i') }}
                                                            </span>
                                                        </div>
                                                        <p class="comment-text mb-2">{{ $comment->comment }}</p>

                                                        <!-- Nút trả lời -->
                                                        <div class="comment-reply">
                                                            <a href="javascript:void(0);"
                                                                class="btn-reply reply text-primary small text-decoration-none"
                                                                data-id="{{ $comment->id }}">
                                                                <i class="fa fa-reply me-1"></i> Trả lời
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Hiển thị các trả lời -->
                                                @if ($comment->replies->count() > 0)
                                                    <div class="comment-replies mt-3 ps-5">
                                                        @foreach ($comment->replies as $reply)
                                                            <div class="single-comment border-bottom mb-3 pb-3">
                                                                <div class="d-flex">
                                                                    <div class="comment-avatar me-3">
                                                                        <img src="{{ asset($reply->author_info->photo ?? 'images/default-avatar.png') }}"
                                                                            alt="Avatar" class="rounded-circle"
                                                                            width="50" height="50">
                                                                    </div>
                                                                    <div class="comment-body flex-grow-1">
                                                                        <div class="comment-meta mb-2">
                                                                            <span class="fw-bold">
                                                                                {{ optional($reply->author_info)->name ?? 'Người dùng ẩn danh' }}
                                                                            </span>
                                                                            <span class="comment-date text-muted small">
                                                                                {{ $reply->created_at->format('d M, Y H:i') }}
                                                                            </span>
                                                                        </div>
                                                                        <p class="comment-text mb-0">
                                                                            {{ $reply->comment }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>


                            </div>

                            <!-- Form bình luận -->
                            <div class="comment-form px-4 pb-4 pt-2">
                                @if (Auth::guard('web')->check() || Auth::guard('doctor')->check())
                                    <div class="reply">
                                        <h4 class="reply-title mb-3">Để lại bình luận</h4>
                                        <form action="{{ route('post-comment.store', $post->slug) }}" method="POST"
                                            class="comment-form">
                                            @csrf
                                            <div class="form-group mb-3">
                                                <label class="mb-2">Bình luận<span class="text-danger">*</span></label>
                                                <textarea name="comment" rows="5" class="form-control" placeholder="Nhập bình luận của bạn..." required></textarea>
                                                <input type="hidden" name="post_id" value="{{ $post->id }}" />
                                                <input type="hidden" name="parent_id" id="parent_id" value="" />
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary px-4">Đăng bình
                                                    luận</button>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <div class="login-to-comment bg-light rounded p-4 text-center">
                                        <i class="fa fa-lock fa-2x text-muted mb-2"></i>
                                        <p class="mb-2">Bạn cần đăng nhập để bình luận</p>
                                        <a href="{{ route('login') }}" class="btn btn-primary me-2">Đăng nhập</a>
                                        <a href="{{ route('register') }}" class="btn btn-outline-primary">Đăng ký</a>
                                    </div>
                                @endif

                            </div>


                        </div>
                    </div>
                </div>


                <!-- Sidebar -->
                <div class="col-lg-4 col-12">
                    <!-- Tìm kiếm -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-body">
                            <form id="sidebarSearchForm" onsubmit="return false;">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Tìm kiếm..."
                                        id="sidebarSearchInput">
                                    <button class="btn btn-primary" type="button" id="sidebarSearchBtn">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </form>
                            <ul id="sidebarSearchResults" class="list-group mt-2" style="display: none;"></ul>
                        </div>
                    </div>



                    <!-- Danh mục -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h3 class="card-title h5 mb-0">Danh mục bài viết</h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @foreach ($categories as $cat)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="#" class="text-decoration-none text-dark">{{ $cat->title }}</a>
                                        <span class="badge bg-primary rounded-pill">{{ $cat->posts_count ?? 0 }}</span>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>

                    <!-- Bài viết gần đây -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h3 class="card-title h5 mb-0">Bài viết gần đây</h3>
                        </div>
                        <div class="card-body p-0">
                            @foreach ($recent_posts as $post)
                                <div class="single-post border-bottom p-3">
                                    <div class="row g-0">
                                        <div class="col-3">
                                            <div class="image ratio ratio-1x1">
                                                <img src="{{ asset($post->photo) }}" alt="{{ $post->title }}"
                                                    class="object-fit-cover rounded">
                                            </div>
                                        </div>
                                        <div class="col-9 ps-3">
                                            <h5 class="fs-6 mb-1">
                                                <a href="{{ route('post.detail', ['slug' => $post->slug]) }}"
                                                    class="text-decoration-none text-dark">
                                                    {{ Str::limit($post->title, 50) }}
                                                </a>
                                            </h5>
                                            <div class="small text-muted">
                                                <i class="fa fa-calendar me-1"></i>
                                                {{ $post->created_at->format('d M, Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Widget: Thẻ phổ biến -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h3 class="card-title h5 mb-0">Thẻ phổ biến</h3>
                        </div>
                        <div class="card-body">
                            <div class="tag-cloud">
                                @php
                                    $all_tags = [];
                                    foreach ($recent_posts as $post) {
                                        $post_tags = explode(',', $post->tags);
                                        foreach ($post_tags as $tag) {
                                            $tag = trim($tag);
                                            if (!empty($tag)) {
                                                $all_tags[] = $tag;
                                            }
                                        }
                                    }
                                    $all_tags = array_unique($all_tags);
                                @endphp

                                @foreach ($all_tags as $tag)
                                    <a href="javascript:void(0);"
                                        class="badge bg-light text-dark text-decoration-none mb-2 me-2 px-3 py-2">{{ $tag }}</a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Blog Single -->
    <script>
        $(document).ready(function() {
            $('.like-btn').click(function() {
                let postId = $(this).data('post-id');
                let button = $(this);
                let likeCount = button.siblings('.like-count');

                $.ajax({
                    url: "{{ route('post.like') }}",
                    type: "POST",
                    data: {
                        post_id: postId,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.liked) {
                            button.addClass('btn-success liked').removeClass('btn-primary');
                            button.find('.like-text').text('Đã thích');
                            likeCount.text(parseInt(likeCount.text()) + 1);
                        } else {
                            button.addClass('btn-primary').removeClass('btn-success liked');
                            button.find('.like-text').text('Like');
                            likeCount.text(parseInt(likeCount.text()) - 1);
                        }
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON.error);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Xử lý tìm kiếm khi nhấn nút
            $('#sidebarSearchBtn').click(function() {
                let query = $('#sidebarSearchInput').val().trim();
                if (query.length >= 2) {
                    // Chuyển hướng đến trang kết quả tìm kiếm
                    window.location.href = "/search-results?q=" + encodeURIComponent(query);
                }
            });

            // Xử lý tìm kiếm khi nhập từ bàn phím (Hiển thị gợi ý)
            $('#sidebarSearchInput').on('input', function() {
                let query = $(this).val().trim();
                if (query.length >= 2) {
                    performSidebarSearch(query);
                } else {
                    $('#sidebarSearchResults').hide();
                }
            });

            function performSidebarSearch(query) {
                $.ajax({
                    url: "{{ route('search') }}",
                    method: 'GET',
                    data: {
                        q: query
                    },
                    dataType: 'json',
                    success: function(data) {
                        let resultsBox = $('#sidebarSearchResults');
                        resultsBox.empty().show();

                        if (data.results.length > 0) {
                            data.results.forEach(function(post) {
                                resultsBox.append(`
                            <li class="list-group-item">
                                <a href="/post/${post.slug}" class="text-decoration-none text-dark">${post.title}</a>
                            </li>
                        `);
                            });

                            // Thêm nút "Xem tất cả kết quả"
                            resultsBox.append(`
                        <li class="list-group-item text-center">
                            <a href="/search-results?q=${encodeURIComponent(query)}" class="btn btn-sm btn-secondary w-100">
                                Xem tất cả kết quả
                            </a>
                        </li>
                    `);

                        } else {
                            resultsBox.append(
                                '<li class="list-group-item text-muted">Không tìm thấy kết quả.</li>'
                            );
                        }
                    },
                    error: function() {
                        $('#sidebarSearchResults').hide();
                    }
                });
            }
        });
    </script>
@endsection

@push('styles')
    <style>
        .blog-single-main {
            overflow: hidden;
        }

        .blog-single-main img {
            max-width: 100%;
            height: auto;
        }

        .content img {
            max-width: 100%;
            height: auto;
            margin: 1rem 0;
        }

        .comment-avatar img {
            object-fit: cover;
        }

        .tag-cloud a:hover {
            background-color: #f0f0f0 !important;
        }

        .like-btn {
            transition: all 0.3s ease;
        }

        .liked {
            background-color: #28a745 !important;
            /* Xanh lá cây */
            border-color: #28a745 !important;
        }
    </style>
@endpush

@push('scripts')
    <script type="text/javascript"
        src="https://platform-api.sharethis.com/js/sharethis.js#property=YOUR_PROPERTY_ID&product=inline-share-buttons"
        async="async"></script>
    <script>
        $(document).ready(function() {
            $('.btn-reply').on('click', function() {
                let commentId = $(this).data('id');
                $('#parent_id').val(commentId);
                $('#replied_comment').val($(this).closest('.single-comment').find('.comment-text').text());
                $('html, body').animate({
                    scrollTop: $(".comment-form").offset().top - 100
                }, 500);
            });
        });
    </script>
@endpush
