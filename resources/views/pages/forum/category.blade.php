@extends('layouts.master')

@section('main-content')
    <div class="forum-wrapper">
        <div class="container">
            <div class="row">
                <!-- LEFT COLUMN - CATEGORIES -->
                <div class="col-lg-3">
                    <div class="forum-sidebar">
                        <div class="sidebar-block categories-block">
                            <h3 class="block-title">Danh mục</h3>
                            <ul class="category-list">
                                @foreach ($categories as $cat)
                                    <li class="{{ $cat->id == $category->id ? 'active' : '' }}">
                                        <a href="">
                                            <div class="category-info">
                                                <h4>{{ $cat->name ?? 'Danh mục không tên' }}</h4>
                                                @if ($cat->summary)
                                                    <p>{{ Str::limit($cat->summary, 60) }}</p>
                                                @endif
                                            </div>
                                            <div class="category-count">{{ $cat->forum_threads_count ?? 0 }}</div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- MIDDLE COLUMN - TOPICS -->
                <div class="col-lg-6">
                    <div class="forum-main">
                        <!-- Breadcrumb -->
                        <div class="forum-breadcrumb">
                            <a href="{{ route('forum.index') }}">Diễn đàn</a>
                            <span class="separator">/</span>
                            <span class="current">{{ $category->name }}</span>
                        </div>

                        <!-- Category header -->
                        <div class="category-header">
                            <div class="category-info">
                                <h1>{{ $category->name }}</h1>
                                <p>{{ $category->summary }}</p>
                            </div>

                            <a href="{{ route('forum.threads.create', $category->slug) }}" class="btn-create">
                                <i class="fas fa-plus-circle"></i> Tạo chủ đề mới
                            </a>
                        </div>

                        <!-- Threads list -->
                        <div class="thread-list">
                            @forelse($threads as $thread)
                                <div class="thread-item">
                                    <!-- Thread author info -->
                                    <div class="thread-author">
                                        <div class="author-avatar">
                                            <img src="{{ $thread->user->avatar ?? asset('images/avatar-placeholder.png') }}"
                                                alt="{{ $thread->user->name }}">
                                        </div>
                                    </div>

                                    <!-- Thread content -->
                                    <div class="thread-content">
                                        <div class="thread-header">
                                            <h3 class="thread-title">
                                                @if ($thread->is_sticky)
                                                    <span class="thread-sticky"><i class="fas fa-thumbtack"></i></span>
                                                @endif
                                                @if ($thread->is_locked)
                                                    <span class="thread-locked"><i class="fas fa-lock"></i></span>
                                                @endif
                                                <a
                                                    href="{{ route('forum.threads.show', [$category->slug, $thread->slug]) }}">{{ $thread->title }}</a>
                                            </h3>

                                            <div class="thread-meta">
                                                <span class="meta-item author">
                                                    <i class="fas fa-user"></i> {{ $thread->user->name }}
                                                </span>
                                                <span class="meta-item date">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    {{ \Carbon\Carbon::parse($thread->created_at)->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </div>

                                        <div class="thread-stats">
                                            <div class="stat-item views">
                                                <i class="fas fa-eye"></i>
                                                <span>{{ number_format($thread->view_count) }}</span>
                                                <label>lượt xem</label>
                                            </div>
                                            <div class="stat-item replies">
                                                <i class="fas fa-comment-alt"></i>
                                                <span>{{ number_format($thread->reply_count) }}</span>
                                                <label>phản hồi</label>
                                            </div>
                                        </div>

                                        <div class="thread-last-post">
                                            <div class="last-post-label">Bài viết mới nhất:</div>
                                            <div class="last-post-info">
                                                <div class="last-poster">
                                                    bởi
                                                    <strong>{{ $thread->lastPoster->name ?? 'Không xác định' }}</strong>
                                                </div>
                                                <div class="last-post-time">
                                                    <i class="fas fa-clock"></i>
                                                    {{ $thread->last_posted_at ? \Carbon\Carbon::parse($thread->last_posted_at)->diffForHumans() : 'N/A' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-comments"></i>
                                    </div>
                                    <h3>Chưa có chủ đề nào</h3>
                                    <p>Hãy là người đầu tiên tạo chủ đề trong danh mục này.</p>
                                    <a href="{{ route('forum.threads.create', $category->slug) }}" class="btn-create">
                                        <i class="fas fa-plus-circle"></i> Tạo chủ đề đầu tiên
                                    </a>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="thread-pagination">
                            {{ $threads->links() }}
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN - INFO -->
                <div class="col-lg-3">
                    <div class="forum-sidebar">
                        <!-- Category Statistics -->
                        <div class="sidebar-block stats-block">
                            <h3 class="block-title">Thống kê danh mục</h3>
                            <div class="stats-content">
                                <div class="stat-row">
                                    <div class="stat-label">Tổng chủ đề:</div>
                                    <div class="stat-value">{{ $category->forumStats->thread_count ?? 0 }}</div>
                                </div>
                                <div class="stat-row">
                                    <div class="stat-label">Tổng bài viết:</div>
                                    <div class="stat-value">{{ $category->forumStats->post_count ?? 0 }}</div>
                                </div>
                                <div class="stat-row">
                                    <div class="stat-label">Bài viết mới nhất:</div>
                                    <div class="stat-value">
                                        {{ $category->forumStats->last_posted_at ? \Carbon\Carbon::parse($category->forumStats->last_posted_at)->diffForHumans() : 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Category Rules -->
                        <div class="sidebar-block rules-block">
                            <h3 class="block-title">Nguyên tắc tham gia</h3>
                            <div class="rules-content">
                                <ol>
                                    <li>Tôn trọng mọi thành viên trong diễn đàn.</li>
                                    <li>Không đăng nội dung quảng cáo, spam hoặc nội dung không liên quan.</li>
                                    <li>Không chia sẻ thông tin cá nhân của người khác.</li>
                                    <li>Cung cấp thông tin chính xác, có nguồn gốc rõ ràng.</li>
                                    <li>Thảo luận văn minh, không sử dụng ngôn từ thô tục.</li>
                                </ol>
                            </div>
                        </div>

                        <!-- Useful Resources -->
                        <div class="sidebar-block resources-block">
                            <h3 class="block-title">Tài nguyên hữu ích</h3>
                            <div class="resources-content">
                                <ul>
                                    <li><a href="#"><i class="fas fa-book-medical"></i> Từ điển y học cổ truyền</a>
                                    </li>
                                    <li><a href="#"><i class="fas fa-leaf"></i> Danh mục cây thuốc Việt Nam</a></li>
                                    <li><a href="#"><i class="fas fa-pills"></i> Cẩm nang sử dụng thuốc nam an
                                            toàn</a></li>
                                    <li><a href="#"><i class="fas fa-mortar-pestle"></i> Phương pháp chế biến
                                            thuốc</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Breadcrumb */
        .forum-breadcrumb {
            padding: 15px 20px;
            background: #f8f9fa;
            border-radius: 10px 10px 0 0;
            font-size: 14px;
        }

        .forum-breadcrumb a {
            color: #4285f4;
            text-decoration: none;
        }

        .forum-breadcrumb .separator {
            margin: 0 8px;
            color: #aaa;
        }

        .forum-breadcrumb .current {
            color: #666;
            font-weight: 500;
        }

        /* Category Header */
        .category-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .category-header h1 {
            font-size: 24px;
            margin: 0 0 5px;
            color: #333;
        }

        .category-header p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .btn-create {
            display: inline-block;
            padding: 8px 15px;
            background: linear-gradient(135deg, #34a853, #1e8e3e);
            color: white;
            border-radius: 20px;
            font-size: 14px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-create:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(30, 142, 62, 0.2);
            color: white;
            text-decoration: none;
        }

        .btn-create i {
            margin-right: 5px;
        }

        /* Thread List */
        .thread-list {
            padding: 0;
        }

        .thread-item {
            display: flex;
            padding: 20px;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s;
        }

        .thread-item:hover {
            background-color: #f9fafc;
        }

        .thread-author {
            margin-right: 15px;
        }

        .author-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .author-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .thread-content {
            flex-grow: 1;
        }

        .thread-header {
            margin-bottom: 10px;
        }

        .thread-title {
            margin: 0 0 5px;
            font-size: 18px;
            font-weight: 600;
        }

        .thread-title a {
            color: #333;
            text-decoration: none;
            transition: color 0.2s;
        }

        .thread-title a:hover {
            color: #4285f4;
        }

        .thread-sticky,
        .thread-locked {
            display: inline-block;
            margin-right: 5px;
            font-size: 14px;
        }

        .thread-sticky {
            color: #fbbc04;
        }

        .thread-locked {
            color: #888;
        }

        .thread-meta {
            display: flex;
            color: #888;
            font-size: 13px;
        }

        .meta-item {
            margin-right: 15px;
            display: flex;
            align-items: center;
        }

        .meta-item i {
            margin-right: 5px;
            width: 14px;
            text-align: center;
        }

        .thread-stats {
            display: flex;
            margin-bottom: 10px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            margin-right: 20px;
            font-size: 14px;
            color: #666;
        }

        .stat-item i {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f1f5fd;
            border-radius: 50%;
            margin-right: 8px;
            font-size: 12px;
            color: #4285f4;
        }

        .stat-item span {
            font-weight: 600;
            color: #333;
            margin-right: 4px;
        }

        .stat-item label {
            margin: 0;
            font-weight: normal;
        }

        .thread-last-post {
            font-size: 13px;
            color: #666;
            border-top: 1px dashed #eee;
            padding-top: 10px;
        }

        .last-post-label {
            font-weight: 500;
            margin-bottom: 3px;
        }

        .last-post-info {
            display: flex;
            justify-content: space-between;
        }

        .last-poster strong {
            color: #333;
        }

        .last-post-time {
            color: #888;
        }

        .last-post-time i {
            margin-right: 4px;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #666;
        }

        .empty-icon {
            font-size: 48px;
            color: #ddd;
            margin-bottom: 15px;
        }

        .empty-state h3 {
            margin: 0 0 10px;
            font-size: 20px;
            color: #333;
        }

        .empty-state p {
            margin: 0 0 20px;
            font-size: 15px;
        }

        /* Pagination */
        .thread-pagination {
            padding: 20px;
            border-top: 1px solid #f0f0f0;
        }

        /* Right sidebar blocks */
        .stats-block .stats-content,
        .rules-block .rules-content,
        .resources-block .resources-content {
            padding: 15px;
        }

        .stat-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .stat-row:last-child {
            margin-bottom: 0;
        }

        .stat-label {
            color: #666;
        }

        .stat-value {
            font-weight: 600;
            color: #333;
        }

        .rules-content ol {
            padding-left: 20px;
            margin: 0;
            font-size: 14px;
            color: #555;
        }

        .rules-content ol li {
            margin-bottom: 8px;
        }

        .rules-content ol li:last-child {
            margin-bottom: 0;
        }

        .resources-content ul {
            list-style: none;
            padding: 0;
            margin: 0;
            font-size: 14px;
        }

        .resources-content ul li {
            margin-bottom: 10px;
        }

        .resources-content ul li:last-child {
            margin-bottom: 0;
        }

        .resources-content ul li a {
            color: #4285f4;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .resources-content ul li a:hover {
            text-decoration: underline;
        }

        .resources-content ul li a i {
            width: 20px;
            margin-right: 8px;
            text-align: center;
        }

        @media (max-width: 991px) {
            .category-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .category-header .btn-create {
                margin-top: 15px;
            }

            .thread-last-post {
                display: none;
            }
        }

        @media (max-width: 767px) {
            .thread-item {
                flex-direction: column;
            }

            .thread-author {
                margin: 0 0 15px;
            }

            .stat-item {
                margin-right: 15px;
            }
        }
    </style>
@endpush
