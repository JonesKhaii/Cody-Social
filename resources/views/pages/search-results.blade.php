@extends('layouts.master')

@section('title', 'Kết quả tìm kiếm')

@section('main-content')
    <div class="container mt-4">
        <h1>Kết quả tìm kiếm</h1>
        @if ($q)
            <p>Đang tìm kiếm cho: <strong>{{ $q }}</strong></p>
        @endif
        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-2">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
        @if ($posts->count())
            <div class="row">
                @foreach ($posts as $post)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img class="card-img-top" src="{{ asset($post->photo) }}" alt="{{ $post->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="text-muted">
                                    <small>
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ $post->created_at->format('d M Y') }} |
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
            <div class="d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        @else
            <p>Không tìm thấy kết quả nào cho từ khóa <strong>{{ $q }}</strong>.</p>
        @endif
    </div>
@endsection
