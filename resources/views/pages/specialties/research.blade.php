@extends('layouts.master')

@section('main-content')
    <div class="research-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('specialties.index') }}">Chuyên môn bác sĩ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Thành tựu & Nghiên cứu</li>
                </ol>
            </nav>

            <h1 class="mb-2">Thành tựu & Nghiên cứu</h1>
            <p class="lead mb-5">Khám phá các công trình nghiên cứu y học và báo cáo ca lâm sàng đặc biệt từ đội ngũ y bác
                sĩ</p>

            <!-- Lọc nghiên cứu -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <form method="GET" action="{{ route('specialties.research') }}" class="row g-3">
                        <div class="col-md-4">
                            <label for="researchType" class="form-label">Loại nghiên cứu</label>
                            <select class="form-select" id="researchType" name="type">
                                <option value="">Tất cả</option>
                                @foreach ($researchCategories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('type') == $category->id ? 'selected' : '' }}>{{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="researchYear" class="form-label">Năm công bố</label>
                            <select class="form-select" id="researchYear" name="year">
                                <option value="">Tất cả</option>
                                @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                        {{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Lọc nghiên cứu</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Danh sách nghiên cứu -->
            <div class="research-list">
                @if (count($researches) > 0)
                    @foreach ($researches as $research)
                        <div class="card research-card hover-card mb-4">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-9">
                                        @if ($research->cat_info)
                                            <span class="badge bg-primary mb-2">{{ $research->cat_info->title }}</span>
                                        @endif
                                        <h4 class="card-title">{{ $research->title }}</h4>
                                        <div class="authors mb-3">
                                            <span class="text-muted">Tác giả:</span>
                                            <span class="fw-bold">{{ $research->author_info->name ?? 'Bác sĩ' }}</span>
                                            @if (isset($research->meta_data['co_authors']))
                                                @foreach ($research->meta_data['co_authors'] as $coAuthor)
                                                    , {{ $coAuthor }}
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="abstract mb-3">
                                            <p>{{ Str::limit($research->summary, 250) }}</p>
                                        </div>
                                        <div class="research-meta d-flex flex-wrap">
                                            <div class="mb-2 me-4">
                                                <i class="far fa-calendar-alt text-primary me-1"></i>
                                                <span>{{ isset($research->meta_data['publish_date']) ? date('d/m/Y', strtotime($research->meta_data['publish_date'])) : $research->created_at->format('d/m/Y') }}</span>
                                            </div>
                                            @if (isset($research->meta_data['journal']))
                                                <div class="mb-2 me-4">
                                                    <i class="far fa-newspaper text-primary me-1"></i>
                                                    <span>{{ $research->meta_data['journal'] }}</span>
                                                </div>
                                            @endif
                                            @if (isset($research->meta_data['doi']))
                                                <div class="mb-2">
                                                    <i class="fas fa-link text-primary me-1"></i>
                                                    <span>DOI: {{ $research->meta_data['doi'] }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-lg-3 d-flex align-items-center">
                                        <div class="w-100 text-center">
                                            <a href="{{ route('post.detail', $research->slug) }}"
                                                class="btn btn-outline-primary w-100 mb-2">Xem chi tiết</a>
                                            @if (isset($research->meta_data['document_url']))
                                                <a href="{{ $research->meta_data['document_url'] }}"
                                                    class="btn btn-outline-secondary w-100" download>
                                                    <i class="fas fa-download me-1"></i> Tải PDF
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Phân trang -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $researches->appends(request()->except('page'))->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        Không tìm thấy nghiên cứu nào phù hợp với tiêu chí tìm kiếm. Vui lòng thử lại với tiêu chí khác.
                    </div>
                @endif
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
    </style>
@endsection
