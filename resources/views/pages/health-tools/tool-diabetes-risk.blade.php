@extends('layouts.master')

@section('main-content')
    <div class="diabetes-risk-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/tools">Công cụ sức khỏe</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Đánh giá nguy cơ tiểu đường</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Phần chính - Form nhập liệu -->
                <div class="col-lg-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-syringe me-2"></i>Đánh giá nguy cơ tiểu đường type 2</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-4">Công cụ này giúp bạn đánh giá nguy cơ mắc bệnh tiểu đường type 2 trong vòng 10
                                năm tới. Đây là phiên bản được điều chỉnh từ thang đánh giá FINDRISC (Finnish Diabetes Risk
                                Score) và các nghiên cứu khác.</p>

                            <form id="diabetesRiskForm" class="mb-4">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="age" class="form-label">Tuổi <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="age" required>
                                            <option value="0">Dưới 45 tuổi</option>
                                            <option value="2">45-54 tuổi</option>
                                            <option value="3">55-64 tuổi</option>
                                            <option value="4">Trên 64 tuổi</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Giới tính <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="gender" required>
                                            <option value="male">Nam</option>
                                            <option value="female">Nữ</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="bmi" class="form-label">Chỉ số BMI <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="bmi" required>
                                            <option value="0">Dưới 25 kg/m²</option>
                                            <option value="1">25-30 kg/m²</option>
                                            <option value="3">Trên 30 kg/m²</option>
                                        </select>
                                        <small class="text-muted d-block mt-1">
                                            <a href="/tools/bmi-calculator" target="_blank">Tính BMI của bạn</a>
                                        </small>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="waistCircumference" class="form-label">Chu vi vòng eo <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="waistCircumference" required>
                                            <option value="0">Nam: dưới 94cm | Nữ: dưới 80cm</option>
                                            <option value="3">Nam: 94-102cm | Nữ: 80-88cm</option>
                                            <option value="4">Nam: trên 102cm | Nữ: trên 88cm</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="physicalActivity" class="form-label">Hoạt động thể chất <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="physicalActivity" required>
                                            <option value="0">Ít nhất 30 phút mỗi ngày</option>
                                            <option value="2">Không đều đặn/ít</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="diet" class="form-label">Thói quen ăn rau, trái cây <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="diet" required>
                                            <option value="0">Hàng ngày</option>
                                            <option value="1">Không thường xuyên</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="bloodPressure" class="form-label">Huyết áp cao <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="bloodPressure" required>
                                            <option value="0">Không</option>
                                            <option value="2">Có (hoặc đang điều trị)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bloodGlucose" class="form-label">Tiền sử đường huyết cao <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="bloodGlucose" required>
                                            <option value="0">Không</option>
                                            <option value="5">Có (khi khám, mang thai, bệnh...)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="familyHistory" class="form-label">Tiền sử gia đình mắc tiểu đường <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="familyHistory" required>
                                            <option value="0">Không</option>
                                            <option value="3">Có (ông, bà, cô, dì, chú, bác)</option>
                                            <option value="5">Có (bố, mẹ, anh chị em, con)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Đánh giá nguy cơ</button>
                                </div>
                            </form>

                            <!-- Kết quả sẽ hiển thị ở đây -->
                            <div id="diabetesRiskResult" class="mt-4" style="display: none;">
                                <div class="result-container rounded border p-3">
                                    <h5 class="result-title mb-3">Kết quả đánh giá nguy cơ tiểu đường</h5>

                                    <div class="risk-score-section mb-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <div class="risk-score text-center">
                                                    <span id="riskScore"
                                                        class="d-block display-4 fw-bold text-primary">0</span>
                                                    <span class="text-muted">Điểm nguy cơ của bạn</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div id="riskLevelContainer"
                                                    class="risk-level bg-success rounded p-3 text-center text-white">
                                                    <h5 id="riskLevel" class="mb-0">Nguy cơ thấp</h5>
                                                    <div id="riskPercent" class="mt-1">1% nguy cơ mắc tiểu đường</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="risk-scale mb-4">
                                        <h6 class="mb-2">Thang đánh giá nguy cơ:</h6>
                                        <div class="risk-scale-bars d-flex">
                                            <div
                                                class="flex-grow-1 bg-success mb-1 me-1 rounded p-2 text-center text-white">
                                                <div><strong>Thấp</strong></div>
                                                <div class="small">0-6 điểm</div>
                                                <div class="small">1/100 người</div>
                                            </div>
                                            <div class="flex-grow-1 bg-info mb-1 me-1 rounded p-2 text-center text-white">
                                                <div><strong>Nhẹ</strong></div>
                                                <div class="small">7-11 điểm</div>
                                                <div class="small">1/25 người</div>
                                            </div>
                                            <div
                                                class="flex-grow-1 bg-warning mb-1 me-1 rounded p-2 text-center text-white">
                                                <div><strong>Trung bình</strong></div>
                                                <div class="small">12-14 điểm</div>
                                                <div class="small">1/6 người</div>
                                            </div>
                                            <div class="flex-grow-1 bg-danger mb-1 rounded p-2 text-center text-white">
                                                <div><strong>Cao</strong></div>
                                                <div class="small">15-26 điểm</div>
                                                <div class="small">1/3 người</div>
                                            </div>
                                        </div>
                                        <div class="position-relative">
                                            <div id="riskMarker" class="risk-marker" style="left: 10%;">
                                                <i class="fas fa-caret-down"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="risk-factors mb-4">
                                        <h6 class="mb-2"><i
                                                class="fas fa-exclamation-triangle text-warning me-2"></i>Các yếu tố nguy
                                            cơ của bạn:</h6>
                                        <ul id="riskFactorsList" class="mb-0">
                                            <!-- Danh sách yếu tố nguy cơ sẽ được đưa vào đây -->
                                        </ul>
                                    </div>

                                    <div id="riskRecommendation" class="risk-recommendation bg-light rounded p-3">
                                        <h6><i class="fas fa-lightbulb text-warning me-2"></i>Khuyến nghị</h6>
                                        <p class="mb-0">Dựa vào kết quả đánh giá, bạn có nguy cơ thấp mắc bệnh tiểu đường
                                            type 2. Tuy nhiên, vẫn nên duy trì lối sống lành mạnh, chế độ ăn cân bằng và tập
                                            thể dục đều đặn để duy trì sức khỏe tốt.</p>
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
                            <h5 class="mb-0">Về bệnh tiểu đường type 2</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Tiểu đường type 2 là gì?</h6>
                            <p>Tiểu đường type 2 là tình trạng cơ thể không sử dụng hiệu quả insulin hoặc không sản xuất đủ
                                insulin, dẫn đến lượng đường trong máu cao. Đây là dạng tiểu đường phổ biến nhất, chiếm
                                khoảng 90% các ca bệnh tiểu đường.</p>
                            <h6 class="mb-2">Các yếu tố nguy cơ chính:</h6>
                            <ul>
                                <li>Thừa cân, béo phì</li>
                                <li>Tuổi trên 45</li>
                                <li>Tiền sử gia đình mắc bệnh tiểu đường</li>
                                <li>Ít vận động thể chất</li>
                                <li>Tiền sử đường huyết cao (tiền tiểu đường)</li>
                                <li>Tiền sử tiểu đường thai kỳ</li>
                                <li>Huyết áp cao, rối loạn mỡ máu</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Phòng ngừa tiểu đường</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Làm thế nào để giảm nguy cơ?</h6>
                            <ul>
                                <li><strong>Duy trì cân nặng hợp lý:</strong> Giảm 5-10% cân nặng có thể giảm đáng kể nguy
                                    cơ mắc tiểu đường</li>
                                <li><strong>Tập thể dục đều đặn:</strong> Ít nhất 150 phút mỗi tuần với cường độ vừa phải
                                </li>
                                <li><strong>Ăn uống lành mạnh:</strong> Tăng cường rau củ quả, giảm đường và carbs tinh chế
                                </li>
                                <li><strong>Tránh hút thuốc:</strong> Hút thuốc làm tăng nguy cơ mắc tiểu đường</li>
                                <li><strong>Kiểm soát huyết áp và cholesterol:</strong> Giảm nguy cơ biến chứng tim mạch
                                </li>
                            </ul>
                            <p class="text-danger mb-0"><i class="fas fa-exclamation-circle me-1"></i> Lưu ý: Công cụ này
                                chỉ mang tính tham khảo, không thay thế cho đánh giá y tế chuyên nghiệp. Hãy tham khảo ý
                                kiến bác sĩ nếu bạn lo ngại về nguy cơ mắc tiểu đường.</p>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Công cụ liên quan</h5>
                        </div>
                        <div class="card-body">
                            <div class="related-tools">
                                <a href="/tools/bmi-calculator"
                                    class="related-tool-item d-flex align-items-center mb-2 rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-calculator text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính chỉ số BMI</div>
                                        <small class="text-muted">Đánh giá cân nặng dựa trên chiều cao</small>
                                    </div>
                                </a>

                                <a href="/tools/heart-risk"
                                    class="related-tool-item d-flex align-items-center mb-2 rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-chart-line text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Nguy cơ tim mạch</div>
                                        <small class="text-muted">Đánh giá nguy cơ bệnh tim mạch</small>
                                    </div>
                                </a>

                                <a href="/tools/calorie-needs"
                                    class="related-tool-item d-flex align-items-center rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-utensils text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính nhu cầu calo</div>
                                        <small class="text-muted">Xác định lượng calo cần thiết hàng ngày</small>
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
        /* Risk marker */
        .risk-marker {
            position: absolute;
            top: -10px;
            transform: translateX(-50%);
            color: #333;
            font-size: 20px;
            transition: left 0.5s ease;
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
            const diabetesRiskForm = document.getElementById('diabetesRiskForm');
            const resultDiv = document.getElementById('diabetesRiskResult');

            diabetesRiskForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Lấy giá trị input và tính tổng điểm
                const ageScore = parseInt(document.getElementById('age').value);
                const bmiScore = parseInt(document.getElementById('bmi').value);
                const waistScore = parseInt(document.getElementById('waistCircumference').value);
                const activityScore = parseInt(document.getElementById('physicalActivity').value);
                const dietScore = parseInt(document.getElementById('diet').value);
                const bpScore = parseInt(document.getElementById('bloodPressure').value);
                const glucoseScore = parseInt(document.getElementById('bloodGlucose').value);
                const familyScore = parseInt(document.getElementById('familyHistory').value);

                const gender = document.getElementById('gender').value;

                // Tính tổng điểm
                const totalScore = ageScore + bmiScore + waistScore + activityScore + dietScore + bpScore +
                    glucoseScore + familyScore;

                // Xác định mức độ nguy cơ
                let riskLevel, riskColor, riskPercent, riskMarkerPosition, recommendation;

                if (totalScore < 7) {
                    riskLevel = "Nguy cơ thấp";
                    riskColor = "bg-success";
                    riskPercent = "1% nguy cơ mắc tiểu đường";
                    riskMarkerPosition = 12.5; // Vị trí giữa mức "Thấp"
                    recommendation =
                        "Dựa vào kết quả đánh giá, bạn có nguy cơ thấp mắc bệnh tiểu đường type 2. Tuy nhiên, vẫn nên duy trì lối sống lành mạnh, chế độ ăn cân bằng và tập thể dục đều đặn để duy trì sức khỏe tốt.";
                } else if (totalScore < 12) {
                    riskLevel = "Nguy cơ nhẹ";
                    riskColor = "bg-info";
                    riskPercent = "4% nguy cơ mắc tiểu đường";
                    riskMarkerPosition = 37.5; // Vị trí giữa mức "Nhẹ"
                    recommendation =
                        "Kết quả cho thấy bạn có nguy cơ nhẹ mắc bệnh tiểu đường type 2. Đây là thời điểm tốt để xem xét các thay đổi nhỏ trong lối sống, bao gồm tăng cường hoạt động thể chất và cải thiện chế độ ăn uống. Nên tái kiểm tra nguy cơ mỗi 3-5 năm.";
                } else if (totalScore < 15) {
                    riskLevel = "Nguy cơ trung bình";
                    riskColor = "bg-warning";
                    riskPercent = "16.7% nguy cơ mắc tiểu đường";
                    riskMarkerPosition = 62.5; // Vị trí giữa mức "Trung bình"
                    recommendation =
                        "Bạn có nguy cơ trung bình mắc bệnh tiểu đường type 2. Nên tham khảo ý kiến bác sĩ về việc kiểm tra đường huyết định kỳ, và thực hiện các biện pháp để giảm nguy cơ như tăng cường vận động, cải thiện chế độ ăn và duy trì cân nặng hợp lý. Theo dõi đường huyết mỗi 1-3 năm.";
                } else {
                    riskLevel = "Nguy cơ cao";
                    riskColor = "bg-danger";
                    riskPercent = "33.3% nguy cơ mắc tiểu đường";
                    riskMarkerPosition = 87.5; // Vị trí giữa mức "Cao"
                    recommendation =
                        "Kết quả đánh giá cho thấy bạn có nguy cơ cao mắc bệnh tiểu đường type 2. Hãy đến gặp bác sĩ sớm để kiểm tra đường huyết, và cân nhắc các biện pháp can thiệp tích cực để giảm nguy cơ. Đây là lúc cần thay đổi lối sống đáng kể để bảo vệ sức khỏe. Nên kiểm tra đường huyết định kỳ mỗi 6-12 tháng.";
                }

                // Cập nhật giao diện
                document.getElementById('riskScore').textContent = totalScore;
                document.getElementById('riskLevel').textContent = riskLevel;
                document.getElementById('riskPercent').textContent = riskPercent;
                document.getElementById('riskLevelContainer').className =
                    `risk-level p-3 rounded text-white text-center ${riskColor}`;
                document.getElementById('riskMarker').style.left = `${riskMarkerPosition}%`;
                document.getElementById('riskRecommendation').querySelector('p').textContent =
                    recommendation;

                // Xác định các yếu tố nguy cơ
                const riskFactors = [];
                if (ageScore > 0) riskFactors.push("Tuổi trên 45");
                if (bmiScore > 0) riskFactors.push("Chỉ số BMI cao (thừa cân hoặc béo phì)");
                if (waistScore > 0) riskFactors.push("Chu vi vòng eo lớn");
                if (activityScore > 0) riskFactors.push("Thiếu hoạt động thể chất");
                if (dietScore > 0) riskFactors.push("Ít ăn rau củ quả");
                if (bpScore > 0) riskFactors.push("Huyết áp cao");
                if (glucoseScore > 0) riskFactors.push("Tiền sử đường huyết cao");
                if (familyScore > 0) riskFactors.push("Tiền sử gia đình mắc tiểu đường");

                // Hiển thị các yếu tố nguy cơ
                const riskFactorsList = document.getElementById('riskFactorsList');
                riskFactorsList.innerHTML = '';

                if (riskFactors.length === 0) {
                    const li = document.createElement('li');
                    li.textContent = "Không phát hiện yếu tố nguy cơ đáng kể.";
                    riskFactorsList.appendChild(li);
                } else {
                    riskFactors.forEach(factor => {
                        const li = document.createElement('li');
                        li.textContent = factor;
                        riskFactorsList.appendChild(li);
                    });
                }

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
