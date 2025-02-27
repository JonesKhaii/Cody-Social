@extends('layouts.master')
@section('title', 'Lịch khám')
@section('main-content')

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
    <div class="modal fade" id="bookAppointmentModal" tabindex="-1">
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
    </div>

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
