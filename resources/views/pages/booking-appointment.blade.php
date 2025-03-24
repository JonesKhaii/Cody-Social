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

                            <!-- Input ẩn để lưu doctor_id -->
                            <input type="hidden" name="doctor_id" id="selected_doctor_id" required>

                            <!-- Bác sĩ đã chọn -->
                            <div class="col-md-12 mb-3" id="selected-doctor-info" style="display: none;">
                                <div class="card border-success">
                                    <div class="card-header bg-success text-white">Bác sĩ đã chọn</div>
                                    <div class="card-body d-flex align-items-center">
                                        <img id="selected-doctor-img" src="" alt="Bác sĩ đã chọn"
                                            class="rounded-circle object-fit-cover doctor-avatar me-3" width="60"
                                            height="60" style="object-fit: cover">
                                        <div>
                                            <h6 id="selected-doctor-name" class="mb-1"></h6>
                                            <p id="selected-doctor-specialization" class="text-muted small mb-0"></p>
                                        </div>
                                        <div class="ms-auto">
                                            <button type="button" class="btn btn-sm btn-outline-info me-2"
                                                id="view-selected-doctor-info">
                                                <i class="bi bi-info-circle"></i> Xem thông tin
                                            </button>
                                            {{-- <button type="button" class="btn btn-sm btn-outline-danger"
                                                id="clear-doctor-selection">
                                                <i class="bi bi-x-lg"></i> Bỏ chọn
                                            </button> --}}
                                        </div>
                                    </div>
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
                            style="object-fit: cover" width="100" height="100">
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

                    {{-- <div class="d-grid">
                        <button type="button" class="btn btn-primary select-from-info-btn">
                            <i class="bi bi-calendar-check"></i> Đặt lịch với bác sĩ này
                        </button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('#view-selected-doctor-info').addEventListener('click', function() {
            // Lấy thông tin bác sĩ từ các trường ẩn trong form
            const doctorName = document.getElementById('selected-doctor-name').textContent;
            const doctorSpecialization = document.getElementById('selected-doctor-specialization').textContent;
            const doctorImg = document.getElementById('selected-doctor-img').src;

            // Điền thông tin vào modal "Thông tin bác sĩ"
            document.getElementById('doctor-info-name').textContent = doctorName;
            document.getElementById('doctor-info-specialization').textContent = doctorSpecialization;
            document.getElementById('doctor-info-img').src = doctorImg;

            // Mở modal "Thông tin bác sĩ"
            const doctorInfoModal = new bootstrap.Modal(document.getElementById('doctorInfoModal'));
            doctorInfoModal.show();
        });
    </script>
