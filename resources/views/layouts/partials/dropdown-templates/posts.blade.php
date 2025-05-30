<template id="dropdown-template-posts">
    <div class="row py-4">
        <!-- Cột các danh mục bài viết chính -->
        <div class="col-md-8">
            <div class="row">
                <!-- Danh mục bài viết -->
                @foreach ($dropdownData['posts']['categories'] as $category)
                    <div class="col-md-6 mb-3">
                        <div class="category-item-container">
                            <div class="d-flex align-items-center mb-2">
                                @if ($category->icon)
                                    <div class="category-image me-2">
                                        <img src="{{ asset('asset/images/category/' . $category->slug . '.png') }}"
                                            class="img-fluid category-thumbnail">
                                    </div>
                                @else
                                    <div class="category-icon me-2">
                                        <i class="{{ $category->icon ?? 'fas fa-folder' }}"></i>
                                    </div>
                                @endif

                                <!-- Nếu có danh mục con thì thêm lớp dropdown -->
                                <h6
                                    class="category-title {{ $category->children_with_posts->count() > 0 ? 'has-subcategories' : '' }} mb-0">
                                    <a href="/category/{{ $category->slug }}"
                                        class="category-link">{{ $category->name }}</a>
                                    @if ($category->children_with_posts->count() > 0)
                                        <span class="subcategory-toggle ms-1">
                                            <i class="fas fa-chevron-down small-icon"></i>
                                        </span>
                                    @endif
                                </h6>
                                <span class="post-count ms-2">({{ $category->total_posts_count }})</span>
                            </div>

                            @if ($category->children_with_posts->count() > 0)
                                <div class="subcategories ms-4" style="display: none;">
                                    @foreach ($category->children_with_posts as $child)
                                        <a href="/category/{{ $child->slug }}"
                                            class="subcategory-link d-block mb-1">
                                            {{ $child->name }} <span
                                                class="post-count">({{ $child->posts_count }})</span>
                                        </a>
                                    @endforeach

                                    <a href="/category/{{ $category->slug }}"
                                        class="category-view-all mt-2">
                                        Xem tất cả <i class="fas fa-angle-right ms-1"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Cột bài viết mới nhất -->
        <div class="col-md-4">
            <h6 class="dropdown-header">Bài viết mới nhất</h6>
            <div class="dropdown-divider"></div>

            <div class="recent-posts">
                @foreach ($dropdownData['posts']['recentPosts'] as $post)
                    <a href="/post/{{ $post->slug }}"
                        class="recent-post-item d-flex align-items-center mb-2">
                        <div class="post-image-container me-2">
                            @if ($post->photo)
                                <img src="{{ $post->photo }}" alt="{{ $post->title }}"
                                    class="img-fluid post-thumbnail">
                            @else
                                <div class="post-thumbnail-placeholder">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            @endif
                        </div>
                        <div class="post-info">
                            <div class="post-title">{{ $post->title }}</div>
                            <div class="post-meta">
                                <span
                                    class="post-category">{{ $post->cat_info->title ?? 'Chưa phân loại' }}</span>
                                <span
                                    class="post-date">{{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach

                <a href="/blog" class="dropdown-item view-all mt-2">
                    <i class="fas fa-angle-right me-1"></i> Xem tất cả
                    ({{ $dropdownData['posts']['totalPosts'] }})
                </a>
            </div>
        </div>
    </div>
</template>
