@extends('layouts.master')
@section('title', 'Lịch khám')
@section('page_css')
    <link rel="stylesheet" href="{{ asset('css/appointment-user.css') }}">
@endsection
@section('main-content')
    <div class="appointment-section container">

        <div class="appointment-tabs">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Lịch Khám Của Tôi</h2>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookAppointmentModal">
                    <i class="fas fa-plus-circle me-2"></i>Đặt lịch khám
                </button>
            </div>

            <!-- Tab filter -->
            <div class="tab-container">
                <ul class="nav nav-pills appointment-filters">
                    @foreach (['Sắp tới' => 'confirmed', 'Chờ duyệt' => 'pending', 'Hoàn thành' => 'completed', 'Đã huỷ' => 'canceled'] as $label => $tab)
                        <li class="nav-item">
                            <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="pill"
                                href="#{{ $tab }}">
                                {{ $label }}
                                @if ($appointments->where('status', $label)->count() > 0)
                                    <span class="badge">{{ $appointments->where('status', $label)->count() }}</span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>

                <div class="appointment-date-filter">
                    <div class="d-flex align-items-center">
                        <button class="btn btn-outline-secondary btn-sm date-filter-btn">
                            <i class="fas fa-calendar me-2"></i>
                            <span id="selected-date-range">Tuần này</span>
                            <i class="fas fa-chevron-down ms-2"></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-sm filter-btn ms-2">
                            <i class="fas fa-filter"></i>
                            <span class="ms-1">Lọc</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Phần nội dung các tab -->
        <div class="tab-content">
            @foreach (['Sắp tới' => 'confirmed', 'Chờ duyệt' => 'pending', 'Hoàn thành' => 'completed', 'Đã huỷ' => 'canceled'] as $label => $tab)
                <div id="{{ $tab }}" class="tab-pane fade {{ $loop->first ? 'show active' : '' }}">
                    @if ($appointments->where('status', $label)->count() > 0)
                        <div class="appointment-list">
                            @foreach ($appointments->where('status', $label) as $appointment)
                                <div class="appointment-card">
                                    <div class="appointment-left">
                                        <div class="doctor-avatar">
                                            <img src="{{ $appointment->doctor->photo ?? '/images/default-avatar.png' }}"
                                                alt="{{ $appointment->doctor->name }}">
                                            @if ($label == 'Sắp tới')
                                                <span class="status-indicator online"></span>
                                            @endif
                                        </div>
                                        <div class="appointment-info">
                                            <div class="appointment-id">
                                                #APT{{ str_pad($appointment->id, 4, '0', STR_PAD_LEFT) }}</div>
                                            <h5 class="doctor-name">BS. {{ $appointment->doctor->name }}</h5>
                                            <div class="appointment-type">
                                                <span
                                                    class="badge {{ $appointment->consultation_type === 'online' ? 'badge-videocall' : 'badge-visit' }}">
                                                    <i
                                                        class="fas fa-{{ $appointment->consultation_type === 'online' ? 'video' : 'clinic-medical' }}"></i>
                                                    {{ $appointment->consultation_type === 'online' ? 'Tư vấn trực tuyến' : 'Khám tại phòng khám' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="appointment-center">
                                        <div class="appointment-date">
                                            <i class="far fa-calendar-alt meta-icon"></i>
                                            <strong>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</strong>
                                        </div>
                                        <div class="appointment-time meta-icon">
                                            <i class="far fa-clock"></i>
                                            {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                                        </div>
                                    </div>

                                    <div class="appointment-contact">
                                        <div class="contact-email">
                                            <i class="far fa-envelope"></i>
                                            {{ $appointment->doctor->email ?? 'doctor@example.com' }}
                                        </div>
                                        <div class="contact-phone">
                                            <i class="fas fa-phone-alt"></i>
                                            {{ $appointment->doctor->phone ?? '+84 123 456 789' }}
                                        </div>
                                    </div>

                                    <div class="appointment-actions">
                                        <a href="javascript:void(0);" class="btn-details"
                                            onclick="showAppointmentDetails({{ $appointment->id }})">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('doctor.detail', $appointment->doctor->id) }}"
                                            class="btn-profile">
                                            <i class="fas fa-user-md"></i>
                                        </a>
                                        <a href="#" class="btn-message">
                                            <i class="fas fa-comment-alt"></i>
                                        </a>

                                        @if ($label == 'Sắp tới' && $appointment->consultation_type === 'online')
                                            <a href="{{ route('video-call', $appointment->id) }}"
                                                class="btn btn-primary attend-btn">
                                                <i class="fas fa-video me-1"></i> Tham gia
                                            </a>
                                        @endif

                                        @if ($label == 'Chờ duyệt')
                                            <form action="{{ route('user.appointments.cancel', $appointment->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-outline-danger">
                                                    <i class="fas fa-times me-1"></i>Hủy lịch
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-state-icon">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <h4>Không có lịch khám {{ strtolower($label) }}</h4>
                            <p>Bạn có thể đặt lịch mới bằng cách nhấn nút "Đặt lịch khám"</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#bookAppointmentModal">
                                <i class="fas fa-plus-circle me-2"></i>Đặt lịch khám ngay
                            </button>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Đặt lịch khám -->
    <div class="modal fade" id="bookAppointmentModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Đặt lịch khám</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('user.book.appointment') }}" method="POST" id="appointmentForm">
                        @csrf

                        <div class="row g-3">
                            <!-- Tìm kiếm bác sĩ -->
                            <div class="col-md-12">
                                <label class="form-label">Tìm kiếm bác sĩ</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="search-doctor"
                                        placeholder="Nhập tên bác sĩ hoặc chuyên khoa...">
                                    <button class="btn btn-primary" type="button" id="search-doctor-btn">Tìm
                                        kiếm</button>
                                </div>
                            </div>

                            <!-- Kết quả tìm kiếm bác sĩ -->
                            <div class="col-md-12">
                                <div id="search-results" class="row g-3"
                                    style="display: none; max-height: 300px; overflow-y: auto;">
                                    <!-- Kết quả tìm kiếm sẽ được thêm vào đây bằng JavaScript -->
                                </div>
                            </div>

                            <!-- Input ẩn để lưu doctor_id -->
                            <input type="hidden" name="doctor_id" id="selected_doctor_id" required>

                            <!-- Bác sĩ đã chọn -->
                            <div class="col-md-12 mb-3" id="selected-doctor-info" style="display: none;">
                                <div class="card border-success">
                                    <div class="card-header bg-success text-white">Bác sĩ đã chọn</div>
                                    <div class="card-body d-flex align-items-center">
                                        <img id="selected-doctor-img" src="" alt="Bác sĩ đã chọn"
                                            class="rounded-circle object-fit-cover doctor-avatar me-3" width="60"
                                            height="60">
                                        <div>
                                            <h6 id="selected-doctor-name" class="mb-1"></h6>
                                            <p id="selected-doctor-specialization" class="text-muted small mb-0"></p>
                                        </div>
                                        <div class="ms-auto">
                                            <button type="button" class="btn btn-sm btn-outline-info me-2"
                                                id="view-selected-doctor-info">
                                                <i class="bi bi-info-circle"></i> Xem thông tin
                                            </button>
                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                id="clear-doctor-selection">
                                                <i class="bi bi-x-lg"></i> Bỏ chọn
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Danh sách bác sĩ nổi bật -->
                            <div class="col-md-12">
                                <h6 class="form-label fw-bold mb-3">Bác sĩ nổi bật</h6>
                                <div class="row g-3" id="featured-doctors">
                                    @foreach ($doctors as $doctor)
                                        <div class="col-md-4 mb-3">
                                            <div class="card h-100 doctor-card" data-doctor-id="{{ $doctor->id }}">
                                                <div class="card-body text-center">
                                                    <img src="{{ $doctor->photo }}"
                                                        alt="{{ $doctor->name }}"
                                                        class="rounded-circle object-fit-cover doctor-avatar mb-3"
                                                        width="80" height="80">
                                                    <h6 class="card-title">Bs. {{ $doctor->name }}</h6>
                                                    <p class="card-text text-muted small">{{ $doctor->specialization }}
                                                    </p>
                                                    <div class="d-flex justify-content-center">
                                                        <span class="badge bg-primary me-1">
                                                            <i class="bi bi-star-fill"></i> 4.8
                                                        </span>
                                                        <span class="badge bg-light text-dark">
                                                            <i class="bi bi-people-fill"></i> 120+ bệnh nhân
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="card-footer bg-light p-2 text-center">
                                                    <div class="btn-group btn-group-sm w-100">
                                                        <button type="button"
                                                            class="btn btn-outline-info view-doctor-info-btn"
                                                            data-doctor-id="{{ $doctor->id }}"
                                                            data-doctor-name="{{ $doctor->name }}"
                                                            data-doctor-specialization="{{ $doctor->specialization }}"
                                                            data-doctor-photo="{{ $doctor->photo }}">
                                                            <i class="bi bi-info-circle"></i> Xem thông tin
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-outline-primary select-doctor-btn"
                                                            data-doctor-id="{{ $doctor->id }}"
                                                            data-doctor-name="{{ $doctor->name }}"
                                                            data-doctor-specialization="{{ $doctor->specialization }}"
                                                            data-doctor-photo="{{ $doctor->photo }}">
                                                            <i class="bi bi-check-circle"></i> Chọn
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Hình thức khám -->
                            <div class="col-md-6">
                                <label class="form-label">Hình thức khám</label>
                                <select name="consultation_type" class="form-select" required>
                                    <option value="Offline">Khám tại phòng khám</option>
                                    <option value="Online">Tư vấn trực tuyến</option>
                                    <option value="At Home">Khám tại nhà</option>
                                </select>
                            </div>

                            <!-- Ngày và Giờ khám -->
                            <div class="col-md-6">
                                <label class="form-label">Ngày khám</label>
                                <input type="date" name="date" class="form-control" required
                                    min="{{ date('Y-m-d') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Giờ khám</label>
                                <select name="time" class="form-select" required>
                                    <option value="">-- Chọn giờ --</option>
                                    @foreach (['08:00', '09:00', '10:00', '14:00', '15:00', '16:00'] as $time)
                                        <option value="{{ $time }}">{{ $time }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Lý do khám -->
                            <div class="col-12">
                                <label class="form-label">Lý do khám</label>
                                <textarea name="notes" class="form-control" rows="3" placeholder="Mô tả triệu chứng, lý do khám..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" form="appointmentForm" class="btn btn-primary">Đặt lịch</button>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Thông tin chi tiết bác sĩ -->
    <div class="modal fade" id="doctorInfoModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="doctor-info-title">Thông tin bác sĩ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-4 text-center">

                        <img id="doctor-info-img" src="{{ $doctor->photo }}" alt="Bác sĩ"
                            class="rounded-circle object-fit-cover doctor-avatar mb-3"
                            width="100" height="100">
                        <h5 id="doctor-info-name" class="mb-1"></h5>
                        <p id="doctor-info-specialization" class="text-muted"></p>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h4 class="card-title text-primary">4.8</h4>
                                    <p class="card-text">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-half text-warning"></i>
                                    </p>
                                    <p class="card-text small">120+ đánh giá</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h4 class="card-title text-primary">8+</h4>
                                    <p class="card-text">Năm kinh nghiệm</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6 class="fw-bold">Chuyên môn</h6>
                    <ul class="mb-3">
                        <li>Khám và điều trị các bệnh lý chuyên khoa</li>
                        <li>Tư vấn dinh dưỡng và phòng ngừa bệnh</li>
                        <li>Theo dõi và quản lý bệnh mãn tính</li>
                    </ul>

                    <h6 class="fw-bold">Học vấn & Chứng chỉ</h6>
                    <ul class="mb-3">
                        <li>Bác sĩ Đa khoa - Đại học Y Hà Nội</li>
                        <li>Chứng chỉ chuyên khoa cấp 1</li>
                        <li>Thành viên Hội Y học Việt Nam</li>
                    </ul>

                    <div class="d-grid">
                        <button type="button" class="btn btn-primary select-from-info-btn">
                            <i class="bi bi-calendar-check"></i> Đặt lịch với bác sĩ này
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Chi Tiết Lịch khám -->
    <div id="appointment-details-modal" class="modal fade">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-white">
                    <h5 class="modal-title"><i class="fas fa-calendar-check me-2"></i>Chi tiết lịch khám</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body" id="appointment-details-content">
                    <p>Đang tải thông tin...</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Chi Tiết Lịch khám -->
    {{-- <div id="appointment-details-modal" class="modal fade">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-calendar-check me-2"></i>Chi tiết lịch khám</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0" id="appointment-details-content">
                    <div class="appointment-detail-loading" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Đang tải...</span>
                        </div>
                        <p class="mt-2">Đang tải thông tin...</p>
                    </div>

                    <div class="appointment-detail-content">
                        <!-- Header với thông tin bác sĩ -->
                        <div class="appointment-detail-header">
                            <div class="doctor-info">
                                <img id="detail-doctor-avatar" src="" alt="Doctor Avatar" class="doctor-avatar">
                                <div>
                                    <h4 id="detail-doctor-name" class="mb-1"></h4>
                                    <p id="detail-doctor-specialization" class="text-muted mb-1"></p>
                                    <div class="doctor-rating">
                                        <span class="stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </span>
                                        <span class="rating-value">4.8</span>
                                        <span class="rating-count">(120+ đánh giá)</span>
                                    </div>
                                </div>
                            </div>
                            <div class="appointment-status">
                                <span id="detail-status-badge" class="status-badge">Hoàn thành</span>
                            </div>
                        </div>

                        <!-- Thông tin chính của lịch khám -->
                        <div class="appointment-main-info">
                            <div class="info-row">
                                <div class="info-label"><i class="fas fa-hashtag"></i> Mã lịch khám:</div>
                                <div id="detail-appointment-id" class="info-value"></div>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><i class="fas fa-calendar-day"></i> Ngày khám:</div>
                                <div id="detail-date" class="info-value"></div>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><i class="fas fa-clock"></i> Giờ khám:</div>
                                <div id="detail-time" class="info-value"></div>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><i class="fas fa-stethoscope"></i> Hình thức:</div>
                                <div id="detail-type" class="info-value"></div>
                            </div>
                            <div class="info-row">
                                <div class="info-label"><i class="fas fa-sticky-note"></i> Ghi chú:</div>
                                <div id="detail-notes" class="info-value"></div>
                            </div>
                        </div>

                        <!-- Thông tin liên hệ bác sĩ -->
                        <div class="appointment-contact-info">
                            <h5 class="section-title">Thông tin liên hệ</h5>
                            <div class="contact-details">
                                <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <span id="detail-email"></span>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-phone-alt"></i>
                                    <span id="detail-phone"></span>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span id="detail-address">Phòng khám Cody Health, 123 Đường ABC, Quận 1, TP.HCM</span>
                                </div>
                            </div>
                        </div>

                        <!-- Nội dung kết quả (nếu có) -->
                        <div id="appointment-results" class="appointment-results">
                            <h5 class="section-title">Kết quả khám</h5>
                            <div class="results-content" id="detail-results">
                                <div class="alert alert-info">
                                    Kết quả khám sẽ được cập nhật sau khi buổi khám kết thúc.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="actions-left">
                        <a href="#" class="btn btn-outline-primary btn-sm" id="detail-download-btn">
                            <i class="fas fa-download me-1"></i> Tải kết quả
                        </a>
                    </div>
                    <div class="actions-right">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <a href="#" class="btn btn-primary" id="detail-action-btn">
                            <i class="fas fa-video me-1"></i> Tham gia cuộc hẹn
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lưu danh sách bác sĩ để tìm kiếm
            const doctors = [
                @foreach ($doctors as $doctor)
                    {
                        id: {{ $doctor->id }},
                        name: "{{ $doctor->name }}",
                        specialization: "{{ $doctor->specialization }}",
                        photo: "{{ $doctor->photo ?? '/images/default-avatar.png' }}"
                    },
                @endforeach
            ];

            let currentDoctorInfo = null;

            const doctorInfoModal = new bootstrap.Modal(document.getElementById('doctorInfoModal'));
            const bookAppointmentModal = new bootstrap.Modal(document.getElementById('bookAppointmentModal'));

            const searchResults = document.getElementById('search-results');
            const searchInput = document.getElementById('search-doctor');
            const selectedDoctorInfo = document.getElementById('selected-doctor-info');
            const selectedDoctorIdInput = document.getElementById('selected_doctor_id');
            const selectedDoctorName = document.getElementById('selected-doctor-name');
            const selectedDoctorSpecialization = document.getElementById('selected-doctor-specialization');
            const selectedDoctorImg = document.getElementById('selected-doctor-img');

            const doctorInfoTitle = document.getElementById('doctor-info-title');
            const doctorInfoName = document.getElementById('doctor-info-name');
            const doctorInfoSpecialization = document.getElementById('doctor-info-specialization');
            const doctorInfoImg = document.getElementById('doctor-info-img');

            let searchTimeout = null;

            // Xử lý tìm kiếm bác sĩ
            document.getElementById('search-doctor-btn').addEventListener('click', performSearch);
            searchInput.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') performSearch();
            });

            function performSearch() {
                if (searchTimeout) clearTimeout(searchTimeout);

                searchTimeout = setTimeout(() => {
                    const searchTerm = searchInput.value.toLowerCase().trim();
                    searchResults.innerHTML = '';

                    if (searchTerm.length < 2) {
                        alert('Vui lòng nhập ít nhất 2 ký tự để tìm kiếm');
                        searchResults.style.display = 'none';
                        return;
                    }

                    const filteredDoctors = doctors.filter(doctor =>
                        doctor.name.toLowerCase().includes(searchTerm) ||
                        doctor.specialization.toLowerCase().includes(searchTerm)
                    );

                    if (filteredDoctors.length === 0) {
                        searchResults.innerHTML =
                            '<div class="col-12"><div class="alert alert-info">Không tìm thấy bác sĩ phù hợp</div></div>';
                        searchResults.style.display = 'flex';
                        return;
                    }

                    const fragment = document.createDocumentFragment();
                    filteredDoctors.forEach(doctor => {
                        const doctorCard = document.createElement('div');
                        doctorCard.className = 'col-md-4 mb-3';
                        doctorCard.innerHTML = `
                    <div class="card h-100 doctor-card">
                        <div class="card-body text-center">
                            <img src="${doctor.photo}" alt="${doctor.name}"  class="rounded-circle object-fit-cover doctor-avatar mb-3" width="60" height="60">
                            <h6 class="card-title">Bs. ${doctor.name}</h6>
                            <p class="card-text text-muted small">${doctor.specialization}</p>
                        </div>
                        <div class="card-footer bg-light p-2 text-center">
                            <div class="btn-group btn-group-sm w-100">
                                <button type="button" class="btn btn-outline-info view-doctor-info-btn" 
                                    data-doctor-id="${doctor.id}" 
                                    data-doctor-name="${doctor.name}" 
                                    data-doctor-specialization="${doctor.specialization}" 
                                    data-doctor-photo="${doctor.photo}">
                                    <i class="bi bi-info-circle"></i> Xem thông tin
                                </button>
                                <button type="button" class="btn btn-outline-primary select-doctor-btn" 
                                    data-doctor-id="${doctor.id}" 
                                    data-doctor-name="${doctor.name}" 
                                    data-doctor-specialization="${doctor.specialization}" 
                                    data-doctor-photo="${doctor.photo}">
                                    <i class="bi bi-check-circle"></i> Chọn
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                        fragment.appendChild(doctorCard);
                    });

                    searchResults.appendChild(fragment);
                    searchResults.style.display = 'flex';
                }, 300);
            }

            // Event delegation cho các nút trong kết quả tìm kiếm
            document.addEventListener('click', function(e) {
                if (e.target.closest('.view-doctor-info-btn')) {
                    const button = e.target.closest('.view-doctor-info-btn');
                    const doctorId = button.getAttribute('data-doctor-id');
                    const doctorName = button.getAttribute('data-doctor-name');
                    const doctorSpecialization = button.getAttribute('data-doctor-specialization');
                    const doctorPhoto = button.getAttribute('data-doctor-photo');

                    currentDoctorInfo = {
                        id: doctorId,
                        name: doctorName,
                        specialization: doctorSpecialization,
                        photo: doctorPhoto
                    };

                    doctorInfoName.textContent = `Bs. ${doctorName}`;
                    doctorInfoSpecialization.textContent = doctorSpecialization;
                    doctorInfoImg.src = doctorPhoto;

                    bookAppointmentModal.hide();
                    setTimeout(() => doctorInfoModal.show(), 200);
                }

                if (e.target.closest('.select-doctor-btn')) {
                    const button = e.target.closest('.select-doctor-btn');
                    selectedDoctorIdInput.value = button.getAttribute('data-doctor-id');
                    selectedDoctorName.textContent = `Bs. ${button.getAttribute('data-doctor-name')}`;
                    selectedDoctorSpecialization.textContent = button.getAttribute(
                        'data-doctor-specialization');
                    selectedDoctorImg.src = button.getAttribute('data-doctor-photo');
                    selectedDoctorInfo.style.display = 'block';
                    searchResults.style.display = 'none';
                }
            });

            // Chọn bác sĩ từ modal thông tin
            document.querySelector('.select-from-info-btn').addEventListener('click', function() {
                if (currentDoctorInfo) {
                    selectedDoctorIdInput.value = currentDoctorInfo.id;
                    selectedDoctorName.textContent = `Bs. ${currentDoctorInfo.name}`;
                    selectedDoctorSpecialization.textContent = currentDoctorInfo.specialization;
                    selectedDoctorImg.src = currentDoctorInfo.photo;
                    selectedDoctorInfo.style.display = 'block';
                    doctorInfoModal.hide();
                }
            });

            // Khi modal thông tin bác sĩ đóng, mở lại modal đặt lịch
            document.getElementById('doctorInfoModal').addEventListener('hidden.bs.modal', function() {
                bookAppointmentModal.show();
            });

            // Bỏ chọn bác sĩ
            document.getElementById('clear-doctor-selection').addEventListener('click', function() {
                selectedDoctorIdInput.value = '';
                selectedDoctorInfo.style.display = 'none';
            });
        });


        function showAppointmentDetails(appointmentId) {
            const modal = new bootstrap.Modal(document.getElementById('appointment-details-modal'));
            document.getElementById('appointment-details-content').innerHTML =
                '<div class="p-4 text-center"><i class="fas fa-spinner fa-spin me-2"></i>Đang tải dữ liệu...</div>';
            modal.show();

            // Fetch chi tiết sau khi modal hiển thị
            fetch(`/appointments/${appointmentId}/details`)
                .then(response => response.json())
                .then(data => {
                    // console.log('Data :', data);
                    // Xác định class cho trạng thái
                    let statusClass = 'badge-secondary';
                    if (data.status === 'Hoàn thành') statusClass = 'badge-success';
                    if (data.status === 'Sắp tới') statusClass = 'badge-primary';
                    if (data.status === 'Chờ duyệt') statusClass = 'badge-warning';
                    if (data.status === 'Đã hủy') statusClass = 'badge-danger';

                    // Xác định loại khám
                    let typeIcon = data.consultation_type === 'Tư vấn trực tuyến' ? 'video' : 'clinic-medical';
                    let typeClass = data.consultation_type === 'Tư vấn trực tuyến' ? 'badge-info' : 'badge-success';

                    const content = `
                <div class="appointment-detail-wrapper">
                    <!-- Thông tin bác sĩ -->
                    <div class="doctor-profile">
                        <div class="doctor-profile-inner">
                            <img src="${data.doctor_photo || '/images/default-avatar.png'}" alt="${data.doctor_name}" class="doctor-img">
                            <div class="doctor-info">
                                <h5>BS. ${data.doctor_name}</h5>
                                <p>${data.specialization}</p>
                                <div class="rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                    <span>4.9</span>
                                </div>
                            </div>
                        </div>
                        <div class="appointment-badge">
                            <span class="badge ${statusClass}">${data.status}</span>
                        </div>
                    </div>

                    <!-- Chi tiết lịch khám -->
                    <div class="appointment-info">
                        <div class="appointment-id">
                            <i class="fas fa-hashtag"></i> Mã lịch: <strong>APT${String(appointmentId).padStart(4, '0')}</strong>
                        </div>
                        
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="far fa-calendar-alt"></i>
                                </div>
                                <div>
                                    <h6>Ngày khám</h6>
                                    <p>${data.date}</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="far fa-clock"></i>
                                </div>
                                <div>
                                    <h6>Giờ khám</h6>
                                    <p>${data.time}</p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-${typeIcon}"></i>
                                </div>
                                <div>
                                    <h6>Hình thức</h6>
                                    <p><span class="badge ${typeClass}">${data.consultation_type}</span></p>
                                </div>
                            </div>
                            
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-sticky-note"></i>
                                </div>
                                <div>
                                    <h6>Ghi chú</h6>
                                    <p>${data.notes || 'Không có ghi chú'}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-details">
                            <h6 class="section-header-contact">Thông tin liên hệ</h6>
                            <div class="contact-info">
                                <div>
                                    <i class="fas fa-envelope"></i>
                                    <span>${data.doctor_email || 'doctor@example.com'}</span>
                                </div>
                                <div>
                                    <i class="fas fa-phone"></i>
                                    <span>${data.doctor_phone || '+84 123 456 789'}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nút hành động -->
                    <div class="appointment-actions">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        ${data.status === 'Sắp tới' && data.consultation_type === 'Tư vấn trực tuyến' ? 
                        `<a href="/video-call/${appointmentId}" class="btn btn-primary"><i class="fas fa-video me-2"></i>Tham gia</a>` : ''}
                        ${data.status === 'Chờ duyệt' ? 
                        `<button class="btn btn-outline-danger"><i class="fas fa-times me-2"></i>Hủy lịch</button>` : ''}
                    </div>
                </div>
            `;
                    document.getElementById('appointment-details-content').innerHTML = content;
                })
                .catch(() => {
                    document.getElementById('appointment-details-content').innerHTML =
                        `<div class="alert alert-danger m-4"><i class="fas fa-exclamation-circle me-2"></i>Lỗi tải dữ liệu. Vui lòng thử lại sau.</div>`;
                });
        }
    </script>
@endsection

{{-- <style>
    .doctor-avatar {
        object-fit: cover;
        border-radius: 50%;
        aspect-ratio: 1/1;
        object-position: center;
        border: 2px solid #e0e0e0;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .doctor-card:hover .doctor-avatar {
        border-color: #0d6efd;
        transform: scale(1.05);
        transition: transform 0.3s ease, border-color 0.3s ease;
    }

    .avatar-container {
        position: relative;
        width: 80px;
        height: 80px;
        margin: 0 auto;
        overflow: hidden;
    }

    .doctor-avatar.avatar-lg {
        width: 100px;
        height: 100px;
    }

    .doctor-avatar.avatar-md {
        width: 80px;
        height: 80px;
    }

    .doctor-avatar.avatar-sm {
        width: 60px;
        height: 60px;
    }

    .modal-header {
        background-color: #2377B3 !important;
    }
</style> --}}

@push('scripts')
    <script>
        // Validation và xử lý form (unchanged)
        document.getElementById('appointmentForm').addEventListener('submit', function(e) {
            e.preventDefault();
            // Thêm validation logic ở đây
            this.submit();
        });

        // Cập nhật slot giờ khám dựa theo ngày và bác sĩ
        document.querySelector('select[name="doctor_id"], input[name="date"]').addEventListener('change', function() {
            const doctorId = document.querySelector('select[name="doctor_id"]').value;
            const date = document.querySelector('input[name="date"]').value;

            if (doctorId && date) {
                // Gọi API để lấy các slot còn trống
                fetch(`/api/available-slots/${doctorId}/${date}`)
                    .then(response => response.json())
                    .then(data => {
                        const timeSelect = document.querySelector('select[name="time"]');
                        timeSelect.innerHTML = '<option value="">-- Chọn giờ --</option>';
                        data.forEach(slot => {
                            timeSelect.innerHTML += `<option value="${slot}">${slot}</option>`;
                        });
                    });
            }
        });

        // Initialize tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
@endpush
