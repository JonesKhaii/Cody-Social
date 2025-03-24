<div class="row row-eq-height">
    @if ($posts->count() > 0)
        @foreach ($posts as $post)
            @if (!$post->slug)
                @continue
            @endif
            <div class="col-md-4 d-flex">
                <div class="card w-100 mb-4 shadow-sm">
                    <img class="card-img-top" src="{{ asset($post->photo) }}" alt="{{ $post->title }}"
                        style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title title-truncate">{{ $post->title }}</h5>
                        <p class="text-muted meta-info">
                            <small>
                                <i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('d M Y') }} |
                                <i class="fas fa-user"></i> {{ $post->author_info->name ?? 'N/A' }} |
                                <i class="fas fa-folder"></i> {{ $post->cat_info->title ?? 'Chưa phân loại' }}
                            </small>
                        </p>
                        <p class="card-text summary-truncate">
                            {{ Str::limit(strip_tags($post->summary), 120) }}
                        </p>
                        <div class="mt-auto text-end">
                            <a href="{{ route('post.detail', ['slug' => $post->slug]) }}" class="btn btn-primary">
                                Đọc tiếp <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p class="text-center">Không có bài viết nào thuộc danh mục này.</p>
    @endif
</div>

<style>
    /* CSS để tạo card có chiều cao đồng đều */
    .row-eq-height {
        display: flex;
        flex-wrap: wrap;
    }

    .title-truncate {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 48px;
        margin-bottom: 10px;
    }

    .meta-info {
        margin-bottom: 10px;
    }

    .summary-truncate {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        flex-grow: 1;
        margin-bottom: 15px;
    }

    @media (max-width: 767.98px) {

        /* Trên thiết bị nhỏ hơn, cho phép card có chiều cao tự nhiên */
        .row-eq-height {
            display: block;
        }
    }
</style>
