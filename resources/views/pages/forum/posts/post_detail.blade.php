@extends('layouts.master')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/forum-post-detail.css') }}">
@endsection
@section('main-content')
    <div class="post-detail-wrapper">
        <div class="container">
            <div class="row">
                <!-- LEFT COLUMN - ARTICLE -->
                <div class="col-lg-8">
                    <div class="post-detail">
                        <!-- Breadcrumb -->
                        <div class="forum-breadcrumb">
                            <a href="{{ route('forum.index') }}">Diễn đàn</a>
                            <span class="separator">/</span>
                            <a href="{{ route('forum.posts.category', $category->slug) }}">{{ $category->name }}</a>
                            <span class="separator">/</span>
                            <span class="current">{{ $categoryPost->title }}</span>
                        </div>

                        <!-- Post content -->
                        <article class="post-content">
                            <header class="post-header">
                                <h1 class="post-title">{{ $categoryPost->title }}</h1>
                                <div class="post-meta">
                                    <span class="meta-date"><i class="fas fa-calendar-alt"></i>
                                        {{ date('d/m/Y', strtotime($categoryPost->created_at)) }}</span>

                                    <span class="meta-user"><i class="fa-solid fa-user"></i>
                                        {{ $categoryPost->author_info->name }}</span>
                                </div>
                            </header>

                            @if ($categoryPost->photo)
                                <div class="post-featured-image">
                                    <img src="{{ asset($categoryPost->photo) }}" alt="{{ $categoryPost->title }}">
                                </div>
                            @endif

                            @if ($categoryPost->summary)
                                <div class="post-summary">
                                    {{ $categoryPost->summary }}
                                </div>
                            @endif

                            <div class="post-body">
                                {!! $categoryPost->description !!}
                            </div>

                            @if ($categoryPost->quote)
                                <div class="post-quote">
                                    <i class="fas fa-quote-left"></i>
                                    <blockquote>{{ $categoryPost->quote }}</blockquote>
                                </div>
                            @endif

                            @if ($categoryPost->tags)
                                <div class="post-tags">
                                    <i class="fas fa-tags"></i>
                                    @foreach (explode(',', $categoryPost->tags) as $tag)
                                        <span class="tag">{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </article>

                        <!-- Related threads section -->
                        <div class="related-threads">
                            <h3 class="section-title">Bài viết liên quan</h3>

                            @if ($relatedCategoryPosts && $relatedCategoryPosts->count() > 0)
                                <div class="related-posts-list">
                                    <div class="row">
                                        @foreach ($relatedCategoryPosts as $relatedPost)
                                            <div class="col-md-6">
                                                <div class="related-post-item">
                                                    @if ($relatedPost->photo)
                                                        <div class="related-post-image">

                                                            <a
                                                                href="{{ route('forum.posts.show', [$category->slug, $relatedPost->slug]) }}">
                                                                <img src="{{ asset($relatedPost->photo) }}"
                                                                    alt="{{ $relatedPost->title }}">
                                                            </a>
                                                        </div>
                                                    @endif
                                                    <div class="related-post-content">
                                                        <h4>

                                                            <a
                                                                href="{{ route('forum.posts.show', [$category->slug, $relatedPost->slug]) }}">
                                                                {{ $relatedPost->title }}
                                                            </a>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="no-related-posts">Không có bài viết liên quan</div>
                            @endif
                        </div>

                        <!-- Forum thread discussions -->
                        <div class="forum-discussions">
                            <h3 class="section-title">Thảo luận từ cộng đồng</h3>

                            @if ($relatedThreads && $relatedThreads->count() > 0)
                                <div class="thread-list">
                                    @foreach ($relatedThreads as $thread)
                                        <div class="thread-item">
                                            <h4 class="thread-title">

                                                <a
                                                    href="{{ route('forum.threads.show', [$category->slug, $thread->slug]) }}">
                                                    {{ $thread->title }}
                                                </a>
                                            </h4>
                                            <div class="thread-meta">
                                                <span class="meta-author"><i class="fas fa-user"></i>
                                                    {{ $thread->user->name }}</span>
                                                <span class="meta-replies"><i class="fas fa-comments"></i>
                                                    {{ $thread->reply_count }} phản hồi</span>
                                            </div>
                                        </div>
                                    @endforeach

                                    {{-- <div class="view-all-threads">
                                        <a href="{{ route('forum.category', $category->slug) }}" class="btn-view-all">
                                            Xem tất cả thảo luận <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div> --}}
                                </div>
                            @else
                                <div class="no-threads">
                                    <p>Chưa có thảo luận nào về chủ đề này.</p>
                                    <a href="{{ route('forum.threads.create', $category->slug) }}" class="btn-create">
                                        <i class="fas fa-plus-circle"></i> Tạo chủ đề mới
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN - SIDEBAR -->
                <div class="col-lg-4">
                    <div class="post-sidebar">
                        <!-- Category list -->
                        <div class="sidebar-block categories-block">
                            <h3 class="block-title">Danh mục</h3>
                            <ul class="category-list">
                                @foreach ($categories as $cat)
                                    <li class="{{ $cat->id == $category->id ? 'active' : '' }}">
                                        <a href="{{ route('forum.posts.category', $cat->slug) }}">
                                            {{ $cat->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Popular posts -->
                        <div class="sidebar-block popular-posts-block">
                            <h3 class="block-title">Bài viết nổi bật</h3>
                            <div class="popular-posts">
                                @foreach ($popularCategoryPosts as $popularPost)
                                    <div class="popular-post-item">
                                        @if ($popularPost->photo)
                                            <div class="popular-post-image">

                                                <a
                                                    href="{{ route('forum.posts.show', [$popularPost->cat_info->slug, $popularPost->slug]) }}">
                                                    <img src="{{ asset($popularPost->photo) }}"
                                                        alt="{{ $popularPost->title }}">
                                                </a>
                                            </div>
                                        @endif
                                        <div class="popular-post-content">
                                            <h4>

                                                <a
                                                    href="{{ route('forum.posts.show', [$popularPost->cat_info->slug, $popularPost->slug]) }}">
                                                    {{ $popularPost->title }}
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Call to action -->
                        <div class="sidebar-block cta-block">
                            <div class="cta-content">
                                <h3>Bạn cần tư vấn?</h3>
                                <p>Liên hệ với các chuyên gia của chúng tôi để được tư vấn miễn phí.</p>
                                <a href="#" class="btn-cta">Đặt lịch tư vấn</a>
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
        /* Post Detail styles */
        .post-detail-wrapper {
            padding: 30px 0;
        }

        .forum-breadcrumb {
            padding: 15px 20px;
            background: #f8f9fa;
            border-radius: 10px 10px 0 0;
            font-size: 14px;
            margin-bottom: 20px;
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

        .post-detail {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            padding: 0 0 30px;
            margin-bottom: 30px;
        }

        .post-content {
            padding: 0 20px;
        }

        .post-header {
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .post-title {
            font-size: 28px;
            color: #333;
            margin: 0 0 15px;
            line-height: 1.3;
        }

        .post-meta {
            color: #888;
            font-size: 14px;
        }

        .meta-date i {
            margin-right: 5px;
        }

        .post-featured-image {
            margin: 0 -20px 20px;
        }

        .post-featured-image img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
        }

        .post-summary {
            font-size: 18px;
            color: #555;
            margin-bottom: 25px;
            line-height: 1.6;
            font-weight: 500;
        }

        .post-body {
            font-size: 16px;
            line-height: 1.8;
            color: #333;
            margin-bottom: 30px;
        }

        .post-body h2 {
            font-size: 24px;
            margin: 30px 0 15px;
            color: #333;
        }

        .post-body h3 {
            font-size: 20px;
            margin: 25px 0 15px;
            color: #333;
        }

        .post-body p {
            margin-bottom: 20px;
        }

        .post-body ul,
        .post-body ol {
            margin-bottom: 20px;
            padding-left: 20px;
        }

        .post-body li {
            margin-bottom: 10px;
        }

        .post-body img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 20px 0;
        }

        .post-quote {
            background: #f8f9fa;
            border-left: 4px solid #4285f4;
            padding: 20px;
            margin: 30px 0;
            font-style: italic;
            position: relative;
        }

        .post-quote i {
            position: absolute;
            left: 15px;
            top: 15px;
            color: #ccc;
            font-size: 24px;
        }

        .post-quote blockquote {
            margin: 0 0 0 30px;
            padding: 0;
            border: none;
            color: #555;
        }

        .post-tags {
            margin-top: 30px;
            color: #888;
        }

        .post-tags i {
            margin-right: 8px;
        }

        .tag {
            display: inline-block;
            background: #f1f3f4;
            padding: 4px 10px;
            border-radius: 20px;
            margin: 0 5px 5px 0;
            font-size: 13px;
            color: #555;
        }

        .section-title {
            font-size: 22px;
            color: #333;
            margin: 40px 0 20px;
            padding: 0 20px;
            position: relative;
        }

        .section-title::before {
            content: '';
            position: absolute;
            left: 20px;
            bottom: -10px;
            width: 50px;
            height: 3px;
            background: #4285f4;
        }

        .related-posts-list,
        .thread-list {
            padding: 20px;
        }

        .related-post-item {
            margin-bottom: 20px;
            border: 1px solid #f0f0f0;
            border-radius: 8px;
            overflow: hidden;
            transition: all 0.3s;
        }

        .related-post-item:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(-3px);
        }

        .related-post-image img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .related-post-content {
            padding: 15px;
        }

        .related-post-content h4 {
            margin: 0;
            font-size: 16px;
            line-height: 1.4;
        }

        .related-post-content h4 a {
            color: #333;
            text-decoration: none;
        }

        .related-post-content h4 a:hover {
            color: #4285f4;
        }

        .thread-item {
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .thread-item:last-child {
            border-bottom: none;
        }

        .thread-title {
            margin: 0 0 10px;
            font-size: 18px;
        }

        .thread-title a {
            color: #333;
            text-decoration: none;
            transition: color 0.2s;
        }

        .thread-title a:hover {
            color: #4285f4;
        }

        .thread-meta {
            color: #888;
            font-size: 14px;
        }

        .meta-author {
            margin-right: 15px;
        }

        .meta-author i,
        .meta-replies i {
            margin-right: 5px;
        }

        .view-all-threads {
            text-align: center;
            margin-top: 20px;
        }

        .btn-view-all {
            display: inline-block;
            padding: 8px 20px;
            background-color: #f1f3f4;
            color: #555;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-view-all:hover {
            background-color: #e8eaed;
            color: #333;
        }

        .btn-view-all i {
            margin-left: 5px;
            font-size: 12px;
        }

        .no-threads,
        .no-related-posts {
            text-align: center;
            padding: 20px;
            color: #888;
        }

        .btn-create {
            display: inline-block;
            margin-top: 15px;
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

        /* Sidebar styles */
        .post-sidebar {
            position: sticky;
            top: 30px;
        }

        .sidebar-block {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
            overflow: hidden;
        }

        .block-title {
            padding: 15px 20px;
            margin: 0;
            font-size: 18px;
            background: #f8f9fa;
            color: #333;
            border-bottom: 1px solid #eee;
        }

        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-list li {
            border-bottom: 1px solid #f0f0f0;
        }

        .category-list li:last-child {
            border-bottom: none;
        }

        .category-list li a {
            display: block;
            padding: 12px 20px;
            color: #555;
            text-decoration: none;
            transition: all 0.2s;
        }

        .category-list li a:hover {
            background: #f9fafc;
            color: #4285f4;
        }

        .category-list li.active a {
            background: #f1f8ff;
            color: #4285f4;
            font-weight: 500;
        }

        .popular-posts {
            padding: 15px;
        }

        .popular-post-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .popular-post-item:last-child {
            border-bottom: none;
        }

        .popular-post-image {
            flex: 0 0 60px;
            margin-right: 15px;
        }

        .popular-post-image img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 5px;
        }

        .popular-post-content {
            flex: 1;
        }

        .popular-post-content h4 {
            margin: 0;
            font-size: 14px;
            line-height: 1.4;
        }

        .popular-post-content h4 a {
            color: #333;
            text-decoration: none;
        }

        .popular-post-content h4 a:hover {
            color: #4285f4;
        }

        .cta-block {
            background: linear-gradient(135deg, #4285f4, #0d67db);
            color: white;
        }

        .cta-content {
            padding: 25px 20px;
            text-align: center;
        }

        .cta-content h3 {
            margin: 0 0 10px;
            font-size: 20px;
        }

        .cta-content p {
            margin: 0 0 20px;
            opacity: 0.9;
        }

        .btn-cta {
            display: inline-block;
            padding: 10px 20px;
            background: white;
            color: #4285f4;
            font-weight: 500;
            border-radius: 25px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            color: #4285f4;
            text-decoration: none;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .post-sidebar {
                position: static;
                margin-top: 30px;
            }
        }
    </style>
@endpush
