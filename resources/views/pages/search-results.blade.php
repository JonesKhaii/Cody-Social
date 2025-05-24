{{-- @php
    dd([
        'doctors' => isset($doctors) ? $doctors : 'CHƯA ĐƯỢC TRUYỀN',
        'posts' => isset($posts) ? $posts : 'CHƯA ĐƯỢC TRUYỀN',
        'q' => isset($q) ? $q : 'CHƯA ĐƯỢC TRUYỀN',
    ]);
@endphp --}}


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

        <ul class="nav nav-tabs mt-4" id="searchResultTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link nav-link-result active" id="posts-tab" data-bs-toggle="tab" data-bs-target="#posts"
                    type="button"
                    role="tab" aria-controls="posts" aria-selected="true">
                    Bài viết ({{ $posts->total() }})
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link nav-link-result" id="doctors-tab" data-bs-toggle="tab" data-bs-target="#doctors"
                    type="button"
                    role="tab" aria-controls="doctors" aria-selected="false">
                    Bác sĩ ({{ $doctors->total() }})
                </button>
            </li>
        </ul>

        <div class="tab-content mt-3" id="searchResultsContent">
            <!-- Tab bài viết -->
            <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
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
                                            <a href="{{ route('post.detail', ['slug' => $post->slug]) }}"
                                                class="btn btn-primary">
                                                Đọc tiếp <i class="fas fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Phân trang bài viết -->
                    <div class="d-flex justify-content-center">
                        {{ $posts->appends(['q' => $q])->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        Không tìm thấy bài viết nào cho từ khóa "<strong>{{ $q }}</strong>".
                    </div>
                @endif
            </div>

            <!-- Tab bác sĩ -->
            <div class="tab-pane fade" id="doctors" role="tabpanel" aria-labelledby="doctors-tab">
                @if ($doctors->count())
                    <div class="row">
                        @foreach ($doctors as $doctor)
                            <div class="col-md-4 mb-4">
                                <div class="card doctor-card">
                                    <div class="card-header p-3 text-center">
                                        <img src="{{ asset($doctor->photo) }}" class="rounded-circle mb-2" width="100"
                                            height="100" alt="{{ $doctor->name }}">
                                        <h5 class="card-title mb-0">{{ $doctor->name }}</h5>
                                        @if ($doctor->specializations->isNotEmpty())
                                            <span
                                                class="badge bg-primary">{{ $doctor->specializations->first()->name }}</span>
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div>
                                                <i class="fas fa-star text-warning"></i>
                                                <span>{{ $doctor->rating ?? 'Chưa có đánh giá' }}</span>
                                            </div>
                                            @if ($doctor->years_experience)
                                                <div>
                                                    <i class="fas fa-briefcase"></i>
                                                    <span>{{ $doctor->years_experience }} năm kinh nghiệm</span>
                                                </div>
                                            @endif
                                        </div>

                                        @if ($doctor->short_bio)
                                            <p class="card-text">{{ Str::limit($doctor->short_bio, 100) }}</p>
                                        @endif

                                        <div class="mt-3 text-center">
                                            <a href="{{ route('doctor.detail', $doctor->id) }}"
                                                class="btn btn-outline-primary">
                                                Xem hồ sơ <i class="fas fa-user-md"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Phân trang bác sĩ -->
                    <div class="d-flex justify-content-center">
                        {{ $doctors->appends(['q' => $q])->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        Không tìm thấy bác sĩ nào cho từ khóa "<strong>{{ $q }}</strong>".
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

<style>
    .result-row {
        min-height: 400px;
    }

    .doctor-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
    }

    .doctor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-img-top {
        height: 200px;
        object-fit: cover;
    }

    .nav-link-result {
        color: rgba(120, 114, 114, 0.9) !important;
        transition: var(--transition);
        position: relative;
        font-weight: 500;
    }
</style>
