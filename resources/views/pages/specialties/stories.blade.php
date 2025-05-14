@extends('layouts.master')

@section('main-content')
    <div class="stories-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('specialties.index') }}">Chuyên môn bác sĩ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Câu chuyện nghề y</li>
                </ol>
            </nav>

            <h1 class="mb-2">Câu chuyện nghề y</h1>
            <p class="lead mb-5">Những tâm sự, trải nghiệm và góc nhìn của các bác sĩ trong hành trình hành nghề</p>

            <!-- Danh mục con -->
            <div class="story-categories mb-4">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link {{ request('category') ? '' : 'active' }}"
                            href="{{ route('specialties.stories') }}">Tất cả</a>
                    </li>
                    @foreach ($storyCategories as $category)
                        <li class="nav-item">
                            <a class="nav-link {{ request('category') == $category->id ? 'active' : '' }}"
                                href="{{ route('specialties.stories', ['category' => $category->id]) }}">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Bài viết nổi bật -->
            @if (!request('category') && !request('page'))
                <div class="featured-stories mb-5">
                    <div class="row">
                        @if (count($featuredStories) > 0)
                            @foreach ($featuredStories as $featured)
                                <div class="col-lg-6 mb-4">
                                    <div class="card featured-story-card h-100">
                                        <div class="row g-0 h-100">
                                            <div class="col-md-6">
                                                @if ($featured->photo)
                                                    <img src="{{ $featured->photo }}" class="img-fluid rounded-start h-100"
                                                        alt="{{ $featured->title }}" style="object-fit: cover;">
                                                @else
                                                    <div
                                                        class="bg-light h-100 d-flex align-items-center justify-content-center rounded-start">
                                                        <i class="fas fa-book-medical fa-3x text-primary"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card-body d-flex flex-column h-100">
                                                    @if ($featured->cat_info)
                                                        <span
                                                            class="badge bg-primary mb-2">{{ $featured->cat_info->title }}</span>
                                                    @endif
                                                    <h4 class="card-title">{{ $featured->title }}</h4>
                                                    <p class="card-text flex-grow-1">
                                                        {{ Str::limit($featured->summary, 150) }}</p>

                                                    <div class="doctor-info d-flex align-items-center mt-3">
                                                        @if ($featured->author_info && $featured->author_info->photo)
                                                            <img src="{{ $featured->author_info->photo }}"
                                                                class="rounded-circle me-2"
                                                                alt="{{ $featured->author_info->name }}" width="40"
                                                                height="40">
                                                        @else
                                                            <div class="doctor-avatar bg-light rounded-circle d-flex align-items-center justify-content-center me-2"
                                                                style="width: 40px; height: 40px;">
                                                                <i class="fas fa-user-md text-primary"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="doctor-name">
                                                                {{ $featured->author_info->name ?? 'Bác sĩ' }}</div>
                                                            <div class="story-date small text-muted">
                                                                {{ $featured->created_at->format('d/m/Y') }}</div>
                                                        </div>
                                                    </div>

                                                    <a href="{{ route('post.detail', $featured->slug) }}"
                                                        class="stretched-link mt-3"></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @endif

            <!-- Danh sách bài viết -->
            <div class="all-stories">
                <div class="row">
                    @if (count($stories) > 0)
                        @foreach ($stories as $story)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card story-card hover-card h-100">
                                    @if ($story->photo)
                                        <img src="{{ $story->photo }}" class="card-img-top" alt="{{ $story->title }}"
                                            style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="placeholder-thumbnail bg-light d-flex align-items-center justify-content-center"
                                            style="height: 200px;">
                                            <i class="fas fa-book-medical fa-3x text-primary"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        @if ($story->cat_info)
                                            <span
                                                class="badge bg-light text-dark mb-2">{{ $story->cat_info->title }}</span>
                                        @endif
                                        <h5 class="card-title">{{ $story->title }}</h5>
                                        <p class="card-text">{{ Str::limit($story->summary, 120) }}</p>

                                        <div class="doctor-info d-flex align-items-center mt-3">
                                            @if ($story->author_info && $story->author_info->photo)
                                                <img src="{{ $story->author_info->photo }}" class="rounded-circle me-2"
                                                    alt="{{ $story->author_info->name }}" width="40" height="40">
                                            @else
                                                <div class="doctor-avatar bg-light rounded-circle d-flex align-items-center justify-content-center me-2"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user-md text-primary"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="doctor-name">{{ $story->author_info->name ?? 'Bác sĩ' }}</div>
                                                <div class="story-date small text-muted">
                                                    {{ $story->created_at->format('d/m/Y') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer border-top-0 bg-transparent">
                                        <a href="{{ route('post.detail', $story->slug) }}" class="btn btn-link p-0">Đọc
                                            tiếp <i class="fas fa-angle-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-info">
                                Chưa có câu chuyện nghề y nào. Vui lòng quay lại sau.
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Phân trang -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $stories->appends(request()->except('page'))->links() }}
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .hover-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .featured-story-card {
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .featured-story-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endsection
