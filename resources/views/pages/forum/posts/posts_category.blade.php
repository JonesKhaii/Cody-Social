@extends('layouts.master')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/forum-post.css') }}">
@endsection
@section('main-content')
    <div class="category-wrapper">
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
                                        <a href="{{ route('forum.posts.category', $cat->slug) }}">
                                            <div class="category-info">
                                                <h4>{{ $cat->name ?? 'Danh mục không tên' }}</h4>
                                                @if ($cat->summary)
                                                    <p>{{ Str::limit($cat->summary, 60) }}</p>
                                                @endif
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- MIDDLE COLUMN - POSTS -->
                <div class="col-lg-9">
                    <div class="category-main">
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
                        </div>

                        <!-- Posts list -->
                        <div class="posts-list">
                            @forelse($categoryPosts as $post)
                                <div class="post-item">
                                    @if ($post->photo)
                                        <div class="post-image">
                                            <img src="{{ asset($post->photo) }}" alt="{{ $post->title }}">
                                        </div>
                                    @endif

                                    <div class="post-content">
                                        <h3 class="post-title">
                                            <a
                                                href="{{ route('forum.posts.show', [$category->slug, $post->slug]) }}">{{ $post->title }}</a>
                                        </h3>

                                        <div class="post-summary">
                                            {{ $post->summary }}
                                        </div>

                                        <div class="post-meta">
                                            <span class="meta-date"><i class="fas fa-calendar-alt"></i>
                                                {{ date('d/m/Y', strtotime($post->created_at)) }}</span>
                                            <a href="{{ route('forum.posts.show', [$category->slug, $post->slug]) }}"
                                                class="btn-read-more">Xem chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <i class="fas fa-file-alt"></i>
                                    </div>
                                    <h3>Chưa có bài viết nào</h3>
                                    <p>Hiện chưa có bài viết nào trong danh mục này.</p>
                                </div>
                            @endforelse
                        </div>

                        <!-- Pagination -->
                        <div class="posts-pagination">
                            {{ $categoryPosts->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Category styles */
        .category-wrapper {
            padding: 30px 0;
        }

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

        .category-main {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .category-header {
            padding: 20px;
            border-bottom: 1px solid #eee;
        }

        .category-header h1 {
            font-size: 24px;
            margin: 0 0 10px;
            color: #333;
        }

        .category-header p {
            margin: 0;
            color: #666;
        }

        .posts-list {
            padding: 20px;
        }

        .post-item {
            display: flex;
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #f0f0f0;
        }

        .post-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .post-image {
            flex: 0 0 200px;
            margin-right: 20px;
        }

        .post-image img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 8px;
        }

        .post-content {
            flex: 1;
        }

        .post-title {
            margin: 0 0 10px;
            font-size: 20px;
        }

        .post-title a {
            color: #333;
            text-decoration: none;
            transition: color 0.2s;
        }

        .post-title a:hover {
            color: #4285f4;
        }

        .post-summary {
            margin-bottom: 15px;
            color: #555;
            line-height: 1.6;
        }

        .post-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            color: #888;
        }

        .meta-date i {
            margin-right: 5px;
        }

        .btn-read-more {
            display: inline-block;
            padding: 6px 12px;
            background: linear-gradient(135deg, #4285f4, #0d67db);
            color: white;
            font-size: 14px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .btn-read-more:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(13, 103, 219, 0.2);
            color: white;
        }

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
            margin: 0;
            font-size: 15px;
        }

        .posts-pagination {
            padding: 20px;
            border-top: 1px solid #f0f0f0;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .post-item {
                flex-direction: column;
            }

            .post-image {
                flex: none;
                margin-right: 0;
                margin-bottom: 15px;
                width: 100%;
            }

            .post-image img {
                height: 200px;
            }
        }
    </style>
@endpush
