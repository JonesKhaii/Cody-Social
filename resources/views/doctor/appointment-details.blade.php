<!-- Modal chi tiết lịch khám -->
<div id="appointment-details-modal" class="modal fade">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="fas fa-calendar-check me-2"></i>Chi tiết lịch khám</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-lg-6 mb-lg-0 mb-3">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="fw-bold mb-0"><i class="fas fa-user-circle me-2"></i>Thông tin bệnh nhân</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-placeholder bg-primary rounded-circle d-flex align-items-center justify-content-center me-3 text-white"
                                        style="width:50px;height:50px;flex-shrink:0;">
                                        <span id="patient-initial"></span>
                                    </div>
                                    <h5 class="text-break mb-0" id="patient-name"></h5>
                                </div>
                                <p class="text-break mb-2"><i class="fas fa-envelope text-muted me-2"></i><span
                                        id="patient-email"></span></p>
                                <p class="text-break mb-0"><i class="fas fa-phone text-muted me-2"></i><span
                                        id="patient-phone"></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-header bg-light">
                                <h6 class="fw-bold mb-0"><i class="fas fa-calendar-alt me-2"></i>Thông tin lịch khám
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-6 mb-sm-0 mb-2">
                                        <p class="mb-0"><i
                                                class="fas fa-calendar-day text-muted me-2"></i><strong>Ngày:</strong>
                                            <span id="appointment-date"></span>
                                        </p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-0"><i
                                                class="fas fa-clock text-muted me-2"></i><strong>Giờ:</strong> <span
                                                id="appointment-time"></span></p>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-sm-6 mb-sm-0 mb-2">
                                        <p class="mb-0"><i class="fas fa-stethoscope text-muted me-2"></i><strong>Hình
                                                thức:</strong> <span id="consultation-type"></span></p>
                                    </div>
                                    <div class="col-sm-6">
                                        <p class="mb-0"><i
                                                class="fas fa-check-circle text-muted me-2"></i><strong>Trạng
                                                thái:</strong> <span id="appointment-status"></span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="fw-bold mb-0"><i class="fas fa-sticky-note me-2"></i>Ghi chú</h6>
                    </div>
                    <div class="card-body">
                        <div class="bg-light rounded border p-3" id="appointment-notes"></div>
                    </div>
                </div>

                <div id="result-section" class="card d-none mb-4 border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="fw-bold mb-0"><i class="fas fa-file-medical-alt me-2"></i>Kết quả khám</h6>
                    </div>
                    <div class="card-body">
                        <div class="bg-light rounded border p-3" id="appointment-result"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Đóng
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CSS -->
<style>
    .modal-dialog.modal-xl {
        max-width: 95%;

        width: 1200px;
        margin: 1.75rem auto;
    }

    /* Đảm bảo modal có kích thước tối thiểu */
    .modal-content {
        min-width: 320px;
    }

    .modal-header {
        background-color: #2377b3 !important;
    }

    /* Cải thiện responsive cho mobile */
    @media (max-width: 767.98px) {
        .modal-fullscreen-md-down {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
        }

        .modal-fullscreen-md-down .modal-content {
            border: 0;
            border-radius: 0;
            min-height: 100vh;
            height: auto;
            width: 100% !important;
        }
    }

    /* Đảm bảo các phần tử không bị tràn */
    .text-break {
        word-break: break-word !important;
        overflow-wrap: break-word !important;
        hyphens: auto;
    }

    /* Loại bỏ khoảng cách dư thừa trong modal */
    .modal-body {
        padding: 1.5rem;
    }

    .card-body {
        padding: 1rem;
    }

    /* Các class gốc */
    .modal-fullscreen-md-down {
        padding: 0 !important;
    }

    .avatar-placeholder {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .card {
        transition: all 0.3s ease;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.35em 0.65em;
    }

    .card-header {
        padding: 0.75rem 1rem;
    }

    .btn-close-white {
        filter: brightness(0) invert(1);
    }

    /* Sửa animation modal */
    .modal.fade .modal-dialog {
        transform: scale(0.98);
        opacity: 0;
        transition: transform 0.3s ease, opacity 0.3s ease;
    }

    .modal.show .modal-dialog {
        transform: scale(1);
        opacity: 1;
    }

    /* Đảm bảo modal luôn có thể được cuộn */
    .modal {
        overflow-y: auto !important;
    }

    /* Đảm bảo modal có z-index cao hơn */
    .modal-backdrop {
        z-index: 1040 !important;
    }

    .modal {
        z-index: 1050 !important;
    }

    body.modal-open {
        overflow: hidden;
        padding-right: 0 !important;
    }
</style>

<!-- Script -->
<script>
    $(document).ready(function() {
        // Đảm bảo jQuery và Bootstrap đã được tải
        if (typeof jQuery === 'undefined') {
            console.error('jQuery chưa được tải!');
            return;
        }

        if (typeof bootstrap === 'undefined') {
            console.error('Bootstrap chưa được tải!');
            return;
        }

        // Mở modal chi tiết lịch khám
        $('.view-appointment').click(function() {
            try {
                const button = $(this);
                const patientName = button.data('patient-name');
                const patientEmail = button.data('patient-email');
                const patientPhone = button.data('patient-phone');
                const date = button.data('date');
                const time = button.data('time');
                const type = button.data('type');
                const status = button.data('status');
                const notes = button.data('notes') || 'Không có ghi chú';
                const result = button.data('result');

                // Kiểm tra dữ liệu trước khi đổ vào modal
                console.log('Dữ liệu lịch khám:', {
                    patientName,
                    patientEmail,
                    patientPhone,
                    date,
                    time,
                    type,
                    status,
                    notes,
                    result
                });

                // Đổ dữ liệu vào modal
                $('#patient-name').text(patientName || 'Không có thông tin');
                $('#patient-email').text(patientEmail || 'Không có thông tin');
                $('#patient-phone').text(patientPhone || 'Không có thông tin');
                $('#appointment-date').text(date || 'Không có thông tin');
                $('#appointment-time').text(time || 'Không có thông tin');
                $('#appointment-notes').text(notes || 'Không có ghi chú');

                // Tạo chữ cái đầu cho avatar
                const initial = patientName ? patientName.charAt(0).toUpperCase() : '?';
                $('#patient-initial').text(initial);

                // Hiển thị loại khám
                let typeLabel = '';
                switch (type) {
                    case 'Online':
                        typeLabel =
                            '<span class="badge bg-info"><i class="fas fa-video me-1"></i>Trực tuyến</span>';
                        break;
                    case 'Offline':
                        typeLabel =
                            '<span class="badge bg-primary"><i class="fas fa-hospital me-1"></i>Tại phòng khám</span>';
                        break;
                    case 'At Home':
                        typeLabel =
                            '<span class="badge bg-success"><i class="fas fa-home me-1"></i>Tại nhà</span>';
                        break;
                    default:
                        typeLabel =
                            '<span class="badge bg-secondary"><i class="fas fa-question-circle me-1"></i>Không xác định</span>';
                }
                $('#consultation-type').html(typeLabel);

                // Hiển thị trạng thái
                let statusLabel = '';
                switch (status) {
                    case 'Chờ duyệt':
                        statusLabel =
                            '<span class="badge bg-warning"><i class="fas fa-hourglass-half me-1"></i>Chờ duyệt</span>';
                        break;
                    case 'Sắp tới':
                        statusLabel =
                            '<span class="badge bg-info"><i class="fas fa-calendar-day me-1"></i>Sắp tới</span>';
                        break;
                    case 'Hoàn thành':
                        statusLabel =
                            '<span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Hoàn thành</span>';
                        break;
                    case 'Đã Huỷ':
                        statusLabel =
                            '<span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i>Đã Huỷ</span>';
                        break;
                    default:
                        statusLabel =
                            '<span class="badge bg-secondary"><i class="fas fa-question-circle me-1"></i>Không xác định</span>';
                }
                $('#appointment-status').html(statusLabel);

                // Xử lý hiển thị kết quả khám
                if (result && status === 'Hoàn thành') {
                    $('#appointment-result').text(result);
                    $('#result-section').removeClass('d-none');
                } else {
                    $('#result-section').addClass('d-none');
                }

                // Mở modal và kiểm tra trạng thái
                const appointmentModal = $('#appointment-details-modal');
                appointmentModal.modal('show');

                // Kiểm tra sau khi mở modal
                appointmentModal.on('shown.bs.modal', function() {
                    console.log('Modal đã mở hoàn toàn');
                    // Thêm timeout để kiểm tra và đảm bảo modal hiển thị đúng
                    setTimeout(function() {
                        if (appointmentModal.css('display') !== 'block') {
                            console.error('Modal không hiển thị đúng');
                            appointmentModal.css('display', 'block');
                        }
                    }, 300);
                });
            } catch (error) {
                console.error('Lỗi khi mở modal:', error);
                alert('Có lỗi xảy ra khi hiển thị chi tiết lịch khám. Vui lòng thử lại sau.');
            }
        });

        // Xử lý đóng modal chi tiết
        $('#appointment-details-modal').on('hidden.bs.modal', function() {
            // Reset dữ liệu
            $('#patient-name, #patient-email, #patient-phone, #appointment-date, #appointment-time, #appointment-notes')
                .text('');
            $('#patient-initial').text('');
            $('#consultation-type, #appointment-status').html('');
            $('#result-section').addClass('d-none');
        });

        // Xử lý nút đóng thông thường
        $('.btn-close, .btn-secondary').on('click', function() {
            $('#appointment-details-modal').modal('hide');
        });



        // Xử lý phím Escape
        $(document).keydown(function(e) {
            if (e.keyCode === 27 && $('#appointment-details-modal').hasClass('show')) {
                console.log('Phím Escape được nhấn, đóng modal');
                $('#appointment-details-modal').modal('hide');
            }
        });
    });
</script>
