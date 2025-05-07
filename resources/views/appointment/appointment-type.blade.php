@extends('layouts.master')

@section('main-content')
    <div class="container py-5">
        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <img src="{{ $doctor->photo ?? asset('images/default-doctor.png') }}" class="rounded-circle me-3"
                    style="width: 80px; height: 80px;">
                <div>
                    <h5 class="fw-bold mb-0">{{ $doctor->name }}</h5>
                    <small class="text-muted">
                        {{ $doctor->specializations->pluck('name')->join(', ') }}
                    </small><br>
                    <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>
                        {{ $doctor->location ?? 'Không rõ địa chỉ' }}</small>
                </div>
                <span class="badge bg-danger ms-auto"><i class="fas fa-star me-1"></i>{{ $doctor->rating ?? '5.0' }}</span>
            </div>
        </div>

        <h4 class="fw-bold mb-4">Chọn loại hình khám bệnh</h4>
        <form action="{{ route('booking.datetime') }}" method="POST">
            @csrf
            <div class="row g-3">
                @foreach ([
            'Online' => 'Tư vấn trực tuyến',
            'Ofline' => 'Khám tại phòng khám',
            'At Home' => 'Khám tại nhà',
        ] as $value => $label)
                    <div class="col-md-4">
                        <label class="w-100 d-block position-relative rounded border p-3">
                            <input type="radio" name="consultation_type" value="{{ $value }}"
                                class="form-check-input position-absolute end-0 top-0 m-2" required>
                            <strong>{{ $label }}</strong>
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route(session('booking.back_to.route'), session('booking.back_to.params', [])) }}"
                    class="btn btn-outline-dark">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-primary">
                    Tiếp theo <i class="fas fa-arrow-right ms-1"></i>
                </button>
            </div>
        </form>
    </div>
@endsection
