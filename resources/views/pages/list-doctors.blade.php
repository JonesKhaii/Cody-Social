@extends('layouts.master')

@section('title', 'Danh Sách Bác Sĩ')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/list-doctor.css') }}">
@endsection

@section('main-content')
    <div class="container mt-5">
        <h3 class="fw-bold mb-4 text-center" style="color: #2d3436;">Danh Sách Bác Sĩ</h3>

        <!-- Filter Form -->
        <form action="{{ route('doctors.filter') }}" method="GET" class="filters d-flex mb-4 flex-wrap gap-3">

            <select class="form-select" name="specialization">
                <option value="">Tất cả chuyên khoa</option>
                @foreach ($specializations as $specialization)
                    <option value="{{ $specialization->id }}"
                        {{ request('specialization') == $specialization->id ? 'selected' : '' }}>
                        {{ $specialization->name }}
                    </option>
                @endforeach
            </select>

            <select class="form-select" name="rating">
                <option value="">Sắp xếp đánh giá</option>
                <option value="desc" {{ request('rating') == 'desc' ? 'selected' : '' }}>Cao đến thấp</option>
                <option value="asc" {{ request('rating') == 'asc' ? 'selected' : '' }}>Thấp đến cao</option>
            </select>

            <select class="form-select" name="fee">
                <option value="">Sắp xếp giá</option>
                <option value="asc" {{ request('fee') == 'asc' ? 'selected' : '' }}>Thấp đến cao</option>
                <option value="desc" {{ request('fee') == 'desc' ? 'selected' : '' }}>Cao đến thấp</option>
            </select>

            <input type="text" name="city" class="form-control" placeholder="Địa điểm" value="{{ request('city') }}">

            <button type="submit" class="btn btn-primary">Lọc</button>
        </form>


        <div class="row g-4">
            @foreach ($doctors as $doctor)
                <div class="col-md-6 col-lg-4">
                    <div class="doctor-card position-relative">
                        <div class="position-relative">
                            <span class="badge-rating">★ {{ $doctor->rating }}</span>
                            <img src="{{ $doctor->photo ?? asset('images/default-doctor.png') }}"
                                alt="{{ $doctor->name }}" class="doctor-image">
                        </div>
                        <div class="doctor-info">
                            <div class="d-flex align-items-center mb-2">
                                @foreach ($doctor->specializations as $spec)
                                    <span class="specialization-label specialist-{{ str_replace(' ', '', $spec->name) }}">
                                        {{ $spec->name }}
                                    </span>
                                @endforeach
                                <span class="badge-available ms-2">Available</span>
                            </div>

                            <div class="row mb-2">
                                <div class="col-8">
                                    <h5 class="fw-bold text-dark mb-1">{{ $doctor->name }}</h5>
                                    <p class="text-muted d-flex align-items-center mb-0">
                                        <i class="fa-solid fa-location-dot me-1"></i> {{ $doctor->city }}
                                        &nbsp;&bull;&nbsp; 30 phút
                                    </p>
                                </div>
                                <div class="col-4 text-start">
                                    <span class="span-fee">Phí tư vấn</span>
                                    <div class="doctor-fee fw-bold">
                                        Từ {{ number_format($doctor->consultation_fee ?? 650, 0, ',', '.') }} VND
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center">
                                <div class="btn-book d-flex ms-auto">
                                    <a href="{{ route('doctor.detail', $doctor->id) }}"
                                        class="btn btn-outline-primary flex-grow-1 me-2 text-center">
                                        Thông tin
                                    </a>
                                    <button type="button"
                                        class="btn btn-primary btn-open-booking-modal"
                                        data-doctor-id="{{ $doctor->id }}"
                                        data-doctor-name="{{ $doctor->name }}"
                                        data-doctor-photo="{{ $doctor->photo }}"
                                        data-doctor-specialization="{{ $doctor->specializations->pluck('name')->join(', ') }}">
                                        Đặt lịch
                                    </button>
                                </div>
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

    @include('pages.booking-appointment')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookingButtons = document.querySelectorAll('.btn-open-booking-modal');

            bookingButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    const doctorId = this.dataset.doctorId;
                    const doctorName = this.dataset.doctorName;
                    const doctorPhoto = this.dataset.doctorPhoto;
                    const doctorSpec = this.dataset.doctorSpecialization;

                    document.getElementById('selected_doctor_id').value = doctorId;
                    document.getElementById('selected-doctor-name').textContent = 'Bs. ' +
                        doctorName;
                    document.getElementById('selected-doctor-specialization').textContent =
                        doctorSpec;
                    document.getElementById('selected-doctor-img').src = doctorPhoto;
                    document.getElementById('selected-doctor-info').style.display = 'block';

                    const modal = new bootstrap.Modal(document.getElementById(
                        'bookAppointmentModal'));
                    modal.show();
                });
            });
        });
    </script>
@endsection
