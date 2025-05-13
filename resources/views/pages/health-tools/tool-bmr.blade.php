@extends('layouts.master')

@section('main-content')
    <div class="bmr-calculator-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/tools">Công cụ sức khỏe</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tính BMR và TDEE</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Phần chính - Form nhập liệu -->
                <div class="col-lg-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-fire me-2"></i>Tính BMR và TDEE</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-4">BMR (Basal Metabolic Rate) là lượng calo cơ thể cần để duy trì các chức năng
                                cơ bản khi nghỉ ngơi. TDEE (Total Daily Energy Expenditure) là tổng lượng calo tiêu thụ hàng
                                ngày bao gồm cả hoạt động thể chất.</p>

                            <form id="bmrForm" class="mb-4">
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
                                        <input type="number" class="form-control" id="age" min="15"
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
                                    <div class="col-12">
                                        <label for="activity" class="form-label">Mức độ hoạt động hàng ngày <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="activity" required>
                                            <option value="1.2">Ít vận động (công việc văn phòng, hầu như không tập thể
                                                dục)</option>
                                            <option value="1.375">Vận động nhẹ (tập nhẹ 1-3 ngày/tuần)</option>
                                            <option value="1.55" selected>Vận động vừa (tập vừa 3-5 ngày/tuần)</option>
                                            <option value="1.725">Vận động nhiều (tập nặng 6-7 ngày/tuần)</option>
                                            <option value="1.9">Vận động rất nhiều (tập nặng và lao động thể chất hàng
                                                ngày)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="formula" class="form-label">Công thức tính</label>
                                        <select class="form-select" id="formula">
                                            <option value="mifflin" selected>Mifflin-St Jeor (khuyến nghị)</option>
                                            <option value="harris">Harris-Benedict (cổ điển)</option>
                                            <option value="katch">Katch-McArdle (cho người biết % mỡ cơ thể)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3" id="bodyFatRow" style="display: none;">
                                    <div class="col-md-6">
                                        <label for="bodyFat" class="form-label">Tỷ lệ mỡ cơ thể (%) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="bodyFat" min="3"
                                            max="50" step="0.1">
                                        <small class="text-muted">Chỉ cần nhập khi chọn công thức Katch-McArdle</small>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Tính BMR và TDEE</button>
                                </div>
                            </form>

                            <!-- Kết quả sẽ hiển thị ở đây -->
                            <div id="bmrResult" class="mt-4" style="display: none;">
                                <div class="result-container rounded border p-3">
                                    <h5 class="result-title mb-3">Kết quả tính toán</h5>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="bmr-value mb-3 text-center">
                                                <span id="bmrValue"
                                                    class="d-block display-4 fw-bold text-primary">0</span>
                                                <span class="text-muted">BMR (calo/ngày)</span>
                                                <small class="d-block mt-2">Lượng calo cơ bản cần thiết khi nghỉ ngơi hoàn
                                                    toàn</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="tdee-value mb-3 text-center">
                                                <span id="tdeeValue"
                                                    class="d-block display-4 fw-bold text-success">0</span>
                                                <span class="text-muted">TDEE (calo/ngày)</span>
                                                <small class="d-block mt-2">Tổng lượng calo tiêu thụ hàng ngày với hoạt
                                                    động</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="bmr-explanation bg-light mb-4 rounded p-3">
                                        <h6><i class="fas fa-info-circle text-primary me-2"></i>Diễn giải kết quả</h6>
                                        <p class="mb-0" id="bmrExplanation"></p>
                                    </div>

                                    <h6 class="mb-3">Mục tiêu dinh dưỡng hàng ngày</h6>
                                    <div class="row mb-2">
                                        <div class="col-md-4 mb-3">
                                            <div class="goal-card rounded border p-3 text-center">
                                                <h6 class="text-danger">Giảm cân</h6>
                                                <span id="cutValue" class="d-block h5 mb-0">0</span>
                                                <small class="text-muted">calo/ngày</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="goal-card rounded border p-3 text-center">
                                                <h6 class="text-primary">Duy trì cân</h6>
                                                <span id="maintainValue" class="d-block h5 mb-0">0</span>
                                                <small class="text-muted">calo/ngày</small>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="goal-card rounded border p-3 text-center">
                                                <h6 class="text-success">Tăng cân</h6>
                                                <span id="bulkValue" class="d-block h5 mb-0">0</span>
                                                <small class="text-muted">calo/ngày</small>
                                            </div>
                                        </div>
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
                            <h5 class="mb-0">Thông tin về BMR và TDEE</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">BMR là gì?</h6>
                            <p>BMR (Basal Metabolic Rate) là lượng calo tối thiểu cơ thể cần để duy trì các chức năng sống
                                cơ bản như hô hấp, tuần hoàn, điều hòa thân nhiệt, v.v. khi nghỉ ngơi hoàn toàn.</p>
                            <hr>
                            <h6 class="mb-2">TDEE là gì?</h6>
                            <p>TDEE (Total Daily Energy Expenditure) là tổng lượng calo cơ thể tiêu thụ trong một ngày, bao
                                gồm BMR và năng lượng cho mọi hoạt động thể chất.</p>
                            <hr>
                            <h6 class="mb-2">Các công thức tính</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>Mifflin-St Jeor:</strong> Công thức hiện đại và chính xác nhất cho hầu hết mọi
                                    người.
                                </li>
                                <li class="mb-2">
                                    <strong>Harris-Benedict:</strong> Công thức cổ điển, được sử dụng rộng rãi.
                                </li>
                                <li>
                                    <strong>Katch-McArdle:</strong> Công thức dựa trên khối lượng gân cơ, phù hợp với người
                                    có tỷ lệ mỡ thấp.
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Lưu ý</h5>
                        </div>
                        <div class="card-body">
                            <p>Kết quả tính toán chỉ là ước tính và có thể thay đổi tùy theo cá nhân. Một số yếu tố ảnh
                                hưởng:</p>
                            <ul>
                                <li>Tỷ lệ mỡ và cơ</li>
                                <li>Tuổi và hormone</li>
                                <li>Sức khỏe tổng thể</li>
                                <li>Di truyền</li>
                            </ul>
                            <p class="text-danger mb-0"><i class="fas fa-exclamation-circle me-1"></i> Công cụ này chỉ
                                mang tính tham khảo, không thay thế cho tư vấn dinh dưỡng chuyên nghiệp.</p>
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
                                        <small class="text-muted">Xác định lượng calo cần thiết cho mục tiêu cụ thể</small>
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
        /* Styles cho các thẻ kết quả */
        .goal-card {
            transition: transform 0.2s;
        }

        .goal-card:hover {
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
            const bmrForm = document.getElementById('bmrForm');
            const resultDiv = document.getElementById('bmrResult');
            const bodyFatRow = document.getElementById('bodyFatRow');
            const formula = document.getElementById('formula');

            // Hiển thị/ẩn trường nhập tỷ lệ mỡ
            formula.addEventListener('change', function() {
                if (this.value === 'katch') {
                    bodyFatRow.style.display = 'block';
                    document.getElementById('bodyFat').setAttribute('required', 'required');
                } else {
                    bodyFatRow.style.display = 'none';
                    document.getElementById('bodyFat').removeAttribute('required');
                }
            });

            bmrForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Lấy giá trị input
                const gender = document.getElementById('gender').value;
                const age = parseInt(document.getElementById('age').value);
                const weight = parseFloat(document.getElementById('weight').value);
                const height = parseFloat(document.getElementById('height').value);
                const activity = parseFloat(document.getElementById('activity').value);
                const formulaType = document.getElementById('formula').value;
                const bodyFat = parseFloat(document.getElementById('bodyFat').value || 0);

                // Tính BMR dựa trên công thức được chọn
                let bmr = 0;

                if (formulaType === 'mifflin') {
                    // Công thức Mifflin-St Jeor
                    if (gender === 'male') {
                        bmr = 10 * weight + 6.25 * height - 5 * age + 5;
                    } else {
                        bmr = 10 * weight + 6.25 * height - 5 * age - 161;
                    }
                } else if (formulaType === 'harris') {
                    // Công thức Harris-Benedict
                    if (gender === 'male') {
                        bmr = 13.397 * weight + 4.799 * height - 5.677 * age + 88.362;
                    } else {
                        bmr = 9.247 * weight + 3.098 * height - 4.330 * age + 447.593;
                    }
                } else if (formulaType === 'katch') {
                    // Công thức Katch-McArdle (cần tỷ lệ mỡ)
                    const leanBodyMass = weight * (1 - (bodyFat / 100));
                    bmr = 370 + (21.6 * leanBodyMass);
                }

                // Làm tròn BMR
                bmr = Math.round(bmr);

                // Tính TDEE
                const tdee = Math.round(bmr * activity);

                // Tính lượng calo cho các mục tiêu
                const cutCals = Math.round(tdee * 0.8); // Giảm 20% để giảm cân
                const maintainCals = tdee; // Duy trì
                const bulkCals = Math.round(tdee * 1.15); // Tăng 15% để tăng cơ

                // Hiển thị kết quả
                document.getElementById('bmrValue').textContent = bmr.toLocaleString();
                document.getElementById('tdeeValue').textContent = tdee.toLocaleString();
                document.getElementById('cutValue').textContent = cutCals.toLocaleString();
                document.getElementById('maintainValue').textContent = maintainCals.toLocaleString();
                document.getElementById('bulkValue').textContent = bulkCals.toLocaleString();

                // Diễn giải kết quả
                let explanation =
                    `BMR của bạn là ${bmr.toLocaleString()} calo/ngày, là lượng calo tối thiểu cơ thể cần để duy trì các chức năng sống cơ bản. Với mức độ hoạt động hiện tại, TDEE của bạn là ${tdee.toLocaleString()} calo/ngày. `;

                if (gender === 'male') {
                    if (bmr < 1500) {
                        explanation +=
                            "BMR của bạn thấp hơn mức trung bình của nam giới, có thể do cân nặng hoặc tuổi tác. ";
                    } else if (bmr > 2000) {
                        explanation +=
                            "BMR của bạn cao hơn mức trung bình của nam giới, có thể do khối lượng cơ bắp hoặc cân nặng. ";
                    } else {
                        explanation += "BMR của bạn nằm trong mức trung bình của nam giới. ";
                    }
                } else {
                    if (bmr < 1200) {
                        explanation +=
                            "BMR của bạn thấp hơn mức trung bình của nữ giới, có thể do cân nặng hoặc tuổi tác. ";
                    } else if (bmr > 1600) {
                        explanation +=
                            "BMR của bạn cao hơn mức trung bình của nữ giới, có thể do khối lượng cơ bắp hoặc cân nặng. ";
                    } else {
                        explanation += "BMR của bạn nằm trong mức trung bình của nữ giới. ";
                    }
                }

                explanation +=
                    "Để điều chỉnh cân nặng, hãy theo dõi lượng calo nạp vào theo mục tiêu được đề xuất.";

                document.getElementById('bmrExplanation').textContent = explanation;

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
