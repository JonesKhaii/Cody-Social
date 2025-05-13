@extends('layouts.master')

@section('main-content')
    <div class="bmi-calculator-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/tools">Công cụ sức khỏe</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tính chỉ số BMI</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Phần chính - Form nhập liệu -->
                <div class="col-lg-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-calculator me-2"></i>Tính chỉ số BMI</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-4">Chỉ số khối cơ thể (BMI) là chỉ số đánh giá mức độ gầy hay béo dựa trên cân
                                nặng và chiều cao. Nhập thông tin của bạn bên dưới để tính BMI.</p>

                            <form id="bmiForm" class="mb-4">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="weight" class="form-label">Cân nặng (kg) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="weight" min="1"
                                            max="300" step="0.1" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="height" class="form-label">Chiều cao (cm) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="height" min="50"
                                            max="250" step="0.1" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Giới tính</label>
                                        <select class="form-select" id="gender">
                                            <option value="male">Nam</option>
                                            <option value="female">Nữ</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="age" class="form-label">Tuổi</label>
                                        <input type="number" class="form-control" id="age" min="2"
                                            max="120">
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Tính BMI</button>
                                </div>
                            </form>

                            <!-- Kết quả sẽ hiển thị ở đây -->
                            <div id="bmiResult" class="mt-4" style="display: none;">
                                <div class="result-container rounded border p-3">
                                    <h5 class="result-title mb-3">Kết quả tính BMI</h5>

                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-6">
                                            <div class="bmi-value text-center">
                                                <span id="bmiValue"
                                                    class="d-block display-4 fw-bold text-primary">0.0</span>
                                                <span class="text-muted">Chỉ số BMI của bạn</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="bmi-category rounded p-3 text-center">
                                                <span id="bmiCategory" class="d-block h5 mb-2">Bình thường</span>
                                                <span id="bmiMessage" class="text-muted">Chỉ số BMI của bạn nằm trong ngưỡng
                                                    bình thường.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Thang đo BMI -->
                                    <div class="bmi-scale mb-4">
                                        <div class="bmi-scale-container">
                                            <div class="bmi-scale-bars d-flex">
                                                <div class="bmi-bar bg-danger" style="flex: 1;">
                                                    <span class="bmi-label">Suy dinh dưỡng</span>
                                                    <span class="bmi-range">&lt;18.5</span>
                                                </div>
                                                <div class="bmi-bar bg-success" style="flex: 1;">
                                                    <span class="bmi-label">Bình thường</span>
                                                    <span class="bmi-range">18.5-24.9</span>
                                                </div>
                                                <div class="bmi-bar bg-warning" style="flex: 1;">
                                                    <span class="bmi-label">Thừa cân</span>
                                                    <span class="bmi-range">25-29.9</span>
                                                </div>
                                                <div class="bmi-bar bg-danger" style="flex: 1;">
                                                    <span class="bmi-label">Béo phì</span>
                                                    <span class="bmi-range">&gt;30</span>
                                                </div>
                                            </div>
                                            <div id="bmiMarker" class="bmi-marker" style="left: 30%;">
                                                <i class="fas fa-caret-down"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="bmiRecommendation" class="bmi-recommendation bg-light rounded p-3">
                                        <h6><i class="fas fa-lightbulb text-warning me-2"></i>Gợi ý</h6>
                                        <p class="mb-0">Dựa trên chỉ số BMI của bạn, việc duy trì cân nặng hiện tại là
                                            phù hợp. Tiếp tục duy trì chế độ ăn uống cân bằng và tập thể dục đều đặn.</p>
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
                            <h5 class="mb-0">Thông tin về chỉ số BMI</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Cách tính BMI</h6>
                            <p>BMI được tính bằng công thức: Cân nặng (kg) ÷ [Chiều cao (m)]²</p>
                            <hr>
                            <h6 class="mb-2">Phân loại BMI (WHO)</h6>
                            <ul class="bmi-categories list-unstyled">
                                <li class="d-flex justify-content-between border-bottom py-2">
                                    <span>Suy dinh dưỡng</span>
                                    <span class="fw-bold text-danger">&lt; 18.5</span>
                                </li>
                                <li class="d-flex justify-content-between border-bottom py-2">
                                    <span>Bình thường</span>
                                    <span class="fw-bold text-success">18.5 - 24.9</span>
                                </li>
                                <li class="d-flex justify-content-between border-bottom py-2">
                                    <span>Thừa cân</span>
                                    <span class="fw-bold text-warning">25.0 - 29.9</span>
                                </li>
                                <li class="d-flex justify-content-between border-bottom py-2">
                                    <span>Béo phì độ I</span>
                                    <span class="fw-bold text-danger">30.0 - 34.9</span>
                                </li>
                                <li class="d-flex justify-content-between border-bottom py-2">
                                    <span>Béo phì độ II</span>
                                    <span class="fw-bold text-danger">35.0 - 39.9</span>
                                </li>
                                <li class="d-flex justify-content-between py-2">
                                    <span>Béo phì độ III</span>
                                    <span class="fw-bold text-danger">&gt; 40.0</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Lưu ý về chỉ số BMI</h5>
                        </div>
                        <div class="card-body">
                            <p>BMI chỉ là một trong nhiều chỉ số đánh giá sức khỏe. Nó không phân biệt giữa mỡ và cơ, do đó
                                có thể không chính xác cho:</p>
                            <ul>
                                <li>Vận động viên và người có nhiều cơ bắp</li>
                                <li>Người cao tuổi</li>
                                <li>Phụ nữ mang thai hoặc cho con bú</li>
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
                                <a href="/tools/body-fat-calculator"
                                    class="related-tool-item d-flex align-items-center mb-2 rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-percentage text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính tỷ lệ mỡ cơ thể</div>
                                        <small class="text-muted">Đánh giá tỷ lệ mỡ chính xác hơn BMI</small>
                                    </div>
                                </a>

                                <a href="/tools/calorie-needs"
                                    class="related-tool-item d-flex align-items-center mb-2 rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-utensils text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính nhu cầu calo</div>
                                        <small class="text-muted">Xác định lượng calo cần thiết hàng ngày</small>
                                    </div>
                                </a>

                                <a href="/tools/bmr-calculator"
                                    class="related-tool-item d-flex align-items-center rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-fire text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính BMR và TDEE</div>
                                        <small class="text-muted">Tỷ lệ trao đổi chất cơ bản</small>
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
        /* Styles cho thang đo BMI */
        .bmi-scale-container {
            position: relative;
            padding-top: 10px;
            padding-bottom: 30px;
        }

        .bmi-scale-bars {
            height: 30px;
            border-radius: 5px;
            overflow: hidden;
        }

        .bmi-bar {
            position: relative;
            height: 100%;
            text-align: center;
        }

        .bmi-label {
            position: absolute;
            top: 5px;
            left: 0;
            right: 0;
            font-size: 11px;
            color: white;
            font-weight: bold;
        }

        .bmi-range {
            position: absolute;
            bottom: -25px;
            left: 0;
            right: 0;
            font-size: 11px;
            color: #666;
        }

        .bmi-marker {
            position: absolute;
            top: 0;
            transform: translateX(-50%);
            color: #333;
            font-size: 20px;
            transition: left 0.5s ease;
        }

        /* Styles cho category */
        .bmi-category {
            background-color: #f8f9fa;
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
            background-color: #1565C0 !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bmiForm = document.getElementById('bmiForm');
            const resultDiv = document.getElementById('bmiResult');
            const bmiValueEl = document.getElementById('bmiValue');
            const bmiCategoryEl = document.getElementById('bmiCategory');
            const bmiMessageEl = document.getElementById('bmiMessage');
            const bmiMarkerEl = document.getElementById('bmiMarker');
            const bmiRecommendationEl = document.getElementById('bmiRecommendation');

            bmiForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Lấy các giá trị nhập vào
                const weight = parseFloat(document.getElementById('weight').value);
                const height = parseFloat(document.getElementById('height').value) / 100; // Convert cm to m
                const gender = document.getElementById('gender').value;
                const age = parseInt(document.getElementById('age').value) ||
                    25; // Default to 25 if not provided

                // Tính BMI
                const bmi = weight / (height * height);

                // Hiển thị kết quả
                bmiValueEl.textContent = bmi.toFixed(1);

                // Xác định phân loại và hiển thị
                let category, message, color, position, recommendation;

                if (bmi < 18.5) {
                    category = "Suy dinh dưỡng";
                    message = "Chỉ số BMI của bạn thấp hơn mức khuyến nghị.";
                    color = "#dc3545"; // danger
                    position = (bmi / 40) * 100; // Đặt vị trí marker
                    recommendation =
                        "Bạn nên tăng cân một cách khoa học thông qua chế độ ăn giàu dinh dưỡng và đủ calo. Tham khảo ý kiến bác sĩ hoặc chuyên gia dinh dưỡng để được tư vấn cụ thể.";
                } else if (bmi < 25) {
                    category = "Bình thường";
                    message = "Chỉ số BMI của bạn nằm trong ngưỡng bình thường.";
                    color = "#28a745"; // success
                    position = 25 + ((bmi - 18.5) / 6.5) * 25; // Đặt vị trí marker
                    recommendation =
                        "Duy trì cân nặng hiện tại là phù hợp. Tiếp tục duy trì chế độ ăn uống cân bằng và tập thể dục đều đặn.";
                } else if (bmi < 30) {
                    category = "Thừa cân";
                    message = "Chỉ số BMI của bạn cao hơn mức bình thường, bạn đang thừa cân.";
                    color = "#ffc107"; // warning
                    position = 50 + ((bmi - 25) / 5) * 25; // Đặt vị trí marker
                    recommendation =
                        "Bạn nên giảm cân từ từ thông qua việc tăng cường hoạt động thể chất và điều chỉnh chế độ ăn. Nên giảm khoảng 5-10% cân nặng trong vòng 6 tháng.";
                } else {
                    category = "Béo phì";
                    message = "Chỉ số BMI của bạn cho thấy bạn đang ở mức béo phì.";
                    color = "#dc3545"; // danger
                    position = 75 + ((bmi - 30) / 10) * 25; // Đặt vị trí marker (giới hạn ở 100%)
                    position = Math.min(position, 98); // Không để vượt quá 100%
                    recommendation =
                        "Bạn nên tham khảo ý kiến bác sĩ để được tư vấn về kế hoạch giảm cân phù hợp. Giảm cân từ từ thông qua chế độ ăn lành mạnh và tập luyện thường xuyên sẽ mang lại hiệu quả tốt nhất.";
                }

                // Cập nhật giao diện
                bmiCategoryEl.textContent = category;
                bmiMessageEl.textContent = message;
                bmiCategoryEl.style.color = color;
                bmiMarkerEl.style.left = `${position}%`;
                bmiRecommendationEl.querySelector('p').textContent = recommendation;

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
