@extends('layouts.master')

@section('title', 'Danh mục: ' . $category->title)

@section('main-content')
    <div class="container mt-4">
        <h3>Danh mục: {{ $category->title }}</h3>

        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-2">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>

        @if ($posts->count())
            <div class="result row">
                @foreach ($posts as $post)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img class="card-img-top" src="{{ asset($post->photo) }}" alt="{{ $post->title }}"
                                style="height: 200px; object-fit: cover;">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="text-muted">
                                    <small>
                                        <i class="fas fa-calendar-alt"></i> {{ $post->created_at->format('d M Y') }} |
                                        <i class="fas fa-user"></i> {{ $post->author_info->name ?? 'N/A' }}
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
            </div>

            <!-- Phân trang -->
            <div class="pagination-container">
                {{ $posts->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="result-row row">
                <p>Không có bài viết nào trong danh mục <strong>{{ $category->title }}</strong>.</p>
            </div>
        @endif
    </div>
@endsection


<style>
    .result-row {
        min-height: 400px;

    }

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
        .row-eq-height {
            display: block;
        }
    }
</style>
