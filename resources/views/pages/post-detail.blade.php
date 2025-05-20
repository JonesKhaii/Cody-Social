<!-- CSS Style cho trang chi tiết bài viết -->


<!-- HTML Structure cho trang chi tiết bài viết -->
@extends('layouts.master')

@section('title', $post->title)
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/post-detail.css') }}">
@endsection
@section('main-content')
    <!-- Breadcrumbs -->
    <div class="breadcrumbs py-2">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="bread-list">
                        <li><a href="{{ route('home') }}">Trang chủ <i class="fas fa-chevron-right mx-2"></i></a></li>
                        <li><a href="">Bài viết <i class="fas fa-chevron-right mx-2"></i></a></li>
                        <li class="active"><a href="javascript:void(0);">{{ $post->title }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Breadcrumbs -->

    <div class="blog-single-container">
        <div class="row">
            <!-- Bài viết -->
            <div class="col-lg-8 col-12">
                <!-- Card bài viết chính -->
                <div class="blog-article-card">
                    <div class="blog-header">
                        <div class="blog-category-badge">
                            <a href="{{ route('category.show', ['slug' => $post->cat_info->slug ?? 'uncategorized']) }}"
                                class="category-badge">
                                {{ $post->cat_info->title ?? 'Chưa phân loại' }}
                            </a>
                        </div>
                        <img src="{{ asset($post->photo) }}" alt="{{ $post->title }}" class="blog-featured-image">
                    </div>

                    <div class="blog-content-wrapper">
                        <h1 class="blog-title">{{ $post->title }}</h1>

                        <div class="blog-meta">
                            <div class="blog-meta-item author">
                                <i class="fas fa-user"></i>
                                {{ $post->author_info->name ?? 'Admin' }}

                            </div>
                            <div class="blog-meta-item">
                                <i class="fa-solid fa-calendar"></i>
                                {{ $post->created_at->format('d M, Y') }}
                            </div>
                            <div class="blog-meta-item">
                                <i class="fas fa-eye"></i>
                                {{ $post->views }} lượt xem
                            </div>
                            <div class="blog-meta-item">
                                <i class="fas fa-comments"></i>
                                {{ count($post->comments) }} bình luận
                            </div>

                            <div class="blog-like-button">
                                <button
                                    class="like-btn {{ $post->isLikedBy(Auth::guard('web')->user() ?? Auth::guard('doctor')->user()) ? 'liked' : '' }}"
                                    data-post-id="{{ $post->id }}">
                                    <i class="fas fa-thumbs-up"></i>
                                    <span class="like-text">
                                        {{ $post->isLikedBy(Auth::guard('web')->user() ?? Auth::guard('doctor')->user()) ? 'Đã thích' : 'Thích' }}
                                    </span>
                                </button>
                                <span class="like-count">{{ $post->likes->count() }}</span> lượt thích
                            </div>
                        </div>

                        @if ($post->post_type == 'video' && isset($post->meta_data['video_url']))
                            <div class="blog-video-container mb-4">
                                @php
                                    // Xử lý URL video từ YouTube
                                    $videoUrl = $post->meta_data['video_url'];
                                    $embedUrl = '';
                                    if (strpos($videoUrl, 'youtube.com') !== false) {
                                        preg_match(
                                            '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/',
                                            $videoUrl,
                                            $matches,
                                        );
                                        if (isset($matches[1])) {
                                            $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                        }
                                    } elseif (strpos($videoUrl, 'youtu.be') !== false) {
                                        preg_match('/youtu\.be\/([^"&?\/\s]{11})/', $videoUrl, $matches);
                                        if (isset($matches[1])) {
                                            $embedUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                        }
                                    } elseif (strpos($videoUrl, 'vimeo.com') !== false) {
                                        preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $matches);
                                        if (isset($matches[1])) {
                                            $embedUrl = 'https://player.vimeo.com/video/' . $matches[1];
                                        }
                                    }
                                @endphp

                                @if ($embedUrl)
                                    <div class="responsive-video">
                                        <iframe src="{{ $embedUrl }}" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                    </div>

                                    @if (isset($post->meta_data['duration']))
                                        <div class="video-duration mt-2">
                                            <i class="fas fa-clock"></i> Thời lượng: {{ $post->meta_data['duration'] }}
                                        </div>
                                    @endif
                                @else
                                    <div class="alert alert-warning">
                                        URL video không hợp lệ hoặc không được hỗ trợ.
                                    </div>
                                @endif
                            </div>
                        @endif

                        <div class="blog-content">
                            {!! $post->description !!}
                        </div>

                        <div class="blog-article-footer">
                            <!-- Chia sẻ mạng xã hội -->
                            <div class="blog-share">
                                <h5>Chia sẻ bài viết:</h5>
                                <div class="sharethis-inline-share-buttons"></div>
                            </div>

                            <!-- Tags -->
                            <div class="blog-tags">
                                <h5>Thẻ:</h5>
                                <div class="tag-inner">
                                    @php
                                        $tags = explode(',', $post->tags);
                                    @endphp
                                    @foreach ($tags as $tag)
                                        <a href="javascript:void(0);">{{ trim($tag) }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="author-section">
                    <h3 class="section-title">Về tác giả </h3>
                    <div class="author-box">
                        <div class="author-image">
                            <img src="{{ asset($post->author_info->photo ?? 'images/default-avatar.png') }}"
                                alt="Author">

                        </div>
                        <div class="author-bio">
                            <p>
                                {{ $post->author_info->short_bio ?? 'Chuyên gia y tế với nhiều năm kinh nghiệm trong lĩnh vực chăm sóc sức khỏe.' }}

                            </p>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="post-tags">
                        <h3 class="section-title">Tags</h3>
                        <div class="tags-list">
                            <a href="#" class="tag-item">Health Tips</a>
                            <a href="#" class="tag-item">Awareness</a>
                            <a href="#" class="tag-item">Health</a>
                            <a href="#" class="tag-item">Wellness</a>
                        </div>
                    </div>
                </div>

                <!-- Phần bình luận -->
                <div class="blog-comments-section">
                    <h3 class="comment-title">Bình luận ({{ count($post->comments) }})</h3>

                    <!-- Danh sách bình luận -->
                    <div class="comment-list">
                        @foreach ($post->comments->where('parent_id', null) as $comment)
                            <div class="single-comment border-bottom mb-4 pb-4" id="comment-{{ $comment->id }}">
                                <div class="d-flex">
                                    <div class="comment-avatar me-3">
                                        <img src="{{ asset($comment->user->photo ?? ($comment->doctor->photo ?? 'images/default-avatar.png')) }}"
                                            alt="Avatar">
                                    </div>
                                    <div class="comment-body">
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
                                            <a href="javascript:void(0);" class="btn-reply reply"
                                                data-id="{{ $comment->id }}">
                                                <i class="fas fa-reply me-1"></i> Trả lời
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Hiển thị các trả lời -->
                                @if ($comment->replies->count() > 0)
                                    <div class="comment-replies ms-md-5 ms-4 mt-3">
                                        @foreach ($comment->replies as $reply)
                                            <div class="single-comment border-bottom mb-3 pb-3"
                                                id="comment-{{ $reply->id }}">
                                                <div class="d-flex">
                                                    <div class="comment-avatar me-3">
                                                        <img src="{{ asset($reply->author_photo) }}" alt="Avatar">
                                                    </div>
                                                    <div class="comment-body">
                                                        <div class="comment-meta mb-2">
                                                            <span class="fw-bold">
                                                                {{ optional($reply->author_info)->name ?? 'Người dùng ẩn danh' }}
                                                            </span>
                                                            <span class="comment-date text-muted small ms-2">
                                                                {{ $reply->created_at->format('d M, Y H:i') }}
                                                            </span>
                                                        </div>
                                                        <p class="comment-text mb-0">{{ $reply->comment }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endforeach

                        @if ($post->comments->where('parent_id', null)->count() == 0)
                            <div class="no-comments py-4 text-center">
                                <i class="far fa-comment-dots fa-3x text-muted mb-3"></i>
                                <p>Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Form bình luận -->
                <div class="comment-form-container">
                    @if (Auth::guard('web')->check() || Auth::guard('doctor')->check())
                        <h4 class="reply-title">Để lại bình luận</h4>
                        <form action="{{ route('post-comment.store', $post->slug) }}" method="POST"
                            class="comment-form">
                            @csrf
                            <div class="form-group">
                                <label class="mb-2">Bình luận<span class="text-danger">*</span></label>
                                <textarea name="comment" rows="5" class="form-control" placeholder="Nhập bình luận của bạn..." required></textarea>
                                <input type="hidden" name="post_id" value="{{ $post->id }}" />
                                <input type="hidden" name="parent_id" id="parent_id" value="" />
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary px-4">Đăng bình luận</button>
                            </div>
                        </form>
                    @else
                        <div class="login-to-comment">
                            <i class="fas fa-lock fa-3x"></i>
                            <p>Bạn cần đăng nhập để bình luận</p>
                            <a href="{{ route('login') }}" class="btn btn-primary me-2">Đăng nhập</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary">Đăng ký</a>
                        </div>
                    @endif
                </div>

            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 col-12">
                <div class="blog-sidebar">
                    <!-- Tìm kiếm -->
                    <div class="card">
                        <div class="card-body">
                            <form id="sidebarSearchForm" onsubmit="return false;">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Tìm kiếm..."
                                        id="sidebarSearchInput">
                                    <button class="btn btn-primary" type="button" id="sidebarSearchBtn">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                            <ul id="sidebarSearchResults" class="list-group mt-2" style="display: none;"></ul>
                        </div>
                    </div>

                    <!-- Danh mục -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh mục bài viết</h3>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @foreach ($categories as $cat)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a
                                            href="{{ route('category.show', ['slug' => $cat->slug]) }}">{{ $cat->title }}</a>
                                        <span class="badge bg-primary rounded-pill">{{ $cat->posts_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Bài viết gần đây -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Bài viết gần đây</h3>
                        </div>
                        <div class="card-body">
                            @foreach ($recent_posts as $recent_post)
                                <div class="single-post {{ $loop->last ? '' : 'border-bottom' }}">
                                    <div class="image">
                                        <img src="{{ asset($recent_post->photo) }}" alt="{{ $recent_post->title }}">
                                    </div>
                                    <div class="content">
                                        <h5>
                                            <a href="{{ route('post.detail', ['slug' => $recent_post->slug]) }}">
                                                {{ \Illuminate\Support\Str::limit($recent_post->title, 50) }}
                                            </a>
                                        </h5>
                                        <div class="small">
                                            <i class="fas fa-calendar-alt me-1"></i>
                                            {{ $recent_post->created_at->format('d M, Y') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Widget: Thẻ phổ biến -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Thẻ phổ biến</h3>
                        </div>
                        <div class="card-body">
                            <div class="tag-cloud">
                                @foreach ($post_tags as $tag)
                                    <a href="javascript:void(0);" class="tag-item">{{ $tag }}</a>
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
    <script>
        let likePostUrl = @json(route('post.like'));
        let csrfToken = "{{ csrf_token() }}";
    </script>
    <script src="{{ asset('js/post.js') }}"></script>
@endsection
