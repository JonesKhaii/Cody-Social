@extends('layouts.master')

@section('title', 'Danh Sách Bác Sĩ')

@section('main-content')
    <style>
        .doctor-card {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .doctor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .profile-photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 15px;
            border: 3px solid #f8f9fa;
        }

        .doctor-card h5 {
            margin-bottom: 5px;
            color: #2d3436;
        }

        .doctor-card h5 a {
            color: #2d3436;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .doctor-card h5 a:hover {
            color: #0056b3;
        }

        .doctor-card p {
            color: #636e72;
            margin-bottom: 0;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: #0984e3;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }

        .btn-outline-success {
            color: #00b894;
            border-color: #00b894;
            transition: all 0.3s ease;
        }

        .btn-outline-success:hover {
            background: #00b894;
            color: white;
            transform: translateY(-2px);
        }

        .pagination {
            margin-top: 2rem;
        }
    </style>

    <div class="container mt-5">
        <h3 class="fw-bold mb-4 text-center" style="color: #2d3436;">Danh Sách Bác Sĩ</h3>

        <div class="row g-4">
            @foreach ($doctors as $doctor)
                <div class="col-md-4">
                    <div class="doctor-card">
                        <div class="d-flex align-items-center">
                            <img src="{{ $doctor->photo }}"
                                class="profile-photo"
                                alt="{{ $doctor->name }}">
                            <div>
                                <h5>
                                    <a href="{{ route('doctor.detail', $doctor->id) }}">{{ $doctor->name }}</a>
                                </h5>
                                <p>{{ $doctor->specialization }}</p>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <a href="{{ route('doctor.detail', $doctor->id) }}" class="btn btn-primary w-50 me-2 py-2">
                                Xem Hồ Sơ
                            </a>
                            <button class="btn btn-outline-success w-50 follow-btn py-2" data-doctor="{{ $doctor->name }}">
                                Follow
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>


        <div class="d-flex justify-content-center">
            {{ $doctors->links() }}
        </div>
    </div>
@endsection
