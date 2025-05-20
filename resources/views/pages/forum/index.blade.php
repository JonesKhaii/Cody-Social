@extends('layouts.master')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/forum.css') }}">
@endsection
@section('main-content')
    <div class="forum-wrapper">
        <!-- MAIN CONTENT -->
        <div class="forum-content">
            <div class="container">
                <div class="row">
                    <!-- LEFT COLUMN - CATEGORIES -->
                    <div class="col-lg-3">
                        <div class="forum-sidebar">
                            <div class="sidebar-block categories-block">
                                {{-- <h3 class="block-title">Danh mục</h3> --}}
                                <ul class="category-list">
                                    @foreach ($forumCategories as $category)
                                        <li class="category-forum-item">
                                            <div class="category-header">
                                                <a href="{{ route('forum.posts.category', $category->slug) }}"
                                                    class="category-title">
                                                    {{ $category->name ?? ($category->title ?? 'Danh mục không tên') }}
                                                </a>
                                            </div>

                                            @if (isset($category->categoryPosts) && $category->categoryPosts->count() > 0)
                                                <div class="category-posts">
                                                    <ul class="post-list">
                                                        @foreach ($category->categoryPosts as $index => $post)
                                                            <li class="post-item {{ $index >= 5 ? 'hidden-post' : '' }}"
                                                                @if ($index >= 5) style="display: none;" @endif
                                                                data-category="{{ $category->id }}">

                                                                <a href="{{ route('forum.posts.show', [$category->slug, $post->slug]) }}"
                                                                    class="post-link" title="{{ $post->title }}">
                                                                    {{ Str::limit($post->title, 30) }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                    @if ($category->categoryPosts->count() > 5)
                                                        <div class="view-toggle">
                                                            <a href="#" class="show-more"
                                                                data-category="{{ $category->id }}">
                                                                Xem thêm <i class="fa-solid fa-angle-down"></i>
                                                            </a>
                                                            <a href="#" class="show-less"
                                                                data-category="{{ $category->id }}" style="display: none;">
                                                                Thu gọn <i class="fa-solid fa-angle-up"></i>
                                                            </a>
                                                        </div>
                                                    @endif

                                                    <div class="view-all">
                                                        <a href="{{ route('forum.posts.category', $category->slug) }}"
                                                            class="view-all-link">
                                                            Xem tất cả bài viết <span></span> <i
                                                                class="fa-solid fa-arrow-right"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="no-posts">
                                                    <p>Chưa có bài viết nào</p>
                                                </div>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="sidebar-block join-block">
                                <div class="join-content">
                                    <h3>Tham gia cộng đồng</h3>
                                    <p>Đăng ký để chia sẻ kiến thức và nhận tư vấn miễn phí!</p>
                                    <a href="{{ route('register') }}" class="btn-join">Đăng ký ngay</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- MIDDLE COLUMN - TOPICS -->
                    <div class="col-lg-6">
                        <div class="forum-main">
                            <!-- Header -->
                            <div class="forum-main-header">
                                <h1>Diễn đàn ToiKhoe</h1>
                            </div>
                            <div class="forum-tabs-container">
                                <div class="forum-tabs">
                                    <a href="{{ route('forum.index') }}?sort=latest"
                                        class="tab {{ request('sort', 'latest') == 'latest' ? 'active' : '' }}">Mới
                                        nhất</a>
                                    <a href="{{ route('forum.index') }}?sort=top"
                                        class="tab {{ request('sort') == 'top' ? 'active' : '' }}">Nổi bật</a>
                                    <a href="{{ route('forum.index') }}?sort=hot"
                                        class="tab {{ request('sort') == 'hot' ? 'active' : '' }}">Hot</a>
                                    <a href="{{ route('forum.index') }}?sort=categories"
                                        class="tab {{ request('sort') == 'categories' ? 'active' : '' }}">Danh mục</a>
                                </div>
                            </div>

                            <div class="search-container">
                                <div class="search-input-group">
                                    <input type="text" id="live-search-input" placeholder="Tìm kiếm chủ đề..."
                                        autocomplete="off">
                                    <button type="button" class="search-submit" disabled>
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Create topic button for mobile -->
                            <div class="mobile-create-topic">
                                <a href="{{ route('forum.threads.create', $forumCategories->first()->slug ?? '') }}"
                                    class="btn-create">
                                    <i class="fas fa-plus"></i> Tạo chủ đề
                                </a>
                            </div>
                            <div class="desktop-create-topic">
                                <a href="#" class="btn-create" data-bs-toggle="modal"
                                    data-bs-target="#createThreadModal">
                                    <i class="fas fa-plus-circle"></i> Tạo chủ đề mới
                                </a>
                            </div>

                            <!-- Topic List -->
                            <div class="topic-list" id="topic-list">

                                @include('pages.forum.partials.thread_list', ['threads' => $latestThreads])
                            </div>

                            <!-- Desktop create topic button -->

                        </div>
                    </div>

                    <!-- RIGHT COLUMN - FEATURED -->
                    <div class="col-lg-3">
                        <div class="forum-sidebar">
                            <!-- Intro Block -->
                            <div class="sidebar-block intro-block">
                                <h3 class="block-title">Giới thiệu</h3>
                                <div class="intro-content">
                                    <p>Chào mừng bạn đến với diễn đàn ToiKhoe!</p>
                                    <p>Nơi đây tập hợp nhiều bài thuốc quý và kinh nghiệm điều trị từ y học cổ truyền và dân
                                        gian.</p>
                                    <p>Tham gia đóng góp và chia sẻ kinh nghiệm của bạn!</p>
                                </div>
                            </div>

                            <!-- Popular Topics Block -->
                            <div class="sidebar-block popular-block">
                                <h3 class="block-title">Chủ đề nổi bật</h3>
                                <div class="popular-topics">
                                    @forelse($popularThreads as $thread)
                                        <div class="popular-topic">
                                            @if ($thread->category)
                                                <a
                                                    href="{{ route('forum.threads.show', [$thread->category->slug, $thread->slug]) }}">
                                                    <h4>{{ Str::limit($thread->title, 50) }}</h4>
                                                    <div class="topic-info">
                                                        <span><i class="fas fa-eye"></i>
                                                            {{ number_format($thread->view_count) }}</span>
                                                        <span><i class="fas fa-comment"></i>
                                                            {{ number_format($thread->reply_count) }}</span>
                                                    </div>
                                                </a>
                                            @else
                                                <div class="unavailable-topic">
                                                    <h4>{{ Str::limit($thread->title, 50) }}</h4>
                                                    <div class="topic-info">
                                                        <span class="text-muted">Danh mục không tồn tại</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @empty
                                        <div class="no-topics">Chưa có chủ đề nào</div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Featured Product Block -->
                            <div class="sidebar-block product-block">
                                <h3 class="block-title">Sản phẩm nổi bật</h3>
                                <div class="product-card">
                                    <div class="product-image">
                                        <img src="{{ asset('images/products/featured.jpg') }}" alt="Sản phẩm nổi bật">
                                    </div>
                                    <div class="product-content">
                                        <h4>Viên uống thảo dược</h4>
                                        <p>Sản phẩm chiết xuất từ thảo dược thiên nhiên, hỗ trợ sức khỏe toàn diện.</p>
                                        <a href="#" class="btn-product">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('pages.forum.threads.create')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle search form
            const searchToggle = document.getElementById('searchToggle');
            const searchCollapse = document.getElementById('searchCollapse');

            if (searchToggle && searchCollapse) {
                searchToggle.addEventListener('click', function() {
                    searchCollapse.classList.toggle('show');

                    // Focus on input when visible
                    if (searchCollapse.classList.contains('show')) {
                        const searchInput = searchCollapse.querySelector('input');
                        if (searchInput) searchInput.focus();
                    }
                });
            }


            document.querySelectorAll('.filter-category').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const slug = this.closest('.category-forum-item').dataset.slug;

                    fetch(`/forum/category/${slug}/threads`)
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById('topic-list').innerHTML = data
                                    .threads_html;

                                // Active class
                                document.querySelectorAll('.category-forum-item').forEach(li =>
                                    li
                                    .classList.remove('active'));
                                this.closest('.category-forum-item').classList.add('active');
                            }
                        })
                        .catch(err => {
                            console.error('Lỗi tải chủ đề:', err);
                            alert('Không thể tải chủ đề. Vui lòng thử lại.');
                        });
                });
            });


            const searchInput = document.getElementById('live-search-input');
            let searchTimeout = null;

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const keyword = this.value.trim();

                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        if (keyword.length >= 2) {
                            fetch(`/forum/search?q=${encodeURIComponent(keyword)}`)
                                .then(res => res.json())
                                .then(data => {
                                    const topicList = document.getElementById('topic-list');

                                    if (data.success) {
                                        topicList.innerHTML = data.threads_html;
                                    } else {
                                        topicList.innerHTML =
                                            `<div class="empty-topics"><p>${data.message}</p></div>`;
                                    }
                                })
                                .catch(err => {
                                    console.error('Search error:', err);
                                });
                        }
                    }, 300);
                });
            }


            document.querySelectorAll('.show-more').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const categoryId = this.dataset.category;
                    const hiddenPosts = document.querySelectorAll(
                        `.post-item.hidden-post[data-category="${categoryId}"]`);

                    hiddenPosts.forEach(function(post) {
                        post.style.display = 'block';
                    });

                    this.style.display = 'none';
                    document.querySelector(`.show-less[data-category="${categoryId}"]`).style
                        .display = 'inline-block';
                });
            });

            // Xử lý nút "Thu gọn"
            document.querySelectorAll('.show-less').forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const categoryId = this.dataset.category;
                    const hiddenPosts = document.querySelectorAll(
                        `.post-item.hidden-post[data-category="${categoryId}"]`);

                    hiddenPosts.forEach(function(post) {
                        post.style.display = 'none';
                    });

                    this.style.display = 'none';
                    document.querySelector(`.show-more[data-category="${categoryId}"]`).style
                        .display = 'inline-block';
                });
            });

        });
    </script>
@endsection
