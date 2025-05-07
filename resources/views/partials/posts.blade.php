<div class="articles-grid">
    @if ($posts->count() > 0)
        @foreach ($posts as $post)
            @if (!$post->slug)
                @continue
            @endif
            <div class="article-card">
                <a href="{{ route('post.detail', ['slug' => $post->slug]) }}" class="article-link">
                    <div class="article-image-container">
                        <img src="{{ asset($post->photo) }}" alt="{{ $post->title }}">
                        @if ($post->cat_info)
                            <span class="category-badge">{{ $post->cat_info->title }}</span>
                        @endif
                    </div>
                    <div class="article-content">
                        <div class="article-meta">
                            <div class="author-info">
                                <div class="author-avatar">
                                    <img src="{{ $post->author_info->photo ?? asset('images/default-avatar.png') }}"
                                        alt="Author">
                                </div>
                                <span class="author-name">{{ $post->author_info->name ?? 'N/A' }}</span>
                            </div>
                            <div class="date-info">
                                <span><i class="far fa-calendar-alt"></i>
                                    {{ $post->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                        <h3 class="article-title">{{ $post->title }}</h3>
                        <p class="article-excerpt">{{ Str::limit(strip_tags($post->summary), 80) }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    @else
        <div class="no-posts">
            <div class="no-posts-icon"><i class="fas fa-search"></i></div>
            <p>Không có bài viết nào thuộc danh mục này.</p>
        </div>
    @endif
</div>

<div class="pagination-container">
    {{ $posts->links('pagination::bootstrap-5') }}
</div>



<style>
    /* Styling for articles grid */
    .articles-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        ;
        gap: 25px;
        margin-bottom: 40px;
    }

    .article-card {
        background: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .article-link {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .article-image-container {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .article-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .article-card:hover .article-image-container img {
        transform: scale(1.05);
    }

    .category-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #1EABF8;
        color: white;
        padding: 6px 15px;
        border-radius: 30px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .article-content {
        padding: 20px;
    }

    .article-title:hover {
        color: #1EABF8;
    }

    .article-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .author-info {
        display: flex;
        align-items: center;
    }

    .author-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        overflow: hidden;
        margin-right: 10px;
    }

    .author-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .author-name {
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
    }

    .author-name:hover {
        color: #1EABF8;
    }

    .date-info {
        font-size: 0.85rem;
        color: #666;
    }

    .article-title {
        font-size: 1.25rem;
        font-weight: 700;
        line-height: 1.4;
        margin-bottom: 12px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        color: #103566;
    }

    .article-excerpt {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 0;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Empty state styling */
    .no-posts {
        grid-column: 1 / -1;
        text-align: center;
        padding: 40px 20px;
        background: #f8f9fa;
        border-radius: 12px;
    }

    .no-posts-icon {
        font-size: 3rem;
        color: #ddd;
        margin-bottom: 15px;
    }

    .no-posts p {
        font-size: 1.1rem;
        color: #888;
    }

    /* Pagination styling */
    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        margin-left: 20px;
        border-radius: 0.25rem;
    }

    .page-item.active .page-link {
        background-color: #1EABF8;
        border-color: #1EABF8;
    }

    .page-link {
        color: #1EABF8;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .articles-grid {
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .article-content {
            padding: 15px;
        }

        .article-title {
            font-size: 1.1rem;
        }
    }

    @media (max-width: 480px) {
        .articles-grid {
            grid-template-columns: 1fr;
        }

        .article-image-container {
            height: 180px;
        }
    }
</style>
