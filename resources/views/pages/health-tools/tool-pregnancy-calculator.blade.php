@extends('layouts.master')

@section('main-content')
    <div class="pregnancy-calculator-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/tools">Công cụ sức khỏe</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tính ngày dự sinh</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Phần chính - Form nhập liệu -->
                <div class="col-lg-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-baby me-2"></i>Tính ngày dự sinh</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-4">Công cụ này giúp các mẹ bầu tính ngày dự sinh và các mốc quan trọng của thai
                                kỳ dựa trên ngày đầu tiên của kỳ kinh nguyệt cuối cùng, ngày thụ thai hoặc kết quả siêu âm.
                            </p>

                            <form id="pregnancyForm" class="mb-4">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="calculationType" class="form-label">Phương pháp tính <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="calculationType" required>
                                            <option value="lmp" selected>Ngày đầu tiên của kỳ kinh nguyệt cuối</option>
                                            <option value="conception">Ngày thụ thai</option>
                                            <option value="ultrasound">Ngày siêu âm</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label id="dateInputLabel" for="dateInput" class="form-label">Ngày đầu tiên của kỳ
                                            kinh nguyệt cuối <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="dateInput" required>
                                    </div>
                                </div>

                                <div id="ultrasoundSection" class="row mb-3" style="display: none;">
                                    <div class="col-md-6">
                                        <label for="ultrasoundWeeks" class="form-label">Số tuần thai theo siêu âm <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="ultrasoundWeeks" min="0"
                                            max="42">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="ultrasoundDays" class="form-label">Số ngày thêm <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="ultrasoundDays" min="0"
                                            max="6" value="0">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="cycleLength" class="form-label">Độ dài chu kỳ kinh nguyệt (ngày)</label>
                                        <input type="number" class="form-control" id="cycleLength" min="21"
                                            max="45" value="28">
                                        <small class="text-muted">Chu kỳ trung bình là 28 ngày</small>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="isIVF">
                                            <label class="form-check-label" for="isIVF">Mang thai qua thụ tinh ống nghiệm
                                                (IVF)</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Tính ngày dự sinh</button>
                                </div>
                            </form>

                            <!-- Kết quả sẽ hiển thị ở đây -->
                            <div id="pregnancyResult" class="mt-4" style="display: none;">
                                <div class="result-container rounded border p-3">
                                    <h5 class="result-title mb-3">Kết quả tính ngày dự sinh</h5>

                                    <div class="due-date-section mb-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <div class="due-date text-center">
                                                    <span id="dueDate"
                                                        class="d-block display-4 fw-bold text-primary">01/01/2025</span>
                                                    <span class="text-muted">Ngày dự sinh</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="pregnancy-status bg-light rounded p-3">
                                                    <h6 class="mb-2">Thông tin thai kỳ:</h6>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span>Tuổi thai hiện tại:</span>
                                                        <span id="currentGestationalAge" class="fw-bold">10 tuần 2
                                                            ngày</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span>Tam cá nguyệt:</span>
                                                        <span id="currentTrimester" class="fw-bold">Đầu tiên</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Thời gian còn lại:</span>
                                                        <span id="remainingTime" class="fw-bold">30 tuần</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="key-dates mb-4">
                                        <h6 class="mb-3">Các mốc quan trọng của thai kỳ</h6>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <div class="key-date-card rounded border p-3">
                                                    <div class="date-title">Siêu âm đầu tiên</div>
                                                    <div class="date-value fw-bold" id="firstUltrasound">12/12/2024</div>
                                                    <div class="date-description text-muted small">6-8 tuần, xác nhận thai
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="key-date-card rounded border p-3">
                                                    <div class="date-title">Kết thúc tam cá nguyệt 1</div>
                                                    <div class="date-value fw-bold" id="firstTrimesterEnd">12/12/2024
                                                    </div>
                                                    <div class="date-description text-muted small">12 tuần</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="key-date-card rounded border p-3">
                                                    <div class="date-title">Xác định giới tính</div>
                                                    <div class="date-value fw-bold" id="genderScan">12/12/2024</div>
                                                    <div class="date-description text-muted small">18-20 tuần</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="key-date-card rounded border p-3">
                                                    <div class="date-title">Kết thúc tam cá nguyệt 2</div>
                                                    <div class="date-value fw-bold" id="secondTrimesterEnd">12/12/2024
                                                    </div>
                                                    <div class="date-description text-muted small">24 tuần</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="key-date-card rounded border p-3">
                                                    <div class="date-title">Bắt đầu tuần bé trưởng thành</div>
                                                    <div class="date-value fw-bold" id="fullTerm">12/12/2024</div>
                                                    <div class="date-description text-muted small">37 tuần</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <div class="key-date-card rounded border p-3">
                                                    <div class="date-title">Ngày dự sinh</div>
                                                    <div class="date-value fw-bold" id="dueDateCard">12/12/2024</div>
                                                    <div class="date-description text-muted small">40 tuần</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pregnancy-timeline mb-4">
                                        <h6 class="mb-3">Tiến trình thai kỳ</h6>
                                        <div class="progress" style="height: 30px;">
                                            <div id="pregnancyProgress" class="progress-bar bg-primary"
                                                role="progressbar" style="width: 25%;" aria-valuenow="25"
                                                aria-valuemin="0" aria-valuemax="100">25%</div>
                                        </div>
                                        <div class="d-flex justify-content-between mt-2">
                                            <span>Tam cá nguyệt 1</span>
                                            <span>Tam cá nguyệt 2</span>
                                            <span>Tam cá nguyệt 3</span>
                                        </div>
                                    </div>

                                    <div id="pregnancyExplanation" class="pregnancy-explanation bg-light rounded p-3">
                                        <h6><i class="fas fa-info-circle text-primary me-2"></i>Thông tin bổ sung</h6>
                                        <p class="mb-0">Ngày dự sinh được tính dựa trên ngày đầu tiên của kỳ kinh nguyệt
                                            cuối cùng, sử dụng công thức Naegele (cộng 7 ngày, trừ 3 tháng, cộng 1 năm). Nhớ
                                            rằng chỉ khoảng 5% phụ nữ sinh đúng ngày dự sinh. Hầu hết em bé chào đời trong
                                            khoảng 2 tuần trước hoặc sau ngày dự sinh.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar - Thông tin bổ sung -->
                <div class="col-lg-4">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Về ngày dự sinh</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Ngày dự sinh là gì?</h6>
                            <p>Ngày dự sinh (Estimated Due Date - EDD) là ngày dự kiến em bé chào đời, thường là 40 tuần kể
                                từ ngày đầu tiên của kỳ kinh nguyệt cuối cùng của mẹ.</p>
                            <p>Tuy nhiên, chỉ khoảng 5% phụ nữ sinh đúng ngày dự sinh. Hầu hết em bé chào đời trong khoảng 2
                                tuần trước hoặc sau ngày dự sinh.</p>
                            <h6 class="mb-2">Các phương pháp tính ngày dự sinh:</h6>
                            <ul>
                                <li><strong>Ngày đầu tiên của kỳ kinh nguyệt cuối:</strong> Phương pháp phổ biến nhất</li>
                                <li><strong>Ngày thụ thai:</strong> Nếu biết chính xác ngày thụ thai</li>
                                <li><strong>Kết quả siêu âm:</strong> Dựa trên kích thước và sự phát triển của thai nhi</li>
                                <li><strong>IVF:</strong> Dựa trên ngày chuyển phôi</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Các tam cá nguyệt thai kỳ</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Tam cá nguyệt thứ nhất (tuần 1-12)</h6>
                            <p>Giai đoạn phát triển cơ quan quan trọng. Có thể có các triệu chứng như buồn nôn, mệt mỏi và
                                thay đổi vị giác.</p>

                            <h6 class="mb-2">Tam cá nguyệt thứ hai (tuần 13-26)</h6>
                            <p>Thai nhi phát triển nhanh, cơ thể mẹ thích nghi tốt hơn. Có thể cảm nhận được cử động đầu
                                tiên của bé (quickening).</p>

                            <h6 class="mb-2">Tam cá nguyệt thứ ba (tuần 27-40)</h6>
                            <p>Thai nhi tăng cân và chuẩn bị cho việc chào đời. Mẹ có thể cảm thấy khó chịu và gặp khó khăn
                                khi di chuyển.</p>
                            <p class="text-danger mb-0"><i class="fas fa-exclamation-circle me-1"></i> Lưu ý: Công cụ này
                                chỉ cung cấp ước tính. Luôn tham khảo ý kiến từ chuyên gia y tế.</p>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Công cụ liên quan</h5>
                        </div>
                        <div class="card-body">
                            <div class="related-tools">
                                <a href="/tools/calorie-needs"
                                    class="related-tool-item d-flex align-items-center mb-2 rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-utensils text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính nhu cầu calo</div>
                                        <small class="text-muted">Nhu cầu dinh dưỡng khi mang thai</small>
                                    </div>
                                </a>

                                <a href="/tools/water-intake"
                                    class="related-tool-item d-flex align-items-center mb-2 rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-tint text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Lượng nước cần uống</div>
                                        <small class="text-muted">Nhu cầu nước khi mang thai</small>
                                    </div>
                                </a>

                                <a href="/tools/bmi-calculator"
                                    class="related-tool-item d-flex align-items-center rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-calculator text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính chỉ số BMI</div>
                                        <small class="text-muted">Đánh giá BMI trước mang thai</small>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Key date card styling */
        .key-date-card {
            transition: transform 0.2s;
        }

        .key-date-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* Related tools */
        .related-tool-item {
            transition: background-color 0.2s;
            text-decoration: none;
            color: inherit;
        }

        .related-tool-item:hover {
            background-color: #f8f9fa;
        }

        .tool-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-primary {
            background-color: #1565c0 !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pregnancyForm = document.getElementById('pregnancyForm');
            const resultDiv = document.getElementById('pregnancyResult');
            const calculationType = document.getElementById('calculationType');
            const dateInputLabel = document.getElementById('dateInputLabel');
            const ultrasoundSection = document.getElementById('ultrasoundSection');
            const isIVF = document.getElementById('isIVF');

            // Thay đổi label và hiện/ẩn các trường tùy theo phương pháp tính
            calculationType.addEventListener('change', function() {
                switch (this.value) {
                    case 'lmp':
                        dateInputLabel.textContent = 'Ngày đầu tiên của kỳ kinh nguyệt cuối';
                        ultrasoundSection.style.display = 'none';
                        document.getElementById('cycleLength').parentElement.style.display = 'block';
                        break;
                    case 'conception':
                        dateInputLabel.textContent = 'Ngày thụ thai';
                        ultrasoundSection.style.display = 'none';
                        document.getElementById('cycleLength').parentElement.style.display = 'none';
                        break;
                    case 'ultrasound':
                        dateInputLabel.textContent = 'Ngày siêu âm';
                        ultrasoundSection.style.display = 'flex';
                        document.getElementById('cycleLength').parentElement.style.display = 'none';
                        break;
                }
            });

            pregnancyForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Lấy giá trị đầu vào
                const calculationMethod = calculationType.value;
                const dateInput = new Date(document.getElementById('dateInput').value);
                const cycleLength = parseInt(document.getElementById('cycleLength').value);
                const ivfPregnancy = isIVF.checked;

                // Kiểm tra nếu ngày nhập vào hợp lệ
                if (isNaN(dateInput.getTime())) {
                    alert('Vui lòng chọn ngày hợp lệ');
                    return;
                }

                // Tính ngày dự sinh
                let dueDate = new Date();
                let conception = new Date(); // Ngày thụ thai (ước tính)

                // Tính ngày dự sinh dựa trên phương pháp được chọn
                if (calculationMethod === 'lmp') {
                    if (ivfPregnancy) {
                        // Với IVF, ngày dự sinh là 266 ngày từ ngày chuyển phôi
                        dueDate = new Date(dateInput);
                        dueDate.setDate(dateInput.getDate() + 266);
                        conception = new Date(dateInput); // Ngày chuyển phôi được coi là ngày thụ thai
                    } else {
                        // Công thức Naegele: Thêm 7 ngày và thêm 9 tháng (= trừ 3 tháng + thêm 1 năm)
                        // Điều chỉnh theo chu kỳ kinh nếu khác 28 ngày
                        const adjustment = cycleLength - 28;
                        dueDate = new Date(dateInput);
                        dueDate.setDate(dateInput.getDate() + 7 + adjustment);
                        dueDate.setMonth(dateInput.getMonth() + 9);

                        // Ước tính ngày thụ thai (thường là 14 ngày sau ngày đầu kỳ kinh, điều chỉnh theo chu kỳ)
                        conception = new Date(dateInput);
                        conception.setDate(dateInput.getDate() + 14 + (adjustment / 2));
                    }
                } else if (calculationMethod === 'conception') {
                    // Nếu biết ngày thụ thai, thêm 266 ngày
                    dueDate = new Date(dateInput);
                    dueDate.setDate(dateInput.getDate() + 266);
                    conception = new Date(dateInput);
                } else if (calculationMethod === 'ultrasound') {
                    // Dựa trên tuổi thai từ siêu âm
                    const ultrasoundWeeks = parseInt(document.getElementById('ultrasoundWeeks').value);
                    const ultrasoundDays = parseInt(document.getElementById('ultrasoundDays').value);

                    // Tính tổng số ngày của thai
                    const totalDays = (ultrasoundWeeks * 7) + ultrasoundDays;

                    // Tính ngày LMP ước tính từ kết quả siêu âm
                    const estimatedLMP = new Date(dateInput);
                    estimatedLMP.setDate(dateInput.getDate() - totalDays);

                    // Tính ngày dự sinh từ LMP ước tính
                    dueDate = new Date(estimatedLMP);
                    dueDate.setDate(estimatedLMP.getDate() + 280);

                    // Ước tính ngày thụ thai
                    conception = new Date(estimatedLMP);
                    conception.setDate(estimatedLMP.getDate() + 14);
                }

                // Lấy ngày hiện tại
                const today = new Date();

                // Tính tuổi thai hiện tại (tính từ ngày thụ thai ước tính)
                const gestationalAgeMs = today - conception;
                const gestationalAgeDays = Math.floor(gestationalAgeMs / (1000 * 60 * 60 * 24)) +
                    14; // +14 vì tính từ LMP
                const gestationalAgeWeeks = Math.floor(gestationalAgeDays / 7);
                const gestationalAgeDaysRemainder = gestationalAgeDays % 7;

                // Xác định tam cá nguyệt hiện tại
                let currentTrimester;
                if (gestationalAgeDays < 84) { // 0-12 tuần
                    currentTrimester = "Đầu tiên";
                } else if (gestationalAgeDays < 189) { // 13-27 tuần
                    currentTrimester = "Thứ hai";
                } else {
                    currentTrimester = "Thứ ba";
                }

                // Tính thời gian còn lại
                const remainingTimeMs = dueDate - today;
                const remainingDays = Math.floor(remainingTimeMs / (1000 * 60 * 60 * 24));
                const remainingWeeks = Math.floor(remainingDays / 7);
                const remainingDaysRemainder = remainingDays % 7;

                // Tính tiến trình thai kỳ
                const totalPregnancyDays = 280;
                const pregnancyProgressPercent = Math.min(100, Math.round((gestationalAgeDays /
                    totalPregnancyDays) * 100));

                // Tính các mốc quan trọng
                // 1. Siêu âm đầu tiên (khoảng 8 tuần)
                const firstUltrasoundDate = new Date(conception);
                firstUltrasoundDate.setDate(conception.getDate() + 42); // 6 tuần sau thụ thai

                // 2. Kết thúc tam cá nguyệt 1 (12 tuần)
                const firstTrimesterEndDate = new Date(conception);
                firstTrimesterEndDate.setDate(conception.getDate() + 70); // 10 tuần sau thụ thai

                // 3. Siêu âm xác định giới tính (khoảng 20 tuần)
                const genderScanDate = new Date(conception);
                genderScanDate.setDate(conception.getDate() + 126); // 18 tuần sau thụ thai

                // 4. Kết thúc tam cá nguyệt 2 (27 tuần)
                const secondTrimesterEndDate = new Date(conception);
                secondTrimesterEndDate.setDate(conception.getDate() + 175); // 25 tuần sau thụ thai

                // 5. Bắt đầu tuần bé trưởng thành (37 tuần)
                const fullTermDate = new Date(conception);
                fullTermDate.setDate(conception.getDate() + 245); // 35 tuần sau thụ thai

                // Định dạng các ngày thành chuỗi
                function formatDate(date) {
                    return date.toLocaleDateString('vi-VN', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    });
                }

                // Cập nhật giao diện
                document.getElementById('dueDate').textContent = formatDate(dueDate);
                document.getElementById('dueDateCard').textContent = formatDate(dueDate);

                // Thông tin thai kỳ
                if (gestationalAgeDays > 0) {
                    document.getElementById('currentGestationalAge').textContent =
                        `${gestationalAgeWeeks} tuần ${gestationalAgeDaysRemainder} ngày`;
                    document.getElementById('currentTrimester').textContent = currentTrimester;

                    if (remainingDays > 0) {
                        document.getElementById('remainingTime').textContent =
                            `${remainingWeeks} tuần ${remainingDaysRemainder} ngày`;
                    } else {
                        document.getElementById('remainingTime').textContent = "Đã quá ngày dự sinh";
                    }
                } else {
                    // Trường hợp tính ngày trước khi thụ thai
                    document.getElementById('currentGestationalAge').textContent = "Chưa bắt đầu";
                    document.getElementById('currentTrimester').textContent = "Chưa bắt đầu";
                    document.getElementById('remainingTime').textContent = "Khoảng 40 tuần";
                }

                // Cập nhật các mốc quan trọng
                document.getElementById('firstUltrasound').textContent = formatDate(firstUltrasoundDate);
                document.getElementById('firstTrimesterEnd').textContent = formatDate(
                    firstTrimesterEndDate);
                document.getElementById('genderScan').textContent = formatDate(genderScanDate);
                document.getElementById('secondTrimesterEnd').textContent = formatDate(
                    secondTrimesterEndDate);
                document.getElementById('fullTerm').textContent = formatDate(fullTermDate);

                // Cập nhật tiến trình thai kỳ
                document.getElementById('pregnancyProgress').style.width = `${pregnancyProgressPercent}%`;
                document.getElementById('pregnancyProgress').setAttribute('aria-valuenow',
                    pregnancyProgressPercent);
                document.getElementById('pregnancyProgress').textContent = `${pregnancyProgressPercent}%`;

                // Cập nhật lời giải thích
                // Cập nhật lời giải thích
                let explanation;
                if (calculationMethod === 'lmp') {
                    explanation =
                        `Ngày dự sinh được tính dựa trên ngày đầu tiên của kỳ kinh nguyệt cuối cùng (${formatDate(dateInput)}), ${ivfPregnancy ? 'và đã được điều chỉnh cho trường hợp mang thai qua thụ tinh ống nghiệm (IVF)' : 'sử dụng công thức Naegele (cộng 7 ngày, trừ 3 tháng, cộng 1 năm)'}. Nhớ rằng chỉ khoảng 5% phụ nữ sinh đúng ngày dự sinh. Hầu hết em bé chào đời trong khoảng 2 tuần trước hoặc sau ngày dự sinh.`;
                } else if (calculationMethod === 'conception') {
                    explanation =
                        `Ngày dự sinh được tính dựa trên ngày thụ thai (${formatDate(dateInput)}) cộng thêm 266 ngày (khoảng 38 tuần). Nhớ rằng chỉ khoảng 5% phụ nữ sinh đúng ngày dự sinh. Hầu hết em bé chào đời trong khoảng 2 tuần trước hoặc sau ngày dự sinh.`;
                } else {
                    explanation =
                        `Ngày dự sinh được tính dựa trên kết quả siêu âm ngày ${formatDate(dateInput)} với tuổi thai ${document.getElementById('ultrasoundWeeks').value} tuần ${document.getElementById('ultrasoundDays').value} ngày. Kết quả siêu âm trong tam cá nguyệt đầu tiên thường chính xác hơn để xác định ngày dự sinh.`;
                }

                document.getElementById('pregnancyExplanation').querySelector('p').textContent =
                    explanation;

                // Hiển thị kết quả
                resultDiv.style.display = 'block';

                // Cuộn xuống phần kết quả
                resultDiv.scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
@endsection
