@extends('layouts.master')

@section('main-content')
    <div class="blood-pressure-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/tools">Công cụ sức khỏe</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Đánh giá huyết áp</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Phần chính - Form nhập liệu -->
                <div class="col-lg-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-stethoscope me-2"></i>Đánh giá huyết áp</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-4">Huyết áp là một chỉ số quan trọng về sức khỏe tim mạch. Công cụ này giúp bạn
                                đánh giá huyết áp theo tiêu chuẩn của Hiệp hội Tim mạch Hoa Kỳ (AHA).</p>

                            <form id="bpForm" class="mb-4">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="systolic" class="form-label">Huyết áp tâm thu (mmHg) <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="systolic" min="70"
                                                max="250" required>
                                            <span class="input-group-text">mmHg</span>
                                        </div>
                                        <small class="text-muted">Chỉ số cao (số đầu tiên)</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="diastolic" class="form-label">Huyết áp tâm trương (mmHg) <span
                                                class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="number" class="form-control" id="diastolic" min="40"
                                                max="150" required>
                                            <span class="input-group-text">mmHg</span>
                                        </div>
                                        <small class="text-muted">Chỉ số thấp (số thứ hai)</small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="age" class="form-label">Tuổi</label>
                                        <input type="number" class="form-control" id="age" min="18"
                                            max="120">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Giới tính</label>
                                        <select class="form-select" id="gender">
                                            <option value="male">Nam</option>
                                            <option value="female">Nữ</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label d-block">Tiền sử bệnh</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="hasDiabetes">
                                            <label class="form-check-label" for="hasDiabetes">Tiểu đường</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="hasHeartDisease">
                                            <label class="form-check-label" for="hasHeartDisease">Bệnh tim</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="hasKidneyDisease">
                                            <label class="form-check-label" for="hasKidneyDisease">Bệnh thận</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label d-block">Yếu tố nguy cơ</label>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="isSmoking">
                                            <label class="form-check-label" for="isSmoking">Hút thuốc</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="isOverweight">
                                            <label class="form-check-label" for="isOverweight">Thừa cân</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Đánh giá huyết áp</button>
                                </div>
                            </form>

                            <!-- Kết quả sẽ hiển thị ở đây -->
                            <div id="bpResult" class="mt-4" style="display: none;">
                                <div class="result-container rounded border p-3">
                                    <h5 class="result-title mb-3">Kết quả đánh giá huyết áp</h5>

                                    <div class="bp-reading mb-4 text-center">
                                        <span id="bpValue" class="d-block display-4 fw-bold">120/80</span>
                                        <span class="text-muted">Huyết áp của bạn</span>
                                    </div>

                                    <div class="bp-category mb-4 text-center">
                                        <div id="categoryBadge" class="badge bg-success mb-2 p-2">Bình thường</div>
                                        <h5 id="categoryTitle" class="mb-2">Huyết áp bình thường</h5>
                                        <p id="categoryDescription" class="mb-0">Huyết áp của bạn nằm trong ngưỡng lý
                                            tưởng. Tiếp tục duy trì lối sống lành mạnh.</p>
                                    </div>

                                    <!-- Thang đo huyết áp -->
                                    <div class="bp-chart mb-4">
                                        <h6 class="mb-3">Phân loại huyết áp:</h6>
                                        <div class="bp-scale">
                                            <div class="bp-scale-item d-flex bg-success mb-2 rounded p-2 text-white">
                                                <div class="bp-scale-range me-2 flex-shrink-0" style="width: 100px;">
                                                    <strong>&lt;120/80</strong>
                                                </div>
                                                <div class="bp-scale-label">
                                                    Bình thường
                                                </div>
                                            </div>
                                            <div class="bp-scale-item d-flex bg-info mb-2 rounded p-2 text-white">
                                                <div class="bp-scale-range me-2 flex-shrink-0" style="width: 100px;">
                                                    <strong>120-129/&lt;80</strong>
                                                </div>
                                                <div class="bp-scale-label">
                                                    Huyết áp cao (cảnh báo)
                                                </div>
                                            </div>
                                            <div class="bp-scale-item d-flex bg-warning text-dark mb-2 rounded p-2">
                                                <div class="bp-scale-range me-2 flex-shrink-0" style="width: 100px;">
                                                    <strong>130-139/80-89</strong>
                                                </div>
                                                <div class="bp-scale-label">
                                                    Tăng huyết áp giai đoạn 1
                                                </div>
                                            </div>
                                            <div class="bp-scale-item d-flex bg-danger mb-2 rounded p-2 text-white">
                                                <div class="bp-scale-range me-2 flex-shrink-0" style="width: 100px;">
                                                    <strong>140+/90+</strong>
                                                </div>
                                                <div class="bp-scale-label">
                                                    Tăng huyết áp giai đoạn 2
                                                </div>
                                            </div>
                                            <div class="bp-scale-item d-flex bg-dark mb-2 rounded p-2 text-white">
                                                <div class="bp-scale-range me-2 flex-shrink-0" style="width: 100px;">
                                                    <strong>180+/120+</strong>
                                                </div>
                                                <div class="bp-scale-label">
                                                    Tăng huyết áp cấp cứu
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="bpRecommendation" class="bp-recommendation bg-light rounded p-3">
                                        <h6><i class="fas fa-lightbulb text-warning me-2"></i>Khuyến nghị</h6>
                                        <p class="mb-0" id="recommendationText">Duy trì chế độ ăn uống lành mạnh, tập
                                            thể dục đều đặn và hạn chế muối.</p>
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
                            <h5 class="mb-0">Hiểu về huyết áp</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Huyết áp là gì?</h6>
                            <p>Huyết áp là áp lực của máu lên thành mạch máu khi tim bơm. Nó được đo bằng hai chỉ số:</p>
                            <ul>
                                <li><strong>Huyết áp tâm thu (Systolic):</strong> Áp lực khi tim co bóp, bơm máu.</li>
                                <li><strong>Huyết áp tâm trương (Diastolic):</strong> Áp lực khi tim giãn ra, nghỉ giữa
                                    những nhịp đập.</li>
                            </ul>
                            <p class="mb-0">Huyết áp được ghi dưới dạng <strong>Tâm thu/Tâm trương</strong>, ví dụ:
                                120/80 mmHg.</p>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Lưu ý về huyết áp</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Làm thế nào để đo huyết áp chính xác?</h6>
                            <ul>
                                <li>Không ăn, hút thuốc hoặc tập thể dục 30 phút trước khi đo</li>
                                <li>Đi vệ sinh trước khi đo</li>
                                <li>Ngồi trên ghế, lưng thẳng, chân đặt trên sàn</li>
                                <li>Đặt cánh tay trên bàn ngang với tim</li>
                                <li>Thả lỏng và không nói chuyện trong quá trình đo</li>
                                <li>Đo 2-3 lần, mỗi lần cách nhau 1-2 phút</li>
                            </ul>
                            <p class="text-danger mb-0"><i class="fas fa-exclamation-circle me-1"></i> Công cụ này chỉ
                                mang tính tham khảo, không thay thế cho tư vấn y tế chuyên nghiệp.</p>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Công cụ liên quan</h5>
                        </div>
                        <div class="card-body">
                            <div class="related-tools">
                                <a href="/tools/heart-risk"
                                    class="related-tool-item d-flex align-items-center mb-2 rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-chart-line text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Nguy cơ tim mạch</div>
                                        <small class="text-muted">Đánh giá nguy cơ mắc bệnh tim mạch</small>
                                    </div>
                                </a>

                                <a href="/tools/heart-rate-zones"
                                    class="related-tool-item d-flex align-items-center mb-2 rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-running text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Vùng nhịp tim tập luyện</div>
                                        <small class="text-muted">Tính vùng nhịp tim hiệu quả khi tập thể dục</small>
                                    </div>
                                </a>

                                <a href="/tools/bmi-calculator"
                                    class="related-tool-item d-flex align-items-center rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-calculator text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính chỉ số BMI</div>
                                        <small class="text-muted">Đánh giá cân nặng dựa trên chiều cao</small>
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
        /* BP Scale */
        .bp-scale-item {
            transition: transform 0.2s;
        }

        .bp-scale-item:hover {
            transform: translateX(5px);
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
            const bpForm = document.getElementById('bpForm');
            const resultDiv = document.getElementById('bpResult');

            bpForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Lấy giá trị input
                const systolic = parseInt(document.getElementById('systolic').value);
                const diastolic = parseInt(document.getElementById('diastolic').value);
                const age = parseInt(document.getElementById('age').value || 40);
                const gender = document.getElementById('gender').value;
                const hasDiabetes = document.getElementById('hasDiabetes').checked;
                const hasHeartDisease = document.getElementById('hasHeartDisease').checked;
                const hasKidneyDisease = document.getElementById('hasKidneyDisease').checked;
                const isSmoking = document.getElementById('isSmoking').checked;
                const isOverweight = document.getElementById('isOverweight').checked;

                // Hiển thị giá trị huyết áp
                document.getElementById('bpValue').textContent = `${systolic}/${diastolic}`;

                // Phân loại huyết áp theo AHA
                let category, description, badgeClass, recommendation;

                if (systolic < 120 && diastolic < 80) {
                    category = "Bình thường";
                    description =
                        "Huyết áp của bạn nằm trong ngưỡng lý tưởng. Tiếp tục duy trì lối sống lành mạnh.";
                    badgeClass = "bg-success";
                    recommendation =
                        "Duy trì chế độ ăn uống lành mạnh, tập thể dục đều đặn 150 phút/tuần và kiểm tra huyết áp định kỳ 1 năm/lần.";
                } else if (systolic >= 120 && systolic <= 129 && diastolic < 80) {
                    category = "Huyết áp cao (cảnh báo)";
                    description =
                        "Huyết áp tâm thu của bạn hơi cao. Đây là thời điểm tốt để thực hiện các thay đổi lối sống.";
                    badgeClass = "bg-info";
                    recommendation =
                        "Giảm lượng muối trong khẩu phần ăn (<2300mg/ngày), tăng cường tập thể dục, hạn chế rượu bia và kiểm tra huyết áp 6 tháng/lần.";
                } else if ((systolic >= 130 && systolic <= 139) || (diastolic >= 80 && diastolic <= 89)) {
                    category = "Tăng huyết áp giai đoạn 1";
                    description =
                        "Huyết áp của bạn cao hơn mức khuyến nghị. Cần thay đổi lối sống và có thể cần dùng thuốc.";
                    badgeClass = "bg-warning";

                    // Đánh giá nguy cơ
                    const hasRiskFactors = age > 65 || hasDiabetes || hasHeartDisease || hasKidneyDisease ||
                        isSmoking || isOverweight;

                    if (hasRiskFactors) {
                        recommendation =
                            "Bạn có các yếu tố nguy cơ cao. Nên thăm khám bác sĩ để được tư vấn. Có thể cần dùng thuốc kết hợp với thay đổi lối sống.";
                    } else {
                        recommendation =
                            "Thay đổi lối sống: giảm muối, tăng rau củ quả, tập thể dục đều đặn, giảm cân (nếu thừa cân). Kiểm tra huyết áp 3-6 tháng/lần.";
                    }
                } else if ((systolic >= 140 && systolic <= 179) || (diastolic >= 90 && diastolic <= 119)) {
                    category = "Tăng huyết áp giai đoạn 2";
                    description = "Huyết áp của bạn cao đáng kể. Cần tư vấn y tế và điều trị.";
                    badgeClass = "bg-danger";
                    recommendation =
                        "Cần gặp bác sĩ trong vòng 1 tháng. Có thể cần phối hợp 2 loại thuốc huyết áp cùng với thay đổi lối sống. Kiểm tra huyết áp thường xuyên.";
                } else if (systolic >= 180 || diastolic >= 120) {
                    category = "Tăng huyết áp cấp cứu";
                    description = "Huyết áp của bạn ở mức nguy hiểm. Cần chăm sóc y tế khẩn cấp!";
                    badgeClass = "bg-dark";
                    recommendation =
                        "ĐÂY LÀ TÌNH TRẠNG CẤP CỨU! Cần được chăm sóc y tế ngay lập tức. Vui lòng liên hệ dịch vụ cấp cứu hoặc đến cơ sở y tế gần nhất.";
                }

                // Cập nhật giao diện
                document.getElementById('categoryBadge').textContent = category;
                document.getElementById('categoryBadge').className = `badge ${badgeClass} p-2 mb-2`;
                document.getElementById('categoryTitle').textContent = `Huyết áp ${category.toLowerCase()}`;
                document.getElementById('categoryDescription').textContent = description;
                document.getElementById('recommendationText').textContent = recommendation;

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
