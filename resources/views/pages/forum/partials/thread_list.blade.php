@forelse($threads as $thread)
    <div class="topic-card">
        <div class="topic-author">
            <div class="author-avatar">
                <img src="{{ $thread->user->photo ?? asset('images/avatar-placeholder.png') }}"
                    alt="{{ $thread->user->name }}">
            </div>
        </div>
        <div class="topic-content">
            <div class="topic-header">
                <div class="topic-tags">
                    @if ($thread->category)
                        <a href=""
                            class="topic-category">{{ $thread->category->name }}</a>
                    @else
                        <span class="topic-category">Không có danh mục</span>
                    @endif
                </div>
                <h3 class="topic-title">
                    <a
                        href="{{ route('forum.threads.show', [$thread->category->slug, $thread->slug]) }}">{{ $thread->title }}</a>
                </h3>
                <div class="topic-meta">
                    <span class="meta-item author"><i class="fas fa-user"></i> {{ $thread->user->name }}</span>
                    <span class="meta-item date"><i class="fas fa-calendar-alt"></i>
                        {{ $thread->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
            <div class="topic-preview">
                {!! Str::limit(strip_tags($thread->content), 150) !!}
            </div>
        </div>
    </div>
@empty
    <p>Không có chủ đề nào trong danh mục này.</p>
@endforelse
