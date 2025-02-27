<div class="row">
    @if ($posts->count() > 0)
        @foreach ($posts as $post)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img class="card-img-top" src="{{ asset($post->photo) }}" alt="{{ $post->title }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="text-muted">
                            <small>
                                <i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('d M Y') }} |
                                <i class="fas fa-user"></i> {{ $post->author_info->name ?? 'N/A' }} |
                                <i class="fas fa-folder"></i> {{ $post->cat_info->title ?? 'Chưa phân loại' }}
                            </small>
                        </p>
                        <p class="card-text">
                            {{ Str::limit(strip_tags($post->summary), 120) }}
                        </p>
                        <div class="text-end">
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
<div class="d-flex justify-content-center">
    {{ $posts->links() }}
</div>
