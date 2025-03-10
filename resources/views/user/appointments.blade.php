@extends('layouts.master')
@section('title', 'Lịch khám')
@section('main-content')

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS và Popper.js (bắt buộc cho Bootstrap 5) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">Lịch Khám Của Tôi</h2>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bookAppointmentModal">
                <i class="fas fa-plus-circle me-2"></i>Đặt lịch khám
            </button>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-pills mb-4">
            @foreach (['Chờ duyệt' => 'pending', 'Sắp tới' => 'confirmed', 'Hoàn thành' => 'completed', 'Đã Huỷ' => 'canceled'] as $label => $tab)
                <li class="nav-item">
                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="pill"
                        href="#{{ $tab }}">
                        <i
                            class="fas fa-{{ $tab == 'pending' ? 'clock' : ($tab == 'confirmed' ? 'check-circle' : ($tab == 'completed' ? 'check-double' : 'times-circle')) }} me-2"></i>{{ $label }}
                        @if ($appointments->where('status', $label)->count() > 0)
                            <span
                                class="badge bg-warning ms-2">{{ $appointments->where('status', $label)->count() }}</span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" style="min-height: 500px;">
            @foreach (['Chờ duyệt' => 'pending', 'Sắp tới' => 'confirmed', 'Hoàn thành' => 'completed', 'Đã Huỷ' => 'canceled'] as $label => $tab)
                <div id="{{ $tab }}" class="tab-pane fade {{ $loop->first ? 'show active' : '' }}">
                    @if ($appointments->where('status', $label)->count() > 0)
                        <!-- Table Layout -->
                        <div class="table-responsive card shadow-sm">
                            <table class="table-hover mb-0 table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Bác sĩ</th>
                                        <th>Ngày giờ</th>
                                        <th>Hình thức</th>
                                        <th>Ghi chú</th>
                                        <th class="text-end">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($appointments->where('status', $label) as $appointment)
                                        <tr>
                                            <!-- Doctor Info -->
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $appointment->doctor->photo ?? '/images/default-avatar.png' }}"
                                                        class="rounded-circle me-3" width="40" height="40"
                                                        alt="Doctor avatar">
                                                    <div>
                                                        <h6 class="mb-0">Bs. {{ $appointment->doctor->name }}</h6>
                                                        <small
                                                            class="text-muted">{{ $appointment->doctor->specialization }}</small>
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Date & Time -->
                                            <td>
                                                <div class="d-flex flex-column">
                                                    <div><i class="fas fa-calendar-alt text-primary me-2"></i>
                                                        {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}
                                                    </div>
                                                    <div><i class="fas fa-clock text-primary me-2"></i>
                                                        {{ \Carbon\Carbon::parse($appointment->time)->format('H:i') }}
                                                    </div>
                                                </div>
                                            </td>

                                            <!-- Consultation Type -->
                                            <td>
                                                <span
                                                    class="badge {{ $appointment->consultation_type === 'online' ? 'bg-info' : 'bg-success' }} text-white">
                                                    <i
                                                        class="fas fa-{{ $appointment->consultation_type === 'online' ? 'video' : 'clinic-medical' }} me-1"></i>
                                                    {{ $appointment->consultation_type === 'online' ? 'Tư vấn trực tuyến' : 'Khám tại phòng khám' }}
                                                </span>
                                            </td>

                                            <!-- Notes -->
                                            <td>
                                                @if ($appointment->notes)
                                                    <span class="text-truncate d-inline-block" style="max-width: 150px;"
                                                        data-bs-toggle="tooltip" title="{{ $appointment->notes }}">
                                                        {{ Str::limit($appointment->notes, 30) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted fst-italic">Không có ghi chú</span>
                                                @endif
                                            </td>

                                            <!-- Actions -->
                                            <td class="text-end">
                                                @if ($label === 'Chờ duyệt')
                                                    <form
                                                        action="{{ route('user.appointments.cancel', $appointment->id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                                            <i class="fas fa-times me-1"></i>Hủy lịch
                                                        </button>
                                                    </form>
                                                @endif

                                                @if ($label === 'Sắp tới' && $appointment->consultation_type === 'online')
                                                    <a href="{{ route('video-call', $appointment->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="fas fa-video me-1"></i>Vào phòng khám
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="card min-vh-40 py-5 text-center shadow-sm">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center py-5">
                                <i class="fas fa-calendar-times fa-4x text-muted mb-4"></i>
                                <h4 class="text-muted mb-3">Không có lịch khám {{ strtolower($label) }}</h4>
                                <p class="text-muted mb-4">Bạn có thể đặt lịch mới bằng cách nhấn nút "Đặt lịch khám" ở góc
                                    phải trên cùng.</p>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#bookAppointmentModal">
                                    <i class="fas fa-plus-circle me-2"></i>Đặt lịch khám ngay
                                </button>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Thông tin hướng dẫn -->
        <div class="card bg-light mt-4 border-0">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-info-circle text-primary me-2"></i>Hướng dẫn đặt lịch khám</h5>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="d-flex mb-3">
                            <div class="text-primary me-3">
                                <i class="fas fa-calendar-plus fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Đặt lịch dễ dàng</h6>
                                <p class="text-muted small mb-0">Chọn bác sĩ, ngày giờ và hình thức khám theo nhu cầu của
                                    bạn</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="text-primary me-3">
                                <i class="fas fa-bell fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Nhận thông báo</h6>
                                <p class="text-muted small mb-0">Bạn sẽ nhận được thông báo khi lịch được xác nhận</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex mb-3">
                            <div class="text-primary me-3">
                                <i class="fas fa-video fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Khám trực tuyến tiện lợi</h6>
                                <p class="text-muted small mb-0">Tiết kiệm thời gian với tính năng tư vấn trực tuyến</p>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="text-primary me-3">
                                <i class="fas fa-history fa-2x"></i>
                            </div>
                            <div>
                                <h6 class="mb-1">Quản lý lịch sử khám</h6>
                                <p class="text-muted small mb-0">Xem lại toàn bộ lịch sử khám và kết quả điều trị</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Đặt lịch khám (unchanged) -->
    {{-- <div class="modal fade" id="bookAppointmentModal" tabindex="-1">
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
                            <div class="col-md-6">
                                <label class="form-label">Chọn bác sĩ</label>
                                <select name="doctor_id" class="form-select" required>
                                    <option value="">-- Chọn bác sĩ --</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">Bs. {{ $doctor->name }} -
                                            {{ $doctor->specialization }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Hình thức khám</label>
                                <select name="consultation_type" class="form-select" required>
                                    <option value="Offline">Khám tại phòng khám</option>
                                    <option value="Online">Tư vấn trực tuyến</option>
                                    <option value="At Home">Khám tại nhà</option>
                                </select>

                            </div>

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
    </div> --}}

    <!-- Modal Đặt lịch khám -->
    {{-- <div class="modal fade" id="bookAppointmentModal" tabindex="-1">
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
                                <input type="text" class="form-control" id="search-doctor"
                                    placeholder="Nhập tên bác sĩ hoặc chuyên khoa...">
                            </div>

                            <!-- Danh sách bác sĩ -->
                            <div class="col-md-12" id="doctor-list">
                                <label class="form-label mt-3">Chọn bác sĩ</label>
                                <select name="doctor_id" class="form-select" required>
                                    <option value="">-- Chọn bác sĩ --</option>
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">
                                            Bs. {{ $doctor->name }} - {{ $doctor->specialization }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Danh sách bác sĩ nổi bật -->
                            <div class="col-md-12">
                                <label class="form-label mt-3">Bác sĩ nổi bật</label>
                                <div class="row">
                                    @foreach ($doctors as $doctor)
                                        <div class="col-md-4 mb-3 text-center">
                                            <img src="{{ asset($doctor->photo ?? '/images/default-avatar.png') }}"
                                                alt="{{ $doctor->name }}"
                                                class="rounded-circle" width="80" height="80">
                                            <h6 class="mt-2">{{ $doctor->name }}</h6>
                                            <small class="text-muted">{{ $doctor->specialization }}</small>
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
    </div> --}}

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
                                            class="rounded-circle me-3" width="60" height="60">
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
                                                        alt="{{ $doctor->name }}" class="rounded-circle mb-3"
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
                                                            data-doctor-photo="{{ asset($doctor->photo ?? '/images/default-avatar.png') }}">
                                                            <i class="bi bi-info-circle"></i> Xem thông tin
                                                        </button>
                                                        <button type="button"
                                                            class="btn btn-outline-primary select-doctor-btn"
                                                            data-doctor-id="{{ $doctor->id }}"
                                                            data-doctor-name="{{ $doctor->name }}"
                                                            data-doctor-specialization="{{ $doctor->specialization }}"
                                                            data-doctor-photo="{{ asset($doctor->photo ?? '/images/default-avatar.png') }}">
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

                        <img id="doctor-info-img" src="{{ $doctor->photo }}" alt="Bác sĩ" class="rounded-circle mb-3"
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Lưu danh sách bác sĩ để tìm kiếm
            const doctors = [
                @foreach ($doctors as $doctor)
                    {
                        id: {{ $doctor->id }},
                        name: "{{ $doctor->name }}",
                        specialization: "{{ $doctor->specialization }}",
                        photo: "{{ asset($doctor->photo ?? '/images/default-avatar.png') }}"
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
                            <img src="${doctor.photo}" alt="${doctor.name}" class="rounded-circle mb-2" width="60" height="60">
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
    </script>
@endsection
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
