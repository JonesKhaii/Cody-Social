@extends('layouts.master')

@section('title', 'Chi Tiết Bài Viết')

@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs bg-light py-2">
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
    <section class="blog-single section py-4">
        <div class="container">
            <div class="row g-4">
                <!-- Bài viết -->
                <div class="col-lg-8 col-12">
                    <div class="blog-single-main rounded bg-white shadow-sm">
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
                                <span class="d-flex align-items-center mb-2 me-3">
                                    <i class="fa fa-user me-1"></i> {{ $post->author_info->name ?? 'N/A' }}
                                </span>
                                <span class="d-flex align-items-center mb-2 me-3">
                                    <i class="fa fa-calendar me-1"></i> {{ $post->created_at->format('d M, Y') }}
                                </span>
                                <span class="d-flex align-items-center mb-2 me-3">
                                    <i class="fa fa-comments me-1"></i> {{ $post->comments->count() }} bình luận
                                </span>

                                <!-- Nút Like Bài Viết -->
                                <div class="d-flex align-items-center mb-2">
                                    <button
                                        class="btn like-btn {{ $post->isLikedBy(Auth::guard('web')->user() ?? Auth::guard('doctor')->user()) ? 'btn-success liked' : 'btn-primary' }} btn-sm me-2"
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

                            <!-- Chia sẻ mạng xã hội -->
                            <div class="share-social mb-4">
                                <h5 class="mb-3">Chia sẻ bài viết:</h5>
                                <div class="sharethis-inline-share-buttons"></div>
                            </div>

                            <!-- Tags -->
                            <div class="content-tags mb-4">
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
                        </div>

                        <!-- Bình luận -->
                        <div class="comments border-top px-4 py-4">
                            <h3 class="comment-title h4 mb-4">Bình luận ({{ $post->comments->count() }})</h3>

                            <!-- Hiển thị danh sách bình luận -->
                            <div class="comment-list">
                                @foreach ($post->comments->where('parent_id', null) as $comment)
                                    <div class="single-comment border-bottom mb-4 pb-4">
                                        <div class="d-flex">
                                            <div class="comment-avatar me-3">
                                                <img src="{{ asset($comment->user->photo ?? ($comment->doctor->photo ?? 'images/default-avatar.png')) }}"
                                                    alt="Avatar" class="rounded-circle" width="60"
                                                    height="60" style="object-fit: cover;">
                                            </div>
                                            <div class="comment-body flex-grow-1">
                                                <div class="comment-meta mb-2">
                                                    <span class="fw-bold">
                                                        {{ optional($comment->author_info)->name ?? 'Người dùng ẩn danh' }}
                                                    </span>
                                                    <span class="comment-date text-muted small ms-2">
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
                                            <div class="comment-replies ps-md-5 mt-3 ps-4">
                                                @foreach ($comment->replies as $reply)
                                                    <div class="single-comment border-bottom mb-3 pb-3">
                                                        <div class="d-flex">
                                                            <div class="comment-avatar me-3">
                                                                <img src="{{ asset($reply->author_info->photo ?? 'images/default-avatar.png') }}"
                                                                    alt="Avatar" class="rounded-circle"
                                                                    width="50" height="50"
                                                                    style="object-fit: cover;">
                                                            </div>
                                                            <div class="comment-body flex-grow-1">
                                                                <div class="comment-meta mb-2">
                                                                    <span class="fw-bold">
                                                                        {{ optional($reply->author_info)->name ?? 'Người dùng ẩn danh' }}
                                                                    </span>
                                                                    <span class="comment-date text-muted small ms-2">
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

                        <!-- Form bình luận -->
                        <div class="comment-form border-top px-4 py-4">
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
                                    <i class="fa fa-lock fa-2x text-muted mb-3"></i>
                                    <p class="mb-3">Bạn cần đăng nhập để bình luận</p>
                                    <a href="{{ route('login') }}" class="btn btn-primary me-2">Đăng nhập</a>
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary">Đăng ký</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4 col-12">
                    <div class="sidebar-sticky">
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
                                            <a href="#"
                                                class="text-decoration-none text-dark">{{ $cat->title }}</a>
                                            <span
                                                class="badge bg-primary rounded-pill">{{ $cat->posts_count ?? 0 }}</span>
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
                                    <div class="single-post border-bottom {{ $loop->last ? '' : 'border-bottom' }} p-3">
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
                                                        {{ \Illuminate\Support\Str::limit($post->title, 50) }}
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
        </div>
    </section>
    <!-- End Blog Single -->
