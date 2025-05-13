@extends('layouts.master')

@section('main-content')
    <div class="body-fat-calculator-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/tools">Công cụ sức khỏe</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tính tỷ lệ mỡ cơ thể</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Phần chính - Form nhập liệu -->
                <div class="col-lg-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-percentage me-2"></i>Tính tỷ lệ mỡ cơ thể</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-4">Tỷ lệ mỡ cơ thể (Body Fat Percentage) là chỉ số đánh giá tỷ lệ mỡ so với tổng
                                trọng lượng cơ thể. Đây là chỉ số đánh giá sức khỏe và thể chất chính xác hơn so với BMI.
                            </p>

                            <form id="bodyFatForm" class="mb-4">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="gender" class="form-label">Giới tính <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="gender" required>
                                            <option value="male">Nam</option>
                                            <option value="female">Nữ</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="age" class="form-label">Tuổi <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="age" min="18"
                                            max="100" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="weight" class="form-label">Cân nặng (kg) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="weight" min="30"
                                            max="250" step="0.1" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="height" class="form-label">Chiều cao (cm) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="height" min="100"
                                            max="250" step="0.1" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="neck" class="form-label">Chu vi cổ (cm) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="neck" min="20"
                                            max="80" step="0.1" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="waist" class="form-label">Chu vi eo (cm) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="waist" min="50"
                                            max="200" step="0.1" required>
                                    </div>
                                </div>

                                <div class="row mb-3" id="hipRow">
                                    <div class="col-md-6">
                                        <label for="hip" class="form-label">Chu vi hông (cm) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="hip" min="50"
                                            max="200" step="0.1" required>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Tính tỷ lệ mỡ</button>
                                </div>
                            </form>

                            <!-- Kết quả sẽ hiển thị ở đây -->
                            <div id="bodyFatResult" class="mt-4" style="display: none;">
                                <div class="result-container rounded border p-3">
                                    <h5 class="result-title mb-3">Kết quả tính tỷ lệ mỡ cơ thể</h5>

                                    <div class="row align-items-center mb-3">
                                        <div class="col-md-6">
                                            <div class="body-fat-value text-center">
                                                <span id="bodyFatValue"
                                                    class="d-block display-4 fw-bold text-primary">0.0%</span>
                                                <span class="text-muted">Tỷ lệ mỡ cơ thể của bạn</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="body-fat-category rounded p-3 text-center">
                                                <span id="bodyFatCategory" class="d-block h5 mb-2">Bình thường</span>
                                                <span id="bodyFatMessage" class="text-muted">Tỷ lệ mỡ của bạn nằm trong
                                                    ngưỡng bình thường.</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Thang đo tỷ lệ mỡ -->
                                    <div class="body-fat-scale mb-4">
                                        <div class="body-fat-scale-container">
                                            <div class="body-fat-scale-bars d-flex">
                                                <div class="body-fat-bar bg-success" style="flex: 1;">
                                                    <span class="body-fat-label">Cần thiết</span>
                                                    <span class="body-fat-range" id="essential-range">2-5%</span>
                                                </div>
                                                <div class="body-fat-bar bg-success" style="flex: 1;">
                                                    <span class="body-fat-label">Thể thao</span>
                                                    <span class="body-fat-range" id="athlete-range">6-13%</span>
                                                </div>
                                                <div class="body-fat-bar bg-success" style="flex: 1;">
                                                    <span class="body-fat-label">Tốt</span>
                                                    <span class="body-fat-range" id="fit-range">14-17%</span>
                                                </div>
                                                <div class="body-fat-bar bg-warning" style="flex: 1;">
                                                    <span class="body-fat-label">Trung bình</span>
                                                    <span class="body-fat-range" id="average-range">18-24%</span>
                                                </div>
                                                <div class="body-fat-bar bg-danger" style="flex: 1;">
                                                    <span class="body-fat-label">Béo</span>
                                                    <span class="body-fat-range" id="obese-range">>25%</span>
                                                </div>
                                            </div>
                                            <div id="bodyFatMarker" class="body-fat-marker" style="left: 30%;">
                                                <i class="fas fa-caret-down"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="bodyFatRecommendation" class="body-fat-recommendation bg-light rounded p-3">
                                        <h6><i class="fas fa-lightbulb text-warning me-2"></i>Gợi ý</h6>
                                        <p class="mb-0">Dựa trên tỷ lệ mỡ cơ thể của bạn, bạn cần duy trì chế độ ăn uống
                                            cân bằng và tập thể dục đều đặn để duy trì tỷ lệ mỡ ở mức lý tưởng.</p>
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
                            <h5 class="mb-0">Thông tin về tỷ lệ mỡ cơ thể</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Công thức tính tỷ lệ mỡ</h6>
                            <p>Chúng tôi sử dụng công thức U.S. Navy để tính tỷ lệ mỡ cơ thể.</p>
                            <hr>
                            <h6 class="mb-2">Phân loại tỷ lệ mỡ</h6>
                            <div class="mt-3">
                                <h6 class="small fw-bold">Nam giới:</h6>
                                <ul class="body-fat-categories list-unstyled">
                                    <li class="d-flex justify-content-between border-bottom py-2">
                                        <span>Cần thiết</span>
                                        <span class="fw-bold text-success">2-5%</span>
                                    </li>
                                    <li class="d-flex justify-content-between border-bottom py-2">
                                        <span>Thể thao</span>
                                        <span class="fw-bold text-success">6-13%</span>
                                    </li>
                                    <li class="d-flex justify-content-between border-bottom py-2">
                                        <span>Tốt</span>
                                        <span class="fw-bold text-success">14-17%</span>
                                    </li>
                                    <li class="d-flex justify-content-between border-bottom py-2">
                                        <span>Trung bình</span>
                                        <span class="fw-bold text-warning">18-24%</span>
                                    </li>
                                    <li class="d-flex justify-content-between py-2">
                                        <span>Béo</span>
                                        <span class="fw-bold text-danger">25%+</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="mt-3">
                                <h6 class="small fw-bold">Nữ giới:</h6>
                                <ul class="body-fat-categories list-unstyled">
                                    <li class="d-flex justify-content-between border-bottom py-2">
                                        <span>Cần thiết</span>
                                        <span class="fw-bold text-success">10-13%</span>
                                    </li>
                                    <li class="d-flex justify-content-between border-bottom py-2">
                                        <span>Thể thao</span>
                                        <span class="fw-bold text-success">14-20%</span>
                                    </li>
                                    <li class="d-flex justify-content-between border-bottom py-2">
                                        <span>Tốt</span>
                                        <span class="fw-bold text-success">21-24%</span>
                                    </li>
                                    <li class="d-flex justify-content-between border-bottom py-2">
                                        <span>Trung bình</span>
                                        <span class="fw-bold text-warning">25-31%</span>
                                    </li>
                                    <li class="d-flex justify-content-between py-2">
                                        <span>Béo</span>
                                        <span class="fw-bold text-danger">32%+</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Lưu ý</h5>
                        </div>
                        <div class="card-body">
                            <p>Công thức U.S. Navy cung cấp ước tính tỷ lệ mỡ cơ thể với độ chính xác khoảng 3-4%. Để có kết
                                quả chính xác hơn, bạn nên:</p>
                            <ul>
                                <li>Đo các số đo chính xác, ở cùng vị trí mỗi lần</li>
                                <li>Đo chu vi eo ở rốn khi thở ra bình thường</li>
                                <li>Đo chu vi cổ ngay dưới thanh quản (hầu)</li>
                                <li>Đo chu vi hông ở phần rộng nhất</li>
                            </ul>
                            <p class="text-danger mb-0"><i class="fas fa-exclamation-circle me-1"></i> Công cụ này chỉ
                                mang tính tham khảo, không thay thế cho các phương pháp đo chuyên nghiệp.</p>
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
                                        <small class="text-muted">Đánh giá cân nặng theo chiều cao</small>
                                    </div>
                                </a>

                                <a href="/tools/bmr-calculator"
                                    class="related-tool-item d-flex align-items-center mb-2 rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-fire text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính BMR và TDEE</div>
                                        <small class="text-muted">Tỷ lệ trao đổi chất cơ bản</small>
                                    </div>
                                </a>

                                <a href="/tools/macro-calculator"
                                    class="related-tool-item d-flex align-items-center rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-chart-pie text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính Macros</div>
                                        <small class="text-muted">Phân bổ protein, carbs và chất béo</small>
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
        /* Styles cho thang đo body fat */
        .body-fat-scale-container {
            position: relative;
            padding-top: 10px;
            padding-bottom: 30px;
        }

        .body-fat-scale-bars {
            height: 30px;
            border-radius: 5px;
            overflow: hidden;
        }

        .body-fat-bar {
            position: relative;
            height: 100%;
            text-align: center;
        }

        .body-fat-label {
            position: absolute;
            top: 5px;
            left: 0;
            right: 0;
            font-size: 11px;
            color: white;
            font-weight: bold;
        }

        .body-fat-range {
            position: absolute;
            bottom: -25px;
            left: 0;
            right: 0;
            font-size: 11px;
            color: #666;
        }

        .body-fat-marker {
            position: absolute;
            top: 0;
            transform: translateX(-50%);
            color: #333;
            font-size: 20px;
            transition: left 0.5s ease;
        }

        /* Styles cho category */
        .body-fat-category {
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
            background-color: #1565c0 !important;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bodyFatForm = document.getElementById('bodyFatForm');
            const resultDiv = document.getElementById('bodyFatResult');
            const hipRow = document.getElementById('hipRow');
            const gender = document.getElementById('gender');

            // Hiển thị/ẩn trường hip dựa trên giới tính
            gender.addEventListener('change', function() {
                if (this.value === 'male') {
                    hipRow.style.display = 'none';
                    document.getElementById('hip').removeAttribute('required');

                    // Cập nhật thang đo cho nam
                    document.getElementById('essential-range').textContent = '2-5%';
                    document.getElementById('athlete-range').textContent = '6-13%';
                    document.getElementById('fit-range').textContent = '14-17%';
                    document.getElementById('average-range').textContent = '18-24%';
                    document.getElementById('obese-range').textContent = '>25%';
                } else {
                    hipRow.style.display = 'block';
                    document.getElementById('hip').setAttribute('required', 'required');

                    // Cập nhật thang đo cho nữ
                    document.getElementById('essential-range').textContent = '10-13%';
                    document.getElementById('athlete-range').textContent = '14-20%';
                    document.getElementById('fit-range').textContent = '21-24%';
                    document.getElementById('average-range').textContent = '25-31%';
                    document.getElementById('obese-range').textContent = '>32%';
                }
            });

            // Gọi sự kiện change lần đầu để cài đặt ban đầu
            gender.dispatchEvent(new Event('change'));

            bodyFatForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Lấy giá trị input
                const gender = document.getElementById('gender').value;
                const age = parseInt(document.getElementById('age').value);
                const weight = parseFloat(document.getElementById('weight').value);
                const height = parseFloat(document.getElementById('height').value);
                const neck = parseFloat(document.getElementById('neck').value);
                const waist = parseFloat(document.getElementById('waist').value);
                const hip = gender === 'female' ? parseFloat(document.getElementById('hip').value) : 0;

                // Tính tỷ lệ mỡ theo công thức U.S. Navy
                let bodyFat;

                if (gender === 'male') {
                    bodyFat = 495 / (1.0324 - 0.19077 * Math.log10(waist - neck) + 0.15456 * Math.log10(
                        height)) - 450;
                } else {
                    bodyFat = 495 / (1.29579 - 0.35004 * Math.log10(waist + hip - neck) + 0.22100 * Math
                        .log10(height)) - 450;
                }

                // Giới hạn kết quả
                bodyFat = Math.max(2, Math.min(bodyFat, 50));

                // Hiển thị kết quả
                document.getElementById('bodyFatValue').textContent = bodyFat.toFixed(1) + '%';

                // Phân loại và hiển thị
                let category, message, color, position, recommendation;

                if (gender === 'male') {
                    if (bodyFat < 6) {
                        category = "Cần thiết";
                        message = "Tỷ lệ mỡ của bạn ở mức cần thiết cho cơ thể.";
                        color = "#28a745"; // success
                        position = (bodyFat / 40) * 100;
                        recommendation =
                            "Đây là mức mỡ rất thấp, thường chỉ thấy ở vận động viên chuyên nghiệp. Cần đảm bảo đủ dinh dưỡng và năng lượng.";
                    } else if (bodyFat < 14) {
                        category = "Thể thao";
                        message = "Tỷ lệ mỡ của bạn ở mức thể thao, rất tốt.";
                        color = "#28a745"; // success
                        position = 12.5 + ((bodyFat - 6) / 8) * 25;
                        recommendation =
                            "Tuyệt vời! Tỷ lệ mỡ này cho thấy bạn có chế độ tập luyện và ăn uống tốt. Duy trì lối sống hiện tại.";
                    } else if (bodyFat < 18) {
                        category = "Tốt";
                        message = "Tỷ lệ mỡ của bạn ở mức tốt cho sức khỏe.";
                        color = "#28a745"; // success
                        position = 37.5 + ((bodyFat - 14) / 4) * 25;
                        recommendation =
                            "Tỷ lệ mỡ rất lành mạnh. Duy trì chế độ ăn uống cân bằng và tập luyện đều đặn.";
                    } else if (bodyFat < 25) {
                        category = "Trung bình";
                        message = "Tỷ lệ mỡ của bạn ở mức trung bình.";
                        color = "#ffc107"; // warning
                        position = 62.5 + ((bodyFat - 18) / 7) * 25;
                        recommendation =
                            "Tỷ lệ mỡ của bạn nằm trong mức trung bình nhưng có thể cải thiện. Tăng cường vận động và điều chỉnh chế độ ăn để giảm mỡ thừa.";
                    } else {
                        category = "Béo";
                        message = "Tỷ lệ mỡ của bạn cao hơn mức khuyến nghị.";
                        color = "#dc3545"; // danger
                        position = 87.5 + ((bodyFat - 25) / 25) * 12.5;
                        position = Math.min(position, 98);
                        recommendation =
                            "Bạn nên giảm tỷ lệ mỡ để cải thiện sức khỏe. Tham khảo ý kiến chuyên gia dinh dưỡng và lập kế hoạch tập luyện phù hợp.";
                    }
                } else { // Female
                    if (bodyFat < 14) {
                        category = "Cần thiết";
                        message = "Tỷ lệ mỡ của bạn ở mức cần thiết cho cơ thể.";
                        color = "#28a745"; // success
                        position = (bodyFat / 40) * 100;
                        recommendation =
                            "Đây là mức mỡ rất thấp đối với phụ nữ. Cần đảm bảo đủ dinh dưỡng cho sức khỏe sinh sản và tổng thể.";
                    } else if (bodyFat < 21) {
                        category = "Thể thao";
                        message = "Tỷ lệ mỡ của bạn ở mức thể thao, rất tốt.";
                        color = "#28a745"; // success
                        position = 12.5 + ((bodyFat - 14) / 7) * 25;
                        recommendation =
                            "Tuyệt vời! Tỷ lệ mỡ này cho thấy bạn có chế độ tập luyện và ăn uống tốt. Duy trì lối sống hiện tại.";
                    } else if (bodyFat < 25) {
                        category = "Tốt";
                        message = "Tỷ lệ mỡ của bạn ở mức tốt cho sức khỏe.";
                        color = "#28a745"; // success
                        position = 37.5 + ((bodyFat - 21) / 4) * 25;
                        recommendation =
                            "Tỷ lệ mỡ rất lành mạnh. Duy trì chế độ ăn uống cân bằng và tập luyện đều đặn.";
                    } else if (bodyFat < 32) {
                        category = "Trung bình";
                        message = "Tỷ lệ mỡ của bạn ở mức trung bình.";
                        color = "#ffc107"; // warning
                        position = 62.5 + ((bodyFat - 25) / 7) * 25;
                        recommendation =
                            "Tỷ lệ mỡ của bạn nằm trong mức trung bình nhưng có thể cải thiện. Tăng cường vận động và điều chỉnh chế độ ăn.";
                    } else {
                        category = "Béo";
                        message = "Tỷ lệ mỡ của bạn cao hơn mức khuyến nghị.";
                        color = "#dc3545"; // danger
                        position = 87.5 + ((bodyFat - 32) / 18) * 12.5;
                        position = Math.min(position, 98);
                        recommendation =
                            "Bạn nên giảm tỷ lệ mỡ để cải thiện sức khỏe. Tham khảo ý kiến chuyên gia dinh dưỡng và lập kế hoạch tập luyện phù hợp.";
                    }
                }

                // Cập nhật giao diện
                document.getElementById('bodyFatCategory').textContent = category;
                document.getElementById('bodyFatMessage').textContent = message;
                document.getElementById('bodyFatCategory').style.color = color;
                document.getElementById('bodyFatMarker').style.left = `${position}%`;
                document.getElementById('bodyFatRecommendation').querySelector('p').textContent =
                    recommendation;

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
