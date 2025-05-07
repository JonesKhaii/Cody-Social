@extends('layouts.master')

@section('main-content')
    <div class="container py-5">
        <!-- Thông báo lỗi -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Bác sĩ -->
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

        <!-- Chuyên khoa -->
        <form action="{{ route('booking.appointmentType') }}" method="POST">
            @csrf
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Chọn chuyên khoa</h5>

                    <div class="mb-4">
                        <select name="specialization_id" class="form-select" id="specialization-select" required>
                            <option value="">-- Chọn chuyên khoa --</option>
                            @foreach ($specialties as $id => $name)
                                <option value="{{ $id }}" {{ old('specialization_id') == $id ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <hr>

                    <h5 class="fw-bold mb-3">Các dịch vụ</h5>
                    <div class="row g-3" id="services-list">
                        {{-- sẽ được render bằng JS --}}
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ session('booking.previous_url', route('home')) }}" class="btn btn-outline-dark">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Chọn phương thức <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        .service-select input:checked+* {
            border-color: #0d6efd !important;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .25);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const specializationSelect = document.getElementById('specialization-select');
            const servicesContainer = document.getElementById('services-list');

            const selectedServiceId = '{{ old('service_id') }}';

            if (specializationSelect.value) {
                loadServices(specializationSelect.value);
            }

            specializationSelect.addEventListener('change', function() {
                loadServices(this.value);
            });

            function loadServices(specId) {
                servicesContainer.innerHTML = '<p>Đang tải dịch vụ...</p>';

                if (!specId) {
                    servicesContainer.innerHTML = '<p>Vui lòng chọn chuyên khoa.</p>';
                    return;
                }

                fetch(`/booking/services-by-specialization/${specId}`)
                    .then(res => res.json())
                    .then(services => {
                        if (services.length === 0) {
                            servicesContainer.innerHTML = '<p>Không có dịch vụ nào cho chuyên khoa này.</p>';
                            return;
                        }

                        let html = '';
                        services.forEach(service => {
                            const checked = service.service_id == selectedServiceId ? 'checked' : '';
                            html += `
                                <div class="col-md-4">
                                    <label class="w-100 d-block position-relative service-select rounded border p-3 text-start">
                                        <input type="radio" name="service_id" value="${service.service_id}" required
                                            class="form-check-input position-absolute end-0 top-0 m-2" ${checked}>
                                        <div class="fw-bold">${service.name}</div>
                                        <div class="text-muted">${Number(service.price).toLocaleString()} VND</div>
                                    </label>
                                </div>
                            `;
                        });
                        servicesContainer.innerHTML = html;
                    })
                    .catch(() => {
                        servicesContainer.innerHTML =
                            '<p class="text-danger">Lỗi tải dịch vụ. Vui lòng thử lại.</p>';
                    });
            }
        });
    </script>
@endsection
