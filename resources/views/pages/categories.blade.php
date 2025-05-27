@extends('layouts.master')

@section('title', 'Tất cả danh mục bài viết')

@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/categories.css') }}">
@endsection

@section('main-content')
    <div class="container-fluid mt-4">
        <div class="container">
            <!-- Header Section -->
            <div class="page-header mb-5">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="page-title">Khám phá theo danh mục</h1>
                        <p class="page-subtitle">Tìm hiểu thông tin y tế theo từng chuyên mục một cách chi tiết và dễ hiểu
                        </p>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('home') }}">Trang chủ</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Danh mục
                                </li>
                            </ol>
                        </nav>
                    </div>

                </div>
            </div>

            {{-- <!-- Categories Stats -->
            <div class="stats-row mb-4">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <div class="stat-content">
                                <h4>{{ $categoriesWithPosts->count() }}</h4>
                                <p>Danh mục</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-newspaper"></i>
                            </div>
                            <div class="stat-content">
                                <h4>{{ $categoriesWithPosts->sum(function ($cat) {return $cat->loaded_posts->count();}) }}
                                </h4>
                                <p>Bài viết</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="stat-content">
                                <h4>{{ number_format(1250000) }}</h4>
                                <p>Lượt xem</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stat-content">
                                <h4>{{ number_format(45000) }}</h4>
                                <p>Độc giả</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Category Filter (Optional) -->
            <div class="filter-section mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="section-title mb-0">Tất cả danh mục</h3>
                    <div class="filter-controls">
                        <select class="form-select" id="sortFilter">
                            <option value="latest">Mới nhất</option>
                            <option value="popular">Phổ biến nhất</option>
                            <option value="name">Theo tên A-Z</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Categories with Posts -->
            <div class="categories-container">
                @forelse ($categoriesWithPosts as $category)
                    <div class="category-container" data-category-id="{{ $category->id }}">
                        <div class="category-header">
                            <div class="category-header-left">
                                <h2 class="category-title-head">
                                    <a href="{{ route('category.show', ['slug' => $category->slug]) }}">
                                        {{ $category->name }}
                                    </a>
                                </h2>
                                @if ($category->summary)
                                    <p class="category-description">{{ $category->summary }}</p>
                                @endif
                                <div class="category-meta">
                                    <span class="post-count">
                                        <i class="fas fa-newspaper me-1"></i>
                                        {{ $category->post_count }} bài viết
                                    </span>
                                </div>
                            </div>
                            <div class="category-header-right">
                                <a href="{{ route('category.show', ['slug' => $category->slug]) }}"
                                    class="btn btn-outline-primary btn-sm">
                                    Xem tất cả <i class="fas fa-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>

                        @if ($category->loaded_posts->isNotEmpty())
                            <div class="articles">
                                @php
                                    $firstPost = $category->loaded_posts->first();
                                    $remainingPosts = $category->loaded_posts->slice(1);
                                @endphp

                                {{-- Featured Post --}}
                                @if ($firstPost)
                                    <div class="first-row">
                                        <a href="{{ route('post.detail', $firstPost->slug) }}" class="post-link">
                                            <div class="featured-image">
                                                @if ($firstPost->photo)
                                                    <img src="{{ asset($firstPost->photo) }}"
                                                        alt="{{ $firstPost->title }}"
                                                        loading="lazy" />
                                                @else
                                                    <div class="placeholder-image">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="text-content">
                                                <span class="badge">{{ $category->name }}</span>
                                                <h3>{{ $firstPost->title }}</h3>
                                                <p>{{ Str::limit($firstPost->summary ?? strip_tags($firstPost->description), 150) }}
                                                </p>
                                                <div class="post-meta">
                                                    <span class="post-date">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        {{ $firstPost->created_at->format('d/m/Y') }}
                                                    </span>
                                                    @if ($firstPost->views)
                                                        <span class="post-views">
                                                            <i class="fas fa-eye me-1"></i>
                                                            {{ number_format($firstPost->views) }} lượt xem
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endif

                                {{-- Remaining Posts --}}
                                @foreach ($remainingPosts as $post)
                                    <div class="article">
                                        <a href="{{ route('post.detail', $post->slug) }}" class="post-link">
                                            {{-- @if ($post->photo)
                                                <div class="article-image">
                                                    <img src="{{ asset($post->photo) }}"
                                                        alt="{{ $post->title }}"
                                                        loading="lazy" />
                                                </div>
                                            @endif --}}
                                            <div class="article-content">
                                                <span class="badge">{{ $category->name }}</span>
                                                <h3>{{ $post->title }}</h3>
                                                <p>{{ Str::limit($post->summary ?? strip_tags($post->description), 100) }}
                                                </p>
                                                <div class="post-meta">
                                                    <span class="post-date">
                                                        <i class="fas fa-calendar-alt me-1"></i>
                                                        {{ $post->created_at->format('d/m/Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="empty-state py-5 text-center">
                        <div class="empty-icon">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h3>Chưa có danh mục nào</h3>
                        <p>Hiện tại chưa có danh mục nào có bài viết. Vui lòng quay lại sau!</p>
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fas fa-home me-2"></i>Về trang chủ
                        </a>
                    </div>
                @endforelse
            </div>

            <!-- Load More Button (Optional) -->
            @if ($categoriesWithPosts->count() >= 10)
                <div class="mt-5 text-center">
                    <button class="btn btn-outline-primary btn-lg" id="loadMoreBtn">
                        <i class="fas fa-plus me-2"></i>Xem thêm danh mục
                    </button>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // Sort functionality
        document.getElementById('sortFilter')?.addEventListener('change', function() {
            const sortBy = this.value;
            const container = document.querySelector('.categories-container');
            const categories = Array.from(container.children);

            categories.sort((a, b) => {
                if (sortBy === 'name') {
                    const nameA = a.querySelector('.category-title a').textContent;
                    const nameB = b.querySelector('.category-title a').textContent;
                    return nameA.localeCompare(nameB);
                }
                // Add other sorting logic if needed
                return 0;
            });

            categories.forEach(category => container.appendChild(category));
        });

        // Smooth scroll to top when clicking category links
        document.querySelectorAll('.category-title a').forEach(link => {
            link.addEventListener('click', function(e) {
                // Add loading state or smooth transition if needed
            });
        });
    </script>
@endsection
