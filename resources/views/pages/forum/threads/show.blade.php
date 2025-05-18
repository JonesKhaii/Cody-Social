@extends('layouts.master')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/forum-show.css') }}">
@endsection
@section('main-content')
    <div class="forum-wrapper">
        <div class="container">
            <div class="row">
                <!-- LEFT COLUMN - THREAD INFO -->
                <div class="col-lg-9">
                    <div class="forum-main">
                        <!-- Breadcrumb -->
                        <div class="forum-breadcrumb">
                            <a href="{{ route('forum.index') }}">Diễn đàn</a>
                            <span class="separator">/</span>
                            <a href="{{ route('forum.category', $category->slug) }}">{{ $category->name }}</a>
                            <span class="separator">/</span>
                            <span class="current">{{ $thread->title }}</span>
                        </div>

                        <!-- Thread header -->
                        <div class="thread-header">
                            <h1 class="thread-title" id="thread-title-display">
                                @if ($thread->is_sticky)
                                    <span class="thread-badge sticky">Ghim</span>
                                @endif
                                @if ($thread->is_locked)
                                    <span class="thread-badge locked">Khóa</span>
                                @endif
                                {{ $thread->title }}
                            </h1>

                            <div class="thread-meta">
                                <div class="meta-item author">
                                    <img src="{{ $thread->user->photo ?? asset('images/avatar-placeholder.png') }}"
                                        class="avatar" alt="{{ $thread->user->name }}">
                                    <span>{{ $thread->user->name }}</span>
                                </div>
                                <div class="meta-item date">
                                    <i class="fas fa-calendar-alt"></i>
                                    {{ \Carbon\Carbon::parse($thread->created_at)->format('d/m/Y H:i') }}
                                </div>
                                <div class="meta-stats">
                                    <span><i class="fas fa-eye"></i> {{ number_format($thread->view_count) }}</span>
                                    <span><i class="fas fa-comment-alt"></i>
                                        {{ number_format($thread->reply_count) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Thread content -->
                        <div class="thread-content" id="thread-content-display">
                            {!! $thread->content !!}
                        </div>

                        <!-- Thread actions -->
                        <div class="thread-actions">
                            @if ((Auth::check() && Auth::id() == $thread->user_id) || (Auth::check() && Auth::user()->role === 'admin'))
                                <a href="#"
                                    class="btn-action edit"
                                    id="edit-thread-trigger"
                                    data-title="{{ $thread->title }}"
                                    data-content="{{ htmlentities($thread->content) }}">
                                    <i class="fas fa-edit"></i> Sửa
                                </a>
                                <button type="button"
                                    class="btn-delete-thread"
                                    data-url="{{ route('forum.threads.destroy', [$category->slug, $thread->slug]) }}">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </button>
                            @endif

                            <button class="btn-action share" id="shareButton">
                                <i class="fas fa-share-alt"></i> Chia sẻ
                            </button>
                        </div>

                        <!-- Posts/Comments -->
                        <div class="posts-container" id="comments-container">

                            <h3 class="posts-heading">Bình luận ({{ count($posts) }})</h3>

                            @forelse($posts as $post)
                                <div class="post-item" id="post-{{ $post->id }}">
                                    <div class="post-author">
                                        <div class="author-avatar">
                                            <img src="{{ $post->user->photo ?? asset('images/avatar-placeholder.png') }}"
                                                alt="{{ $post->user->name }}">
                                        </div>
                                        <div class="author-name">{{ $post->user->name }}</div>
                                        <div class="post-date">
                                            {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y H:i') }}</div>
                                    </div>

                                    <div class="post-body">
                                        <div class="post-content">
                                            {!! $post->content !!}
                                        </div>

                                        <div class="post-actions">
                                            <div class="post-likes">
                                                @php
                                                    if (Auth::guard('web')->check()) {
                                                        $userId = Auth::id();
                                                        $guardName = 'web';
                                                    } elseif (Auth::guard('doctor')->check()) {
                                                        $userId = Auth::guard('doctor')->id();
                                                        $guardName = 'doctor';
                                                    }

                                                    $hasLiked = false;
                                                    if (isset($userId)) {
                                                        $hasLiked = DB::table('forum_post_likes')
                                                            ->where('post_id', $post->id)
                                                            ->where('user_id', $userId)
                                                            ->where('guard_name', $guardName)
                                                            ->exists();
                                                    }
                                                @endphp

                                                @if (Auth::guard('web')->check() || Auth::guard('doctor')->check())
                                                    <button class="btn-like {{ $hasLiked ? 'liked' : '' }}"
                                                        data-post-id="{{ $post->id }}">
                                                        <i class="fas fa-thumbs-up"></i>
                                                        <span class="like-count">{{ $post->like_count }}</span>
                                                    </button>
                                                @else
                                                    <span><i class="fas fa-thumbs-up"></i> {{ $post->like_count }}</span>
                                                @endif
                                            </div>

                                            <div class="post-buttons">
                                                @if (Auth::guard('web')->check() || Auth::guard('doctor')->check())
                                                    <button class="btn-reply" data-post-id="{{ $post->id }}">
                                                        <i class="fas fa-reply"></i> Trả lời
                                                    </button>

                                                    @if ((Auth::check() && Auth::id() == $post->user_id) || (Auth::check() && Auth::user()->role === 'admin'))
                                                        <a href="{{ route('forum.posts.edit', [$category->slug, $thread->slug, $post->id]) }}"
                                                            class="btn-edit inline-edit-btn"
                                                            data-post-id="{{ $post->id }}"
                                                            data-content="{{ e($post->content) }}">
                                                            <i class="fas fa-edit"></i> Sửa
                                                        </a>


                                                        <form
                                                            action="{{ route('forum.posts.destroy', [$category->slug, $thread->slug, $post->id]) }}"
                                                            method="POST" class="d-inline delete-form"
                                                            data-post-id="{{ $post->id }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn-delete"><i
                                                                    class="fas fa-trash-alt"></i> Xóa</button>
                                                        </form>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Nested replies -->
                                        @if ($post->replies && $post->replies->count() > 0)
                                            <div class="post-replies">
                                                @foreach ($post->replies as $reply)
                                                    <div class="reply-item" id="reply-{{ $reply->id }}">
                                                        <div class="reply-author">
                                                            <div class="author-avatar">
                                                                <img src="{{ $reply->user->photo ?? asset('images/avatar-placeholder.png') }}"
                                                                    alt="{{ $reply->user->name }}">
                                                            </div>
                                                            <div class="author-info">
                                                                <div class="author-name">{{ $reply->user->name }}</div>
                                                                <div class="reply-date">
                                                                    {{ \Carbon\Carbon::parse($reply->created_at)->format('d/m/Y H:i') }}
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="reply-content">
                                                            {!! $reply->content !!}
                                                        </div>

                                                        <div class="reply-actions">
                                                            <div class="reply-likes">
                                                                @php
                                                                    if (Auth::guard('web')->check()) {
                                                                        $userId = Auth::id();
                                                                        $guardName = 'web';
                                                                    } elseif (Auth::guard('doctor')->check()) {
                                                                        $userId = Auth::guard('doctor')->id();
                                                                        $guardName = 'doctor';
                                                                    }

                                                                    $hasLiked = false;
                                                                    if (isset($userId)) {
                                                                        $hasLiked = DB::table('forum_post_likes')
                                                                            ->where('post_id', $reply->id)
                                                                            ->where('user_id', $userId)
                                                                            ->where('guard_name', $guardName)
                                                                            ->exists();
                                                                    }
                                                                @endphp

                                                                @if (Auth::guard('web')->check() || Auth::guard('doctor')->check())
                                                                    <button class="btn-like {{ $hasLiked ? 'liked' : '' }}"
                                                                        data-post-id="{{ $reply->id }}">
                                                                        <i class="fas fa-thumbs-up"></i>
                                                                        <span
                                                                            class="like-count">{{ $reply->like_count }}</span>
                                                                    </button>
                                                                @else
                                                                    <span><i class="fas fa-thumbs-up"></i>
                                                                        {{ $reply->like_count }}</span>
                                                                @endif
                                                            </div>

                                                            @if ((Auth::check() && Auth::id() == $reply->user_id) || (Auth::check() && Auth::user()->role === 'admin'))
                                                                <div class="reply-buttons">
                                                                    <a href="{{ route('forum.posts.edit', [$category->slug, $thread->slug, $reply->id]) }}"
                                                                        class="btn-edit inline-edit-btn"
                                                                        data-post-id="{{ $reply->id }}"
                                                                        data-content="{{ e($reply->content) }}">
                                                                        <i class="fas fa-edit"></i> Sửa
                                                                    </a>



                                                                    <form
                                                                        action="{{ route('forum.posts.destroy', [$category->slug, $thread->slug, $reply->id]) }}"
                                                                        method="POST" class="d-inline"
                                                                        onsubmit="return confirm('Bạn có chắc chắn muốn xóa phản hồi này?');">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn-delete">
                                                                            <i class="fas fa-trash-alt"></i> Xóa
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <!-- Reply form (hidden by default) -->
                                        @if (Auth::guard('web')->check() || Auth::guard('doctor')->check())
                                            <div class="reply-form" id="reply-form-{{ $post->id }}"
                                                style="display: none;">
                                                <form class="reply-form-element" data-post-id="{{ $post->id }}"
                                                    data-action="{{ route('forum.posts.store', [$category->slug, $thread->slug]) }}">
                                                    @csrf
                                                    <input type="hidden" name="parent_id" value="{{ $post->id }}">
                                                    <div class="form-group">
                                                        <textarea name="content" rows="3" class="form-control" placeholder="Nhập phản hồi của bạn..." required></textarea>
                                                    </div>
                                                    <div class="form-buttons">
                                                        <button type="submit" class="btn-submit">Gửi phản hồi</button>
                                                        <button type="button" class="btn-cancel"
                                                            data-post-id="{{ $post->id }}">Hủy</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="empty-posts">
                                    <div class="empty-icon">
                                        <i class="fas fa-comments"></i>
                                    </div>
                                    <p>Chưa có bình luận nào. Hãy là người đầu tiên bình luận!</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Comment form -->
                        <div class="comment-form">
                            <h3>Để lại bình luận</h3>

                            @if (Auth::guard('web')->check() || Auth::guard('doctor')->check())
                                <!-- Người dùng đã đăng nhập -->
                                <form id="comment-form"
                                    action="{{ route('forum.posts.store', [$category->slug, $thread->slug]) }}"
                                    method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <textarea name="content" rows="5" class="form-control" placeholder="Nhập bình luận của bạn..." required
                                            id="comment-content"></textarea>

                                    </div>
                                    <button type="submit" class="btn-submit">Gửi bình luận</button>
                                </form>
                            @else
                                <!-- Người dùng chưa đăng nhập -->
                                <div class="login-notice">
                                    <p>Bạn cần <a href="{{ route('login') }}">đăng nhập</a> hoặc <a
                                            href="{{ route('register') }}">đăng ký</a> để bình luận.</p>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

                <!-- RIGHT COLUMN - RELATED -->
                <div class="col-lg-3">
                    <div class="forum-sidebar">
                        <!-- Thread Author -->
                        <div class="sidebar-block author-block">
                            <h3 class="block-title">Tác giả</h3>
                            <div class="author-info">
                                <div class="author-avatar">
                                    <img src="{{ $thread->user->photo ?? asset('images/avatar-placeholder.png') }}"
                                        alt="{{ $thread->user->name }}">
                                </div>
                                <h4 class="author-name">{{ $thread->user->name }}</h4>
                                <div class="author-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-alt"></i> Tham gia:
                                        {{ \Carbon\Carbon::parse($thread->user->created_at)->format('d/m/Y') }}
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-comment-dots"></i> Bài viết:
                                        {{ $thread->user->posts_count ?? 0 }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Related Threads -->
                        <div class="sidebar-block related-block">
                            <h3 class="block-title">Chủ đề liên quan</h3>
                            <!-- Phần tiếp theo của related-block -->
                            <div class="related-threads">
                                @php
                                    $relatedThreads = \App\Models\ForumThread::where('category_id', $category->id)
                                        ->where('id', '!=', $thread->id)
                                        ->orderBy('view_count', 'desc')
                                        ->limit(5)
                                        ->get();
                                @endphp

                                @if ($relatedThreads->count() > 0)
                                    <ul class="related-list">
                                        @foreach ($relatedThreads as $relatedThread)
                                            <li>

                                                <a
                                                    href="{{ route('forum.threads.show', [$category->slug, $relatedThread->slug]) }}">
                                                    <span
                                                        class="thread-title">{{ Str::limit($relatedThread->title, 40) }}</span>
                                                    <div class="thread-meta">
                                                        <span><i class="fas fa-eye"></i>
                                                            {{ $relatedThread->view_count }}</span>
                                                        <span><i class="fas fa-comment"></i>
                                                            {{ $relatedThread->reply_count }}</span>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <div class="no-threads">Không có chủ đề liên quan</div>
                                @endif
                            </div>
                        </div>

                        <!-- Share Options -->
                        <div class="sidebar-block share-block">
                            <h3 class="block-title">Chia sẻ chủ đề</h3>
                            <div class="share-options">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                    target="_blank" class="share-btn facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($thread->title) }}"
                                    target="_blank" class="share-btn twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="mailto:?subject={{ urlencode($thread->title) }}&body={{ urlencode('Đọc chủ đề này: ' . request()->url()) }}"
                                    class="share-btn email">
                                    <i class="fas fa-envelope"></i>
                                </a>
                                <button class="share-btn copy" id="copyLinkBtn" data-url="{{ request()->url() }}">
                                    <i class="fas fa-link"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Category Navigation -->
                        <div class="sidebar-block category-nav-block">
                            <h3 class="block-title">Điều hướng danh mục</h3>
                            <div class="category-nav">
                                <a href="{{ route('forum.category', $category->slug) }}" class="nav-btn">
                                    <i class="fas fa-list"></i> Xem tất cả chủ đề
                                </a>
                                <a href="{{ route('forum.threads.create', $category->slug) }}" class="nav-btn">
                                    <i class="fas fa-plus-circle"></i> Tạo chủ đề mới
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.FORUM_DATA = {
            csrfToken: '{{ csrf_token() }}',
            categorySlug: '{{ $category->slug }}',
            threadSlug: '{{ $thread->slug }}',
            currentUserPhoto: '{{ Auth::user()->photo ?? asset('images/avatar-placeholder.png') }}',
            currentUserName: '{{ Auth::user()->name ?? 'Bạn' }}'
        };
    </script>

    <script src="{{ asset('js/forum-show.js') }}" defer></script>

@endsection