@endsection

@section('scripts')
    <script>
        let likePostUrl = @json(route('post.like'));
        let csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/post.js') }}"></script>
@endsection

@push('styles')
    <style>
        /* Reset và cơ bản */
        body {
            background-color: #f8f9fa;
        }

        /* Breadcrumbs */
        .breadcrumbs {
            margin-bottom: 0;
            padding: 0.75rem 0;
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Blog Section */
        .blog-single.section {
            padding: 2rem 0;
        }

        /* Cấu trúc chính */
        .blog-single-main {
            border: 1px solid rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Row spacing */
        .row.g-4 {
            --bs-gutter-x: 1.5rem;
            --bs-gutter-y: 1.5rem;
        }

        /* Ảnh bài viết */
        .blog-single-main .image img {
            max-width: 100%;
            height: auto;
            object-fit: cover;
            max-height: 500px;
        }

        /* Nội dung bài viết */
        .blog-detail {
            padding: 1.5rem;
        }

        .blog-title {
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.3;
        }

        .blog-meta {
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        .content {
            font-size: 1rem;
            line-height: 1.7;
            color: #212529;
        }

        .content img {
            max-width: 100%;
            height: auto;
            margin: 1.5rem 0;
            border-radius: 0.25rem;
        }

        /* Thẻ và phần chia sẻ */
        .share-social,
        .content-tags {
            margin-bottom: 1.5rem;
        }

        .tag-inner a,
        .tag-cloud a {
            display: inline-block;
            background-color: #f8f9fa;
            color: #495057;
            padding: 0.35rem 0.75rem;
            border-radius: 2rem;
            font-size: 0.85rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            transition: all 0.2s ease;
        }

        .tag-inner a:hover,
        .tag-cloud a:hover {
            background-color: #e9ecef;
            color: #212529;
            text-decoration: none;
        }

        /* Phần bình luận */
        .comments {
            padding: 1.5rem;
            background-color: #fff;
        }

        .single-comment {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
        }

        .comment-avatar img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }

        .comment-meta {
            margin-bottom: 0.5rem;
        }

        .comment-date {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .comment-text {
            margin-bottom: 0.75rem;
            line-height: 1.5;
        }

        .comment-reply {
            margin-top: 0.5rem;
        }

        .comment-replies {
            padding-left: 3rem;
            margin-top: 1rem;
        }

        /* Form bình luận */
        .comment-form {
            padding: 1.5rem;
            background-color: #fff;
        }

        /* Sidebar */
        .sidebar-sticky {
            position: sticky;
            top: 0;
        }

        .card {
            margin-bottom: 1.5rem;
            border-radius: 0.375rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .card-header {
            padding: 1rem 1.25rem;
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }

        .card-title {
            font-weight: 600;
            margin-bottom: 0;
        }

        .card-body {
            padding: 1.25rem;
        }

        .list-group-item {
            padding: 0.75rem 1.25rem;
            border-left: none;
            border-right: none;
        }

        /* Bài viết sidebar */
        .single-post {
            padding: 1rem;
        }

        .single-post:last-child {
            border-bottom: none;
        }

        .single-post .image {
            border-radius: 0.25rem;
            overflow: hidden;
        }

        .single-post h5 {
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            line-height: 1.4;
        }

        /* Nút like */
        .like-btn {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
            transition: all 0.3s;
        }

        .liked {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }

        /* Đăng nhập để bình luận */
        .login-to-comment {
            padding: 2rem;
            text-align: center;
            border-radius: 0.375rem;
            background-color: #f8f9fa;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar-sticky {
                position: relative;
                top: 0;
            }
        }

        @media (max-width: 767.98px) {

            .blog-detail,
            .comments,
            .comment-form {
                padding: 1rem;
            }

            .comment-replies {
                padding-left: 1.5rem;
            }
        }

        .sidebar-sticky .card:first-child {
            margin-top: 0;
        }

        .py-4 {
            padding-top: 0 !important;
        }
    </style>
@endpush
