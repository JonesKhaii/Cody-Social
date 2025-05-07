@extends('layouts.master')

@section('main-content')
    <div class="container py-5">

        {{-- Doctor Info --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <img src="{{ $doctor->photo ?? asset('images/default-doctor.png') }}" class="rounded-circle me-3"
                    style="width: 80px; height: 80px;">
                <div>
                    <h5 class="fw-bold mb-0">{{ $doctor->name }}</h5>
                    <small class="text-muted">{{ $doctor->specializations->pluck('name')->join(', ') }}</small><br>
                    <small class="text-muted"><i
                            class="fas fa-map-marker-alt me-1"></i>{{ $doctor->location ?? 'Không rõ' }}</small>
                </div>
                <span class="badge bg-danger ms-auto"><i class="fas fa-star me-1"></i>{{ $doctor->rating ?? '5.0' }}</span>
            </div>
        </div>

        <h4 class="fw-bold mb-4">Thông tin bệnh nhân</h4>

        <form action="{{ route('booking.confirm') }}" method="POST" id="info-form">
            @csrf

            {{-- Radio chọn người khám --}}
            <div class="mb-4">
                <label class="form-label fw-bold">Bạn đang đặt khám cho:</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="patient_type" id="self" value="self"
                        checked>
                    <label class="form-check-label" for="self">
                        Bản thân
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="patient_type" id="relative" value="relative">
                    <label class="form-check-label" for="relative">
                        Người thân
                    </label>
                </div>
            </div>

            {{-- Form thông tin người khám --}}
            <div class="mb-3">
                <label for="name" class="form-label">Họ và tên</label>
                <input type="text" name="name" id="name" class="form-control" required
                    value="{{ $user->name ?? '' }}">
            </div>

            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" name="phone" id="phone" class="form-control" required
                    value="{{ $user->phone ?? '' }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required
                    value="{{ $user->email ?? '' }}">
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('booking.datetime.get') }}" class="btn btn-outline-dark">
                    <i class="fas fa-arrow-left me-1"></i> Quay lại
                </a>
                <button type="submit" class="btn btn-primary">
                    Tiếp theo <i class="fas fa-arrow-right ms-1"></i>
                </button>
            </div>
        </form>
    </div>

    {{-- Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selfRadio = document.getElementById('self');
            const relativeRadio = document.getElementById('relative');

            const nameInput = document.getElementById('name');
            const phoneInput = document.getElementById('phone');
            const emailInput = document.getElementById('email');

            const defaultName = @json($user->name ?? '');
            const defaultPhone = @json($user->phone ?? '');
            const defaultEmail = @json($user->email ?? '');

            function togglePatientInfo() {
                if (selfRadio.checked) {
                    nameInput.value = defaultName;
                    phoneInput.value = defaultPhone;
                    emailInput.value = defaultEmail;
                } else {
                    nameInput.value = '';
                    phoneInput.value = '';
                    emailInput.value = '';
                }
            }

            selfRadio.addEventListener('change', togglePatientInfo);
            relativeRadio.addEventListener('change', togglePatientInfo);
        });
    </script>
@endsection
