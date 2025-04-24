@extends('layouts.master')

@section('title', 'Danh Sách Bác Sĩ')

@section('main-content')
    <style>
        .search-bar {
            background: #f1f7ff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .search-bar input,
        .search-bar select {
            border: none;
            background: white;
            padding: 10px 14px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 200px;
        }

        .search-bar .search-btn {
            background: #1565c0;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 500;
            white-space: nowrap;
        }

        .search-bar .search-btn:hover {
            background: #0d47a1;
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 30px;
        }

        .filters select {
            flex: 1;
            min-width: 160px;
        }

        .doctor-card {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .doctor-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        .doctor-image {
            width: 100%;
            height: 240px;
            object-fit: cover;
            transition: transform 0.3s ease;
            background: #f9f9f9;
        }

        .doctor-card:hover .doctor-image {
            transform: scale(1.05);
        }

        .doctor-info {
            padding: 15px 20px;
        }

        .badge-rating {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #ff5e57;
            color: white;
            font-size: 0.85rem;
            padding: 4px 10px;
            border-radius: 8px;
        }

        .badge-available {
            background: #d4f8d4;
            color: #28a745;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            margin-left: 8px;
        }

        .doctor-fee {
            font-weight: bold;
            color: #e74c3c;
            font-size: 1.1rem;
        }

        .btn-book {
            background-color: #1565c0;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 500;
        }

        .btn-book:hover {
            background-color: #0d47a1;
        }

        .specialization-label {
            font-weight: 600;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.85rem;
        }

        .specialist-Psychologist {
            color: #9c27b0;
        }

        .specialist-Cardiologist {
            color: #e91e63;
        }

        .specialist-Dermatologist {
            color: #00bcd4;
        }

        .specialist-Pediatrician {
            color: #4caf50;
        }

        .specialist-Orthopedic {
            color: #ff9800;
        }

        .specialist-General {
            color: #1565c0;
        }
    </style>

    <div class="container mt-5">
        <h3 class="fw-bold mb-4 text-center" style="color: #2d3436;">Danh Sách Bác Sĩ</h3>

        <!-- Search bar -->
        <div class="search-bar d-flex align-items-center flex-wrap gap-3">
            <input type="text" class="form-control" placeholder="Tìm bác sĩ, bệnh viện...">
            <input type="text" class="form-control" placeholder="Địa điểm">
            <input type="date" class="form-control">
            <button class="search-btn">Tìm kiếm</button>
        </div>

        <!-- Filter section -->
        <div class="filters">
            <select class="form-select">
                <option selected>Chuyên khoa</option>
                <option>Tâm lý</option>
                <option>Da liễu</option>
                <option>Nhi khoa</option>
            </select>
            <select class="form-select">
                <option selected>Đánh giá</option>
                <option>Cao đến thấp</option>
                <option>Thấp đến cao</option>
            </select>
            <select class="form-select">
                <option selected>Phòng khám</option>
                <option>Clinic A</option>
                <option>Clinic B</option>
            </select>
            <select class="form-select">
                <option selected>Sắp xếp</option>
                <option>Giá thấp đến cao</option>
                <option>Giá cao đến thấp</option>
            </select>
        </div>

        <div class="row g-4">
            @foreach ($doctors as $doctor)
                <div class="col-md-6 col-lg-4">
                    <div class="doctor-card position-relative">
                        <div class="position-relative">
                            <span class="badge-rating">★ 5.0</span>
                            <img src="{{ $doctor->photo ?? asset('images/default-doctor.png') }}" alt="{{ $doctor->name }}"
                                class="doctor-image">
                        </div>
                        <div class="doctor-info">
                            <div class="d-flex align-items-center mb-2">
                                <span
                                    class="specialization-label specialist-{{ str_replace(' ', '', $doctor->specialization) }}">
                                    {{ $doctor->specialization }}
                                </span>
                                <span class="badge-available">Available</span>
                            </div>
                            <h5 class="fw-bold text-dark mb-1">{{ $doctor->name }}</h5>
                            <p class="text-muted mb-2">
                                <i class="bi bi-geo-alt"></i> Hà Nội &nbsp;&bull;&nbsp; 30 phút
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="doctor-fee">
                                    ${{ $doctor->fee ?? 650 }}
                                </div>
                                <a href="{{ route('doctor.detail', $doctor->id) }}" class="btn btn-book">
                                    Book Now
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $doctors->links() }}
        </div>
    </div>
@endsection
