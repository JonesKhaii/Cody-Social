<div class="card">
    <div class="card-header">
        <h2 class="card-title">Bài viết của bạn</h2>
        <div class="card-header-actions">
            <button class="btn-icon" title="Lọc bài viết">
                <i class="fas fa-filter"></i>
            </button>
            <button class="btn-icon" title="Sắp xếp">
                <i class="fas fa-sort"></i>
            </button>
            <button class="btn btn-primary" id="add-post-btn" style="margin-left: auto;">
                <i class="fas fa-plus"></i>
                Thêm bài viết
            </button>
        </div>
    </div>
    <div class="card-body">
        @if ($posts->isEmpty())
            <div class="py-5 text-center">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <h3 class="text-muted">Chưa có bài viết nào</h3>
                <p class="text-secondary mb-4">Hãy bắt đầu chia sẻ kiến thức của bạn với cộng đồng
                </p>
            </div>
        @else
            <div class="post-list">
                @foreach ($posts->sortByDesc('created_at') as $post)
                    <div class="post-card">

                        @if (in_array($post->post_cat_id, range(88, 100)))
                            <a href="{{ route('treatment.detail', ['slug' => $post->slug]) }}">
                                <img src="{{ asset($post->photo) }}" alt="Thumbnail" class="post-image">
                            </a>
                            <div class="post-content">
                                <h3 class="post-title">
                                    <a href="{{ route('treatment.detail', ['slug' => $post->slug]) }}"
                                        class="post-link">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                            @else
                                <a href="{{ route('post.detail', ['slug' => $post->slug]) }}">
                                    <img src="{{ asset($post->photo) }}" alt="Thumbnail" class="post-image">
                                </a>
                                <div class="post-content">
                                    <h3 class="post-title">
                                        <a href="{{ route('post.detail', ['slug' => $post->slug]) }}" class="post-link">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                        @endif
                        <p class="card-text">
                            {{ Str::limit(strip_tags($post->summary), 120) }}
                        </p>
                        <div class="post-meta">
                            <div class="post-date">
                                <i class="far fa-calendar-alt"></i>
                                <span>{{ $post->created_at->format('d/m/Y') }}</span>
                            </div>


                            <div class="post-views">
                                <i class="far fa-eye"></i>
                                <span>254</span>
                            </div>
                            <div class="post-action-buttons">
                                <button class="btn btn-sm btn-outline-primary edit-post-btn"
                                    data-id="{{ $post->id }}"
                                    data-title="{{ $post->title }}"
                                    data-summary="{{ $post->summary }}"
                                    data-description="{{ $post->description }}"
                                    data-category="{{ $post->post_cat_id }}"
                                    data-photo="{{ asset($post->photo) }}"
                                    data-url="{{ route('posts.update', $post->id) }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger delete-post-btn"
                                    data-id="{{ $post->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
            </div>
        @endforeach
    </div>
    @endif


</div>
</div>
