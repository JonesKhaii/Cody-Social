@extends('layouts.master')

@section('main-content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Xác nhận đặt lịch khám</h2>

        {{-- Thông tin bác sĩ --}}
        <div class="card mb-3 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <img src="{{ $doctor->photo ?? asset('images/default-doctor.png') }}" class="rounded-circle me-3"
                    style="width: 80px; height: 80px;">
                <div>
                    <h5 class="fw-bold mb-0">{{ $doctor->name }}</h5>
                    <small class="text-muted">{{ $doctor->specializations->pluck('name')->join(', ') }}</small><br>
                    <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>
                        {{ $doctor->location ?? 'Không rõ địa chỉ' }}</small>
                </div>
                <span class="badge bg-danger ms-auto">
                    <i class="fas fa-star me-1"></i>{{ $doctor->rating ?? '5.0' }}
                </span>
            </div>
        </div>

        {{-- Thông tin đặt lịch --}}
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold">Thông tin đặt khám</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Chuyên khoa:</strong> {{ $specialization->name }}</li>
                    <li class="list-group-item"><strong>Dịch vụ:</strong> {{ $service->name }}</li>
                    <li class="list-group-item"><strong>Ngày khám:</strong> {{ $datetime['date'] }}</li>
                    <li class="list-group-item"><strong>Giờ khám:</strong> {{ $datetime['time'] }}</li>
                    <li class="list-group-item"><strong>Hình thức khám:</strong> {{ ucfirst($consultation_type) }}</li>
                </ul>
            </div>
        </div>

        {{-- Thông tin người khám --}}
        <div class="card mb-3 shadow-sm">
            <div class="card-body">
                <h5 class="fw-bold">Thông tin người khám</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Họ tên:</strong> {{ $info['name'] }}</li>
                    <li class="list-group-item"><strong>Số điện thoại:</strong> {{ $info['phone'] }}</li>
                    <li class="list-group-item"><strong>Email:</strong> {{ $info['email'] }}</li>
                    <li class="list-group-item"><strong>Đặt cho:</strong>
                        {{ $info['patient_type'] === 'self' ? 'Bản thân' : 'Người thân' }}
                    </li>
                </ul>
            </div>
        </div>

        <form action="{{ route('booking.confirm') }}" method="POST">
            @csrf
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check-circle me-1"></i> Xác nhận đặt lịch
                </button>
            </div>
        </form>
    </div>
@endsection
