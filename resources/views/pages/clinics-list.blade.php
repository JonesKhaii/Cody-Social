@extends('layouts.master')

@section('main-content')
    <div class="clinics-list-page py-5">
        <div class="container-clinic container">
            <!-- Tiêu đề trang -->
            <div class="page-header mb-4">
                <h1 class="page-title">Bệnh viện & Phòng khám</h1>
                <p class="page-description text-muted">Tìm kiếm cơ sở y tế phù hợp</p>
            </div>

            <!-- Bộ lọc đơn giản -->
            <div class="filter-section card mb-4 shadow-sm">
                <div class="card-body">
                    <form action="{{ route('clinics.list') }}" method="GET" class="row g-3">
                        <div class="col-md-5">
                            <label for="type" class="form-label">Loại cơ sở</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">Tất cả</option>
                                <option value="Bệnh viện" {{ request('type') == 'Bệnh viện' ? 'selected' : '' }}>Bệnh viện
                                </option>
                                <option value="Phòng khám" {{ request('type') == 'Phòng khám' ? 'selected' : '' }}>Phòng
                                    khám</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address"
                                placeholder="Nhập địa chỉ..." value="{{ request('address') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Thông tin số lượng kết quả -->
            <div class="results-info text-muted mb-3">
                Hiển thị {{ $clinics->firstItem() ?? 0 }} đến {{ $clinics->lastItem() ?? 0 }} của {{ $clinics->total() }}
                kết quả
            </div>

            <div class="clinic-list">
                @if ($clinics->count() > 0)
                    @foreach ($clinics as $clinic)
                        <div class="card clinic-card mb-3 shadow-sm">
                            <div class="row g-0">
                                <!-- Hình ảnh - Kích thước nhỏ hơn và bo tròn -->
                                <div class="col-md-2">
                                    <div class="clinic-image-container">
                                        @if ($clinic->photo)
                                            <img src="{{ $clinic->photo_url }}" class="clinic-image"
                                                alt="{{ $clinic->name }}">
                                        @else
                                            <div class="clinic-placeholder">
                                                <i
                                                    class="fas {{ $clinic->type == 'Bệnh viện' ? 'fa-hospital' : 'fa-clinic-medical' }} fa-2x text-secondary"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Thông tin -->
                                <div class="col-md-10">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h5 class="card-title mb-0">{{ $clinic->name }}</h5>
                                            <span
                                                class="badge {{ $clinic->type == 'Bệnh viện' ? 'bg-primary' : 'bg-info' }}">
                                                {{ $clinic->type }}
                                            </span>
                                        </div>

                                        <p class="clinic-address mb-2">
                                            <i class="fas fa-map-marker-alt text-secondary me-2"></i>
                                            {{ $clinic->address }}
                                        </p>

                                        @if ($clinic->phone)
                                            <p class="clinic-contact mb-2">
                                                <i class="fas fa-phone-alt text-secondary me-2"></i>
                                                {{ $clinic->phone }}
                                            </p>
                                        @endif

                                        <div class="clinic-actions mt-2 text-end">
                                            <a href="{{ route('clinics.detail', $clinic->slug) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="fas fa-info-circle me-1"></i> Xem chi tiết
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <!-- Phân trang - Sửa lỗi pagination -->
                    <div class="pagination-container d-flex justify-content-center mt-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination">
                                <!-- Nút Previous -->
                                @if ($clinics->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $clinics->previousPageUrl() }}"
                                            aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                @endif

                                <!-- Các trang -->
                                @for ($i = 1; $i <= $clinics->lastPage(); $i++)
                                    <li class="page-item {{ $clinics->currentPage() == $i ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $clinics->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                <!-- Nút Next -->
                                @if ($clinics->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $clinics->nextPageUrl() }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link">&raquo;</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Không tìm thấy kết quả nào. Vui lòng thử lại với các tiêu
                        chí khác.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        /* Container có chiều rộng tối đa */
        container-clinic {
            max-width: 980px;
            !important;
        }

        /* Thiết kế cho hình ảnh */
        .clinic-image-container {
            width: 100%;
            padding: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .clinic-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .clinic-placeholder {
            width: 120px;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Card style */
        .clinic-card {
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .clinic-card:hover {
            transform: translateY(-3px);
        }

        /* Responsive */
        @media (max-width: 768px) {

            .clinic-image,
            .clinic-placeholder {
                width: 90px;
                height: 90px;
            }

            .col-md-2 {
                width: 30%;
            }

            .col-md-10 {
                width: 70%;
            }
        }

        /* Kiểu dáng cho pagination */
        .pagination .page-link {
            color: #0d6efd;
            background-color: #fff;
            border: 1px solid #dee2e6;
            padding: 0.375rem 0.75rem;
        }

        .pagination .page-item.active .page-link {
            background-color: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .pagination .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #fff;
            border-color: #dee2e6;
        }
    </style>
@endsection
