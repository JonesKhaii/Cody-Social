@extends('layouts.master')

@section('main-content')
    <div class="water-intake-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/tools">Công cụ sức khỏe</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Lượng nước cần uống</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Phần chính - Form nhập liệu -->
                <div class="col-lg-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-tint me-2"></i>Tính lượng nước cần uống</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-4">Nước vô cùng quan trọng cho sức khỏe, chiếm khoảng 60% trọng lượng cơ thể.
                                Công cụ này giúp bạn tính lượng nước cần uống hàng ngày dựa trên các đặc điểm cá nhân và
                                hoạt động thể chất.</p>

                            <form id="waterForm" class="mb-4">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="weight" class="form-label">Cân nặng (kg) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="weight" min="30"
                                            max="250" step="0.1" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="activity" class="form-label">Mức độ hoạt động <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="activity" required>
                                            <option value="sedentary">Ít vận động (chủ yếu ngồi)</option>
                                            <option value="light" selected>Vận động nhẹ (đi bộ, làm việc nhà)</option>
                                            <option value="moderate">Vận động vừa (tập 3-5 ngày/tuần)</option>
                                            <option value="active">Vận động nhiều (tập >5 ngày/tuần)</option>
                                            <option value="very-active">Vận động rất nhiều (vận động viên)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="climate" class="form-label">Khí hậu <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="climate" required>
                                            <option value="temperate" selected>Ôn hòa (20-25°C)</option>
                                            <option value="hot">Nóng (>25°C)</option>
                                            <option value="very-hot">Rất nóng (>30°C)</option>
                                            <option value="cold">Lạnh (<20°C)< /option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Yếu tố bổ sung</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="isPregnant">
                                            <label class="form-check-label" for="isPregnant">Mang thai/Cho con bú</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="isSick">
                                            <label class="form-check-label" for="isSick">Bị ốm (sốt, tiêu chảy)</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="highProtein">
                                            <label class="form-check-label" for="highProtein">Chế độ ăn giàu protein</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Tính lượng nước</button>
                                </div>
                            </form>

                            <!-- Kết quả sẽ hiển thị ở đây -->
                            <div id="waterResult" class="mt-4" style="display: none;">
                                <div class="result-container rounded border p-3">
                                    <h5 class="result-title mb-4">Lượng nước khuyến nghị hàng ngày</h5>

                                    <div class="water-result mb-4 text-center">
                                        <div class="d-flex justify-content-center align-items-end mb-3">
                                            <span id="waterLiters" class="display-3 fw-bold text-primary me-2">2.5</span>
                                            <span class="h3 mb-2">lít</span>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                            <span id="waterML" class="h5 me-2">2500 ml</span>
                                            <span id="waterOz" class="h5 text-muted">(84.5 oz)</span>
                                        </div>
                                        <div class="mt-2">
                                            <span id="waterGlasses" class="badge bg-info px-3 py-2">Khoảng 10-12 cốc
                                                nước</span>
                                        </div>
                                    </div>

                                    <div class="water-visualization mb-4">
                                        <div class="row justify-content-center" id="glassesContainer">
                                            <!-- Glasses will be added here by JavaScript -->
                                        </div>
                                    </div>

                                    <div class="water-explanation bg-light mb-4 rounded p-3">
                                        <h6><i class="fas fa-info-circle text-primary me-2"></i>Diễn giải kết quả</h6>
                                        <p id="waterExplanation" class="mb-0">Dựa trên cân nặng và mức độ hoạt động của
                                            bạn, bạn nên uống khoảng 2.5 lít nước mỗi ngày để duy trì sự cân bằng nước tối
                                            ưu cho cơ thể.</p>
                                    </div>

                                    <div class="water-distribution mb-3">
                                        <h6 class="mb-3">Phân bổ nước trong ngày</h6>
                                        <div class="row">
                                            <div class="col-md-3 mb-3">
                                                <div class="time-block rounded border p-2 text-center">
                                                    <h6>Sáng sớm</h6>
                                                    <div id="morningAmount" class="fw-bold">500ml</div>
                                                    <small class="text-muted">Sau khi thức dậy</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="time-block rounded border p-2 text-center">
                                                    <h6>Trước trưa</h6>
                                                    <div id="beforeNoonAmount" class="fw-bold">750ml</div>
                                                    <small class="text-muted">9h - 12h</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="time-block rounded border p-2 text-center">
                                                    <h6>Chiều</h6>
                                                    <div id="afternoonAmount" class="fw-bold">750ml</div>
                                                    <small class="text-muted">12h - 17h</small>
                                                </div>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <div class="time-block rounded border p-2 text-center">
                                                    <h6>Tối</h6>
                                                    <div id="eveningAmount" class="fw-bold">500ml</div>
                                                    <small class="text-muted">17h - 21h</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="waterRecommendation" class="water-recommendation bg-light rounded p-3">
                                        <h6><i class="fas fa-lightbulb text-warning me-2"></i>Lời khuyên</h6>
                                        <ul class="mb-0">
                                            <li>Bắt đầu ngày mới bằng 1-2 cốc nước sau khi thức dậy</li>
                                            <li>Uống 1 cốc nước trước mỗi bữa ăn</li>
                                            <li>Mang theo bình nước để dễ dàng uống nước thường xuyên</li>
                                            <li>Thêm lát chanh, trái cây hoặc lá bạc hà để tăng hương vị</li>
                                            <li>Đặt lịch nhắc nhở uống nước trên điện thoại</li>
                                        </ul>
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
                            <h5 class="mb-0">Tầm quan trọng của nước</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Nước và sức khỏe</h6>
                            <p>Nước chiếm 60% trọng lượng cơ thể và rất cần thiết cho:</p>
                            <ul>
                                <li>Điều hòa thân nhiệt</li>
                                <li>Vận chuyển chất dinh dưỡng và oxy</li>
                                <li>Thải độc tố qua nước tiểu</li>
                                <li>Bảo vệ các cơ quan và mô</li>
                                <li>Duy trì sự hoạt động của các khớp</li>
                                <li>Hỗ trợ tiêu hóa</li>
                            </ul>
                            <p>Thiếu nước dẫn đến mệt mỏi, đau đầu, khó tập trung, táo bón, và nhiều vấn đề sức khỏe khác.
                            </p>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Dấu hiệu cơ thể thiếu nước</h5>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li><strong>Nước tiểu sẫm màu:</strong> Màu vàng đậm hoặc hổ phách</li>
                                <li><strong>Khát nước:</strong> Cảm giác khô miệng và khát</li>
                                <li><strong>Mệt mỏi:</strong> Cảm thấy kiệt sức mà không có lý do rõ ràng</li>
                                <li><strong>Đau đầu:</strong> Đau đầu nhẹ hoặc đau nửa đầu</li>
                                <li><strong>Khô da:</strong> Da thiếu độ đàn hồi khi kéo nhẹ</li>
                                <li><strong>Táo bón:</strong> Khó đi vệ sinh</li>
                                <li><strong>Chóng mặt:</strong> Đặc biệt khi đứng lên nhanh</li>
                            </ul>
                            <p class="text-danger mb-0"><i class="fas fa-exclamation-circle me-1"></i> Lưu ý: Nhu cầu nước
                                có thể khác nhau tùy thuộc vào điều kiện sức khỏe cá nhân. Tham khảo ý kiến bác sĩ nếu bạn
                                có bất kỳ lo ngại nào.</p>
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
                                        <small class="text-muted">Xác định lượng calo cần thiết hàng ngày</small>
                                    </div>
                                </a>

                                <a href="/tools/macro-calculator"
                                    class="related-tool-item d-flex align-items-center mb-2 rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-chart-pie text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính Macros</div>
                                        <small class="text-muted">Phân bổ protein, carbs và chất béo</small>
                                    </div>
                                </a>

                                <a href="/tools/body-fat-calculator"
                                    class="related-tool-item d-flex align-items-center rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-percentage text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính tỷ lệ mỡ cơ thể</div>
                                        <small class="text-muted">Đánh giá tỷ lệ mỡ chính xác hơn BMI</small>
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
        /* Water glass styles */
        .glass {
            width: 30px;
            height: 40px;
            background-color: #e6f7ff;
            border: 2px solid #0d6efd;
            border-radius: 0 0 15px 15px;
            margin: 0 5px;
            position: relative;
            display: inline-block;
        }

        .glass::before {
            content: "";
            width: 30px;
            height: 10px;
            border: 2px solid #0d6efd;
            border-radius: 15px 15px 0 0;
            border-bottom: none;
            position: absolute;
            top: -10px;
            left: -2px;
        }

        /* Time blocks */
        .time-block {
            transition: transform 0.2s;
        }

        .time-block:hover {
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
            const waterForm = document.getElementById('waterForm');
            const resultDiv = document.getElementById('waterResult');

            waterForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Lấy giá trị input
                const weight = parseFloat(document.getElementById('weight').value);
                const activity = document.getElementById('activity').value;
                const climate = document.getElementById('climate').value;
                const isPregnant = document.getElementById('isPregnant').checked;
                const isSick = document.getElementById('isSick').checked;
                const highProtein = document.getElementById('highProtein').checked;

                // Tính lượng nước cơ bản (ml)
                // Công thức cơ bản: 30-35ml nước/kg cân nặng
                let baseWater = weight * 30;

                // Điều chỉnh theo mức độ hoạt động
                switch (activity) {
                    case 'sedentary':
                        baseWater = weight * 30; // 30ml/kg
                        break;
                    case 'light':
                        baseWater = weight * 33; // 33ml/kg
                        break;
                    case 'moderate':
                        baseWater = weight * 35; // 35ml/kg
                        break;
                    case 'active':
                        baseWater = weight * 40; // 40ml/kg
                        break;
                    case 'very-active':
                        baseWater = weight * 45; // 45ml/kg - vận động viên cần nhiều nước hơn
                        break;
                }

                // Điều chỉnh theo khí hậu
                switch (climate) {
                    case 'cold':
                        baseWater *= 0.95; // Giảm 5% khi lạnh
                        break;
                    case 'hot':
                        baseWater *= 1.1; // Tăng 10% khi nóng
                        break;
                    case 'very-hot':
                        baseWater *= 1.2; // Tăng 20% khi rất nóng
                        break;
                        // Trường hợp temperate (khí hậu ôn hòa) giữ nguyên
                }

                // Điều chỉnh theo các yếu tố khác
                if (isPregnant) {
                    baseWater += 300; // Thêm 300ml cho phụ nữ mang thai/cho con bú
                }
                if (isSick) {
                    baseWater += 500; // Thêm 500ml khi bị ốm (sốt, tiêu chảy)
                }
                if (highProtein) {
                    baseWater += 200; // Thêm 200ml cho chế độ ăn giàu protein
                }

                // Làm tròn kết quả
                const waterML = Math.round(baseWater / 100) * 100; // Làm tròn đến hàng trăm ml
                const waterLiters = Math.round(waterML / 100) / 10; // Chuyển sang lít và làm tròn 1 chữ số
                const waterOz = Math.round(waterML * 0.0338140227); // Chuyển sang oz
                const waterGlasses = Math.round(waterML / 250); // Số cốc nước (1 cốc ≈ 250ml)

                // Phân bổ nước trong ngày
                const morningAmount = Math.round(waterML * 0.2 / 50) * 50; // 20% vào buổi sáng
                const beforeNoonAmount = Math.round(waterML * 0.3 / 50) * 50; // 30% trước trưa
                const afternoonAmount = Math.round(waterML * 0.3 / 50) * 50; // 30% vào buổi chiều
                const eveningAmount = Math.round(waterML * 0.2 / 50) * 50; // 20% vào buổi tối

                // Chuẩn bị diễn giải
                let explanation;
                let additionalFactors = [];

                if (activity !== 'sedentary') additionalFactors.push(
                    `mức độ hoạt động ${activity === 'very-active' ? 'rất cao' : activity === 'active' ? 'cao' : activity === 'moderate' ? 'vừa phải' : 'nhẹ'}`
                );
                if (climate !== 'temperate') additionalFactors.push(
                    `khí hậu ${climate === 'very-hot' ? 'rất nóng' : climate === 'hot' ? 'nóng' : 'lạnh'}`
                );
                if (isPregnant) additionalFactors.push("tình trạng mang thai/cho con bú");
                if (isSick) additionalFactors.push("tình trạng sức khỏe (đang bị ốm)");
                if (highProtein) additionalFactors.push("chế độ ăn giàu protein");

                if (additionalFactors.length > 0) {
                    explanation =
                        `Dựa trên cân nặng ${weight}kg và ${additionalFactors.join(", ")} của bạn, bạn nên uống khoảng ${waterLiters} lít nước mỗi ngày để duy trì sự cân bằng nước tối ưu cho cơ thể.`;
                } else {
                    explanation =
                        `Dựa trên cân nặng ${weight}kg của bạn, bạn nên uống khoảng ${waterLiters} lít nước mỗi ngày để duy trì sự cân bằng nước tối ưu cho cơ thể.`;
                }

                // Cập nhật giao diện
                document.getElementById('waterLiters').textContent = waterLiters;
                document.getElementById('waterML').textContent = `${waterML.toLocaleString()} ml`;
                document.getElementById('waterOz').textContent = `(${waterOz.toLocaleString()} oz)`;
                document.getElementById('waterGlasses').textContent = `Khoảng ${waterGlasses} cốc nước`;
                document.getElementById('waterExplanation').textContent = explanation;

                // Cập nhật phân bổ
                document.getElementById('morningAmount').textContent =
                    `${morningAmount.toLocaleString()} ml`;
                document.getElementById('beforeNoonAmount').textContent =
                    `${beforeNoonAmount.toLocaleString()} ml`;
                document.getElementById('afternoonAmount').textContent =
                    `${afternoonAmount.toLocaleString()} ml`;
                document.getElementById('eveningAmount').textContent =
                    `${eveningAmount.toLocaleString()} ml`;

                // Hiển thị hình ảnh ly nước
                const glassesContainer = document.getElementById('glassesContainer');
                glassesContainer.innerHTML = '';

                // Hiển thị tối đa 20 ly để tránh quá nhiều
                const maxGlasses = Math.min(waterGlasses, 20);

                for (let i = 0; i < maxGlasses; i++) {
                    const glassDiv = document.createElement('div');
                    glassDiv.className = 'glass';
                    glassesContainer.appendChild(glassDiv);
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
