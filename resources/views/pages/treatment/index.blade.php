@extends('layouts.master')

@section('main-content')
    <div class="services-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Phương pháp điều trị</li>
                </ol>
            </nav>

            <h1 class="mb-2">Phương pháp điều trị tiên tiến</h1>
            <p class="lead mb-5">Khám phá các phương pháp điều trị tiên tiến và công nghệ y học hiện đại nhất hiện nay</p>

            <!-- Hiển thị các danh mục con -->
            <div class="row mb-5">
                @foreach ($serviceCategories as $category)
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 hover-card shadow-sm">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="category-icon bg-light me-3 rounded p-3">
                                        <i class="{{ $category->icon ?? 'fas fa-stethoscope' }} text-primary fa-2x"></i>
                                    </div>
                                    <h3>{{ $category->name }}</h3>
                                </div>
                                <p>{{ $category->summary }}</p>

                                <!-- Lấy một số bài viết liên quan để hiển thị -->
                                @php
                                    $relatedPosts = App\Models\Post::where('post_cat_id', $category->id)
                                        ->where('post_type', 'service')
                                        ->where('status', 'active')
                                        ->take(3)
                                        ->get();
                                @endphp

                                @if ($relatedPosts->count() > 0)
                                    <div class="related-posts mb-3">
                                        <h5>Phương pháp nổi bật:</h5>
                                        <ul class="list-unstyled">
                                            @foreach ($relatedPosts as $post)
                                                <li class="mb-1">
                                                    <i class="fas fa-circle-notch text-primary small me-2"></i>
                                                    <a
                                                        href="{{ route('services.detail', $post->slug) }}">{{ $post->title }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <a href="{{ route('services.category', $category->slug) }}"
                                    class="btn btn-outline-primary mt-3">Xem tất cả</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Phương pháp nổi bật (nếu có) -->
            @if (isset($featuredServices) && count($featuredServices) > 0)
                <div class="featured-services mb-5">
                    <h2 class="section-title mb-4">Phương pháp điều trị nổi bật</h2>

                    <div class="row">
                        @foreach ($featuredServices as $service)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card service-card hover-card h-100">
                                    @if ($service->photo)
                                        <img src="{{ $service->photo }}" class="card-img-top" alt="{{ $service->title }}"
                                            style="height: 200px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $service->title }}</h5>
                                        <p class="card-text">{{ Str::limit($service->summary, 100) }}</p>
                                    </div>
                                    <div class="card-footer border-top-0 bg-transparent">
                                        <a href="{{ route('services.detail', $service->slug) }}"
                                            class="btn btn-primary w-100">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
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

        .category-icon {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }

        .text-primary {
            color: #1565c0 !important;
        }
    </style>
@endsection
