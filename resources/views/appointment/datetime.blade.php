    @extends('layouts.master')

    @section('main-content')
        <div class="container-datetime container py-5">
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
                    <span class="badge bg-danger ms-auto"><i
                            class="fas fa-star me-1"></i>{{ $doctor->rating ?? '5.0' }}</span>
                </div>
            </div>

            {{-- Booking Info --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Booking Info</h5>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="service_type" checked>
                                    </div>
                                    <div class="ms-2">
                                        <strong>Service</strong>
                                        <div class="text-muted">Cardiology (30 Mins)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <strong>Service</strong>
                                <div class="text-muted">Echocardiograms</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <strong>Date & Time</strong>
                                <div class="text-muted" id="selected-datetime">Please select a date and time</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <strong>Appointment type</strong>
                                <div class="text-muted">Clinic (Wellness Path)</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Booking Form --}}
            <form action="{{ route('booking.info') }}" method="POST">
                @csrf
                <div class="card mb-4 shadow-sm">
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-10">
                                {{-- Date and Time Selection Container --}}
                                <div class="row g-0">
                                    {{-- Calendar Column --}}
                                    <div class="col-md-5 border-end pe-3">
                                        <h5 class="fw-bold mb-3">Chọn ngày khám</h5>
                                        <div id="calendar"></div>
                                        <input type="hidden" name="selected_date" id="selected_date">
                                    </div>

                                    {{-- Time Slots Column --}}
                                    <div class="col-md-7 ps-4">
                                        <h5 class="fw-bold mb-3">Chọn khung giờ</h5>
                                        <div id="slots-container">
                                            <div id="no-slots-message" class="alert alert-warning">
                                                <i class="fas fa-exclamation-circle me-2"></i>Không có khung giờ khả dụng
                                                cho
                                                ngày này.
                                            </div>

                                            <div id="time-slots" class="d-none">
                                                <!-- Morning slots -->
                                                <div class="mb-4">
                                                    <h6 class="fw-bold d-flex align-items-center mb-3">
                                                        <i class="fas fa-sun text-warning me-2"></i>ca sáng
                                                    </h6>
                                                    <div id="morning-slots" class="time-slot-grid"></div>
                                                </div>

                                                <!-- Afternoon slots -->
                                                <div class="mb-4">
                                                    <h6 class="fw-bold d-flex align-items-center mb-3">
                                                        <i class="fas fa-cloud-sun text-primary me-2"></i>ca chiều
                                                    </h6>
                                                    <div id="afternoon-slots" class="time-slot-grid"></div>
                                                </div>

                                                <!-- Evening slots -->
                                                <div class="mb-4">
                                                    <h6 class="fw-bold d-flex align-items-center mb-3">
                                                        <i class="fas fa-moon text-dark me-2"></i>Ca tối
                                                    </h6>
                                                    <div id="evening-slots" class="time-slot-grid"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="d-flex justify-content-between mb-4 mt-2">
                    <a href="{{ route('booking.appointmentType.get') }}" class="btn btn-outline-dark">
                        <i class="fas fa-arrow-left me-1"></i> Quay lại
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 py-2">
                        Add Basic Information <i class="fas fa-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    @endsection

    @section('scripts')
        <style>
            /* Container styling */
            .container-datetime {
                max-width: 1000px;
                margin: 0 auto;
            }

            /* Card styling */
            .card {
                border-radius: 12px;
                border: none;
                overflow: hidden;
            }

            /* Custom styles cho calendar */
            #calendar {
                max-width: 320px;
                margin: 0 auto;
            }

            /* Tùy chỉnh Tempus Dominus */
            .bootstrap-datetimepicker-widget table td.day {
                height: 40px;
                width: 40px;
                line-height: 40px;
                font-size: 14px;
                border-radius: 50%;
                text-align: center;
                cursor: pointer;
            }

            .bootstrap-datetimepicker-widget table th.dow {
                height: 30px;
                font-weight: bold;
                text-align: center;
            }

            .bootstrap-datetimepicker-widget table td.active,
            .bootstrap-datetimepicker-widget table td.active:hover {
                background-color: #0d6efd;
                color: white;
            }

            .bootstrap-datetimepicker-widget table td:hover {
                background-color: #e9ecef;
            }

            /* Time slot grid styling */
            .time-slot-grid {
                display: grid;
                grid-template-columns: repeat(4, 1fr);
                gap: 12px;
                margin: 0 -5px;
            }

            /* Time slot button styling */
            .time-slot-btn {
                width: 100%;
                padding: 8px 0;
                text-align: center;
                border-radius: 6px;
                border: 1px solid #dee2e6;
                background: #f8f9fa;
                font-size: 14px;
                font-weight: 500;
                color: #6c757d;
                transition: all 0.2s ease;
            }

            .time-slot-btn.available {
                background-color: #e3f2fd;
                border-color: #90caf9;
                color: #0d6efd;
            }

            .time-slot-btn.available:hover {
                background-color: #bbdefb;
                border-color: #64b5f6;
            }

            .time-slot-btn.available.active {
                background-color: #0d6efd;
                border-color: #0d6efd;
                color: white;
                box-shadow: 0 2px 5px rgba(13, 110, 253, 0.2);
            }

            .time-slot-btn.disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }

            /* Other improvements */
            .badge {
                padding: 8px 12px;
                border-radius: 30px;
            }

            .alert {
                border-radius: 8px;
            }

            .tempus-dominus-widget {
                box-shadow: none !important;
            }
        </style>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Mock data structure that matches the format we need
                const slotData = @json($days ?? []);

                // Time ranges for categorization
                const timeRanges = {
                    morning: {
                        start: '05:00',
                        end: '12:00'
                    },
                    afternoon: {
                        start: '12:00',
                        end: '17:00'
                    },
                    evening: {
                        start: '17:00',
                        end: '23:59'
                    }
                };

                if (typeof tempusDominus === 'undefined') {
                    console.error('Tempus Dominus library not loaded! Check CDN links');
                    return;
                }

                const calendarEl = document.getElementById('calendar');
                if (!calendarEl) {
                    console.error('Calendar element not found');
                    return;
                }

                const calendar = new tempusDominus.TempusDominus(calendarEl, {
                    display: {
                        inline: true,
                        components: {
                            clock: false,
                            seconds: false,
                        },
                        icons: {
                            previous: 'fas fa-angle-left',
                            next: 'fas fa-angle-right'
                        },
                        buttons: {
                            today: false,
                            clear: false,
                            close: false
                        },
                        calendarWeeks: false
                    },
                    localization: {
                        locale: 'vi',
                        dayViewHeaderFormat: {
                            month: 'long',
                            year: 'numeric'
                        },
                        startOfTheWeek: 1, // Bắt đầu từ thứ Hai

                        hourCycle: 'h23'
                    },
                    restrictions: {
                        minDate: new Date(),
                        maxDate: new Date(new Date().setMonth(new Date().getYear() + 1))
                    }
                });

                // Function để xác định thời gian trong ngày dựa trên chuỗi thời gian
                function getTimeOfDay(timeStr) {
                    if (!timeStr) return null;
                    const hour = parseInt(timeStr.split(':')[0]);
                    if (hour >= 5 && hour < 12) return 'morning';
                    if (hour >= 12 && hour < 17) return 'afternoon';
                    return 'evening';
                }

                // Function để cập nhật hiển thị ngày và thời gian đã chọn
                function updateSelectedDateTime(date, timeStr) {
                    const options = {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric'
                    };
                    const dateObj = new Date(date);
                    const formattedDate = dateObj.toLocaleDateString('en-US', options);

                    const displayText = timeStr ?
                        `${timeStr}, ${formattedDate}` :
                        'Please select a date and time';

                    const dateTimeEl = document.getElementById('selected-datetime');
                    if (dateTimeEl) {
                        dateTimeEl.textContent = displayText;
                    }
                }

                // Function để tạo nút khung giờ
                function createSlotButton(slot) {
                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className = `time-slot-btn ${slot.is_booked ? 'disabled' : 'available'}`;
                    button.textContent = slot.label;
                    button.disabled = slot.is_booked;

                    if (!slot.is_booked) {
                        button.addEventListener('click', function() {
                            // Xóa class active từ tất cả các nút
                            document.querySelectorAll('.time-slot-btn').forEach(btn => {
                                btn.classList.remove('active');
                            });

                            // Thêm class active cho nút được click
                            button.classList.add('active');

                            // Đặt giá trị thời gian đã chọn vào input ẩn
                            const input = document.createElement('input');
                            input.type = 'hidden';
                            input.name = 'selected_time';
                            input.value = slot.id;

                            // Cập nhật hiển thị ngày và thời gian đã chọn
                            const selectedDateInput = document.getElementById('selected_date');
                            if (selectedDateInput) {
                                updateSelectedDateTime(selectedDateInput.value, slot.label);
                            }

                            // Xóa các input selected_time đã tồn tại
                            document.querySelectorAll('input[name="selected_time"]').forEach(el => el.remove());

                            // Thêm input mới vào form
                            const form = document.querySelector('form');
                            if (form) {
                                form.appendChild(input);
                            }
                        });
                    }

                    return button;
                }

                // Function để tạo placeholder cho khung giờ trống
                function createEmptySlot() {
                    const placeholder = document.createElement('button');
                    placeholder.type = 'button';
                    placeholder.className = 'time-slot-btn disabled';
                    placeholder.textContent = '--:--';
                    placeholder.disabled = true;
                    return placeholder;
                }

                // Function để hiển thị khung giờ cho ngày đã chọn
                function renderTimeSlots(date) {
                    const morningContainer = document.getElementById('morning-slots');
                    const afternoonContainer = document.getElementById('afternoon-slots');
                    const eveningContainer = document.getElementById('evening-slots');
                    const timeSlotsDiv = document.getElementById('time-slots');
                    const noSlotsMessage = document.getElementById('no-slots-message');

                    if (!morningContainer || !afternoonContainer || !eveningContainer || !timeSlotsDiv || !
                        noSlotsMessage) {
                        console.error('Some time slot containers not found');
                        return;
                    }

                    // Xóa khung giờ trước đó
                    morningContainer.innerHTML = '';
                    afternoonContainer.innerHTML = '';
                    eveningContainer.innerHTML = '';

                    // Tìm khung giờ cho ngày đã chọn
                    const match = slotData.find(d => d.date === date);

                    // Nếu không có khung giờ nào
                    if (!match || !match.slots || match.slots.length === 0) {
                        timeSlotsDiv.classList.add('d-none');
                        noSlotsMessage.classList.remove('d-none');
                        updateSelectedDateTime(date, null);
                        return;
                    }

                    // Hiển thị khung giờ và ẩn thông báo không có khung giờ
                    timeSlotsDiv.classList.remove('d-none');
                    noSlotsMessage.classList.add('d-none');

                    // Nhóm khung giờ theo thời gian trong ngày
                    const slotsByTime = {
                        morning: [],
                        afternoon: [],
                        evening: []
                    };

                    // Phân loại khung giờ
                    match.slots.forEach(slot => {
                        const timeOfDay = getTimeOfDay(slot.label);
                        if (timeOfDay) {
                            slotsByTime[timeOfDay].push(slot);
                        }
                    });

                    // Tạo nút khung giờ cho mỗi khoảng thời gian
                    const createSlotsForPeriod = (slots, container, minCount = 4) => {
                        if (slots.length === 0) {
                            // Tạo khung giờ trống nếu không có khung giờ nào
                            for (let i = 0; i < minCount; i++) {
                                container.appendChild(createEmptySlot());
                            }
                        } else {
                            // Tạo nút khung giờ thực tế
                            slots.forEach(slot => {
                                container.appendChild(createSlotButton(slot));
                            });

                            // Điền với khung giờ trống nếu ít hơn số lượng tối thiểu
                            const remaining = minCount - slots.length;
                            if (remaining > 0) {
                                for (let i = 0; i < remaining; i++) {
                                    container.appendChild(createEmptySlot());
                                }
                            }
                        }
                    };

                    // Hiển thị khung giờ cho mỗi khoảng thời gian
                    createSlotsForPeriod(slotsByTime.morning, morningContainer, 8);
                    createSlotsForPeriod(slotsByTime.afternoon, afternoonContainer, 8);
                    createSlotsForPeriod(slotsByTime.evening, eveningContainer, 8);

                    // Cập nhật hiển thị ngày đã chọn
                    updateSelectedDateTime(date, null);
                }

                // Event handler khi thay đổi ngày
                calendar.subscribe(tempusDominus.Namespace.events.change, (e) => {
                    console.log('Calendar change triggered:', e.date);
                    const selectedDate = e.date;
                    if (!selectedDate) return;

                    const formatted = selectedDate.toISOString().split('T')[0];
                    const selectedDateInput = document.getElementById('selected_date');
                    if (selectedDateInput) {
                        selectedDateInput.value = formatted;
                    }

                    // Hiển thị khung giờ cho ngày đã chọn
                    renderTimeSlots(formatted);
                });

                // Tự động chọn ngày đầu tiên nếu có dữ liệu
                // Sửa đoạn này
                if (slotData && slotData.length > 0) {
                    const firstDate = new Date(slotData[0].date);
                    calendar.dates.setValue(firstDate);

                    const formatted = firstDate.toISOString().split('T')[0];
                    renderTimeSlots(formatted);

                    setTimeout(() => {
                        calendar._eventEmitter.emit(tempusDominus.Namespace.events.change, {
                            date: firstDate
                        });
                    }, 300);

                    const selectedDateInput = document.getElementById('selected_date');
                    if (selectedDateInput) {
                        selectedDateInput.value = slotData[0].date;
                    }

                } else {
                    console.log('No slot data available, will show the current date');

                    // Nếu không có dữ liệu, hiển thị ngày hiện tại
                    const today = new Date();

                    // Đặt ngày hiện tại cho calendar
                    calendar.dates.setValue(today);

                    const todayFormatted = today.toISOString().split('T')[0];
                    const selectedDateInput = document.getElementById('selected_date');
                    if (selectedDateInput) {
                        selectedDateInput.value = todayFormatted;
                    }

                    // Hiển thị khung giờ cho ngày hiện tại
                    renderTimeSlots(todayFormatted);
                }

                // Thêm logging để debug
                console.log('Tempus Dominus initialized successfully');

                // Sửa hiển thị các ngày trong tuần
                function fixWeekdaysDisplay() {
                    // Tìm phần tử chứa ngày trong tuần
                    // Lưu ý: selector có thể khác nhau tùy theo phiên bản Tempus Dominus
                    // Thử các selector khác nhau
                    let dayHeaders = document.querySelectorAll('.tempus-dominus-widget .dow');
                    if (!dayHeaders || dayHeaders.length === 0) {
                        dayHeaders = document.querySelectorAll('.bootstrap-datetimepicker-widget .dow');
                    }
                    if (!dayHeaders || dayHeaders.length === 0) {
                        dayHeaders = document.querySelectorAll('[data-bs-toggle="datetimepicker"] .dow');
                    }

                    if (dayHeaders && dayHeaders.length === 7) {
                        console.log('Tìm thấy phần tử ngày trong tuần, tiến hành sửa');
                        const correctDays = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];
                        for (let i = 0; i < dayHeaders.length; i++) {
                            dayHeaders[i].textContent = correctDays[i];
                        }
                    } else {
                        console.error('Không tìm thấy phần tử ngày trong tuần:', dayHeaders);
                    }
                }


                setTimeout(fixWeekdaysDisplay, 200);

                // Thêm event listener để sửa lại mỗi khi có thay đổi trên calendar
                document.addEventListener('click', function(e) {
                    // Kiểm tra nếu click vào nút chuyển tháng
                    if (e.target.closest('.tempus-dominus-widget .previous, .tempus-dominus-widget .next') ||
                        e.target.closest(
                            '.bootstrap-datetimepicker-widget .previous, .bootstrap-datetimepicker-widget .next'
                        )) {
                        setTimeout(fixWeekdaysDisplay, 200);
                    }
                });

                // Đảm bảo sửa luôn khi calendar được mở
                document.addEventListener('shown.td.datepicker', function() {
                    setTimeout(fixWeekdaysDisplay, 200);
                });
            });
        </script>
    @endsection
