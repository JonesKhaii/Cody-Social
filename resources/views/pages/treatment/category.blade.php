@extends('layouts.master')

@section('main-content')
    <div class="treatment-category-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Phương pháp điều trị</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>

            <h1 class="mb-2">{{ $category->name }}</h1>
            <p class="lead mb-5">{{ $category->summary }}</p>

            <!-- Danh mục con (nếu có) -->
            @if (isset($subcategories) && $subcategories->count() > 0)
                <div class="subcategories mb-5">
                    <h3 class="section-title mb-4">Loại phương pháp</h3>
                    <div class="row">
                        @foreach ($subcategories as $subcategory)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card subcategory-card hover-card h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="subcategory-icon bg-light rounded-circle me-3 p-2">
                                                <i class="{{ $subcategory->icon ?? 'fas fa-microscope' }} text-primary"></i>
                                            </div>
                                            <h4 class="subcategory-title mb-0">{{ $subcategory->name }}</h4>
                                        </div>
                                        <p class="card-text">
                                            {{ $subcategory->summary ?? 'Khám phá phương pháp điều trị tiên tiến' }}</p>
                                    </div>
                                    <div class="card-footer border-top-0 bg-transparent">
                                        <a href="{{ route('services.category', $subcategory->slug) }}"
                                            class="btn btn-outline-primary w-100">Xem chi tiết</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Danh sách bài viết thuộc danh mục -->
            <div class="services-list">
                <h3 class="section-title mb-4">Phương pháp điều trị</h3>

                @if (isset($services) && count($services) > 0)
                    <div class="row">
                        @foreach ($services as $service)
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card service-card hover-card h-100">
                                    @if ($service->photo)
                                        <img src="{{ $service->photo }}" class="card-img-top" alt="{{ $service->title }}"
                                            style="height: 200px; object-fit: cover;">
                                    @else
                                        <div class="placeholder-img bg-light d-flex align-items-center justify-content-center"
                                            style="height: 200px;">
                                            <i class="fas fa-procedures fa-3x text-primary"></i>
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $service->title }}</h5>
                                        <p class="card-text">{{ Str::limit($service->summary, 150) }}</p>
                                    </div>
                                    <div class="card-footer border-top-0 bg-transparent">
                                        <a href="{{ route('services.detail', $service->slug) }}"
                                            class="btn btn-primary w-100">Chi tiết phương pháp</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Phân trang -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $services->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        Chưa có phương pháp điều trị nào trong danh mục này. Vui lòng quay lại sau.
                    </div>
                @endif
            </div>

            <!-- Xem thêm các danh mục khác -->
            <div class="explore-more-section bg-light mt-5 rounded p-4 text-center">
                <h3>Xem thêm các phương pháp điều trị khác</h3>
                <p class="mb-4">Khám phá thêm các danh mục phương pháp điều trị</p>

                <div class="row justify-content-center">
                    @php
                        $otherCategories = \App\Models\Category::where('parent_id', $category->parent_id)
                            ->where('id', '!=', $category->id)
                            ->take(3)
                            ->get();
                    @endphp

                    @foreach ($otherCategories as $otherCategory)
                        <div class="col-md-3 col-6 mb-3">
                            <a href="{{ route('services.category', $otherCategory->slug) }}"
                                class="btn btn-outline-primary w-100">{{ $otherCategory->name }}</a>
                        </div>
                    @endforeach

                    <div class="col-md-3 col-6 mb-3">
                        <a href="{{ route('services.index') }}" class="btn btn-primary w-100">Xem tất cả</a>
                    </div>
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

        .subcategory-icon {
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-title {
            position: relative;
            padding-bottom: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background-color: #1565c0;
        }

        .text-primary {
            color: #1565c0 !important;
        }
    </style>
@endsection
