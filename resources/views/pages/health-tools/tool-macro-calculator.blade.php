@extends('layouts.master')

@section('main-content')
    <div class="macro-calculator-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/tools">Công cụ sức khỏe</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tính Macros</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Phần chính - Form nhập liệu -->
                <div class="col-lg-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Tính Macros (Phân bổ dinh dưỡng đa
                                lượng)</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-4">Macros (macronutrients) là các chất dinh dưỡng đa lượng gồm protein,
                                carbohydrate và chất béo. Phân bổ macros đúng cách là chìa khóa để đạt được mục tiêu thể
                                hình và sức khỏe tối ưu.</p>

                            <form id="macroForm" class="mb-4">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="gender" class="form-label">Giới tính <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="gender" required>
                                            <option value="male">Nam</option>
                                            <option value="female">Nữ</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="age" class="form-label">Tuổi <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="age" min="15"
                                            max="100" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="bodyFat" class="form-label">Tỷ lệ mỡ (%) <small class="text-muted">(nếu
                                                biết)</small></label>
                                        <input type="number" class="form-control" id="bodyFat" min="3"
                                            max="50" step="0.1">
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
                                        <label for="activity" class="form-label">Mức độ hoạt động <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="activity" required>
                                            <option value="1.2">Ít vận động (văn phòng, hầu như không tập)</option>
                                            <option value="1.375" selected>Vận động nhẹ (tập nhẹ 1-3 ngày/tuần)</option>
                                            <option value="1.55">Vận động vừa (tập vừa 3-5 ngày/tuần)</option>
                                            <option value="1.725">Vận động nhiều (tập nặng 6-7 ngày/tuần)</option>
                                            <option value="1.9">Vận động rất nhiều (tập nặng và lao động thể chất)
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="goal" class="form-label">Mục tiêu <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="goal" required>
                                            <option value="lose-fat">Giảm mỡ</option>
                                            <option value="maintain" selected>Duy trì cân nặng</option>
                                            <option value="gain-muscle">Tăng cơ</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="dietType" class="form-label">Loại chế độ ăn</label>
                                        <select class="form-select" id="dietType">
                                            <option value="balanced" selected>Cân bằng (40% carb, 30% protein, 30% fat)
                                            </option>
                                            <option value="high-protein">Giàu protein (30% carb, 40% protein, 30% fat)
                                            </option>
                                            <option value="low-carb">Ít carb (20% carb, 40% protein, 40% fat)</option>
                                            <option value="keto">Keto (5% carb, 30% protein, 65% fat)</option>
                                            <option value="custom">Tùy chỉnh (tự điều chỉnh %)</option>
                                        </select>
                                    </div>
                                </div>

                                <div id="customMacros" class="row mb-3" style="display: none;">
                                    <div class="col-md-4">
                                        <label for="customCarbs" class="form-label">Carbs (%)</label>
                                        <input type="number" class="form-control" id="customCarbs" min="5"
                                            max="70" value="40">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="customProtein" class="form-label">Protein (%)</label>
                                        <input type="number" class="form-control" id="customProtein" min="10"
                                            max="60" value="30">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="customFat" class="form-label">Chất béo (%)</label>
                                        <input type="number" class="form-control" id="customFat" min="10"
                                            max="80" value="30">
                                        <div id="macroTotalWarning" class="text-danger small mt-1"
                                            style="display: none;">Tổng tỷ lệ phải bằng 100%</div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Tính Macros</button>
                                </div>
                            </form>

                            <!-- Kết quả sẽ hiển thị ở đây -->
                            <div id="macroResult" class="mt-4" style="display: none;">
                                <div class="result-container rounded border p-3">
                                    <h5 class="result-title mb-3">Kết quả tính Macros</h5>

                                    <div class="calorie-summary mb-4">
                                        <div class="row align-items-center">
                                            <div class="col-md-6">
                                                <div class="total-calories text-center">
                                                    <span id="totalCalories"
                                                        class="d-block display-4 fw-bold text-primary">2000</span>
                                                    <span class="text-muted">Calo mỗi ngày</span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="diet-details bg-light rounded p-3">
                                                    <div class="d-flex justify-content-between">
                                                        <span>BMR:</span>
                                                        <span id="bmrValue" class="fw-bold">1500 calo</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span>TDEE:</span>
                                                        <span id="tdeeValue" class="fw-bold">2000 calo</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Mục tiêu:</span>
                                                        <span id="goalDescription" class="fw-bold">Duy trì</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between">
                                                        <span>Kiểu ăn:</span>
                                                        <span id="dietTypeDescription" class="fw-bold">Cân bằng</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <h6 class="mb-3">Phân bổ Macros hàng ngày</h6>
                                    <div class="macro-distribution mb-4">
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <div class="macro-card rounded border p-3 text-center">
                                                    <h6 class="text-primary">Carbohydrates</h6>
                                                    <span id="carbsGrams" class="d-block h5 mb-1">200g</span>
                                                    <span id="carbsCalories" class="d-block small">800 calo</span>
                                                    <span id="carbsPercent"
                                                        class="badge bg-primary mt-1 px-2 py-1">40%</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="macro-card rounded border p-3 text-center">
                                                    <h6 class="text-danger">Protein</h6>
                                                    <span id="proteinGrams" class="d-block h5 mb-1">150g</span>
                                                    <span id="proteinCalories" class="d-block small">600 calo</span>
                                                    <span id="proteinPercent"
                                                        class="badge bg-danger mt-1 px-2 py-1">30%</span>
                                                </div>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <div class="macro-card rounded border p-3 text-center">
                                                    <h6 class="text-success">Chất béo</h6>
                                                    <span id="fatGrams" class="d-block h5 mb-1">67g</span>
                                                    <span id="fatCalories" class="d-block small">600 calo</span>
                                                    <span id="fatPercent"
                                                        class="badge bg-success mt-1 px-2 py-1">30%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="macro-chart mb-4">
                                        <h6 class="mb-3">Biểu đồ phân bổ</h6>
                                        <div class="progress" style="height: 30px;">
                                            <div id="carbsBar" class="progress-bar bg-primary" role="progressbar"
                                                style="width: 40%;" aria-valuenow="40" aria-valuemin="0"
                                                aria-valuemax="100">Carbs 40%</div>
                                            <div id="proteinBar" class="progress-bar bg-danger" role="progressbar"
                                                style="width: 30%;" aria-valuenow="30" aria-valuemin="0"
                                                aria-valuemax="100">Protein 30%</div>
                                            <div id="fatBar" class="progress-bar bg-success" role="progressbar"
                                                style="width: 30%;" aria-valuenow="30" aria-valuemin="0"
                                                aria-valuemax="100">Chất béo 30%</div>
                                        </div>
                                    </div>

                                    <div class="macro-recommendation bg-light mb-4 rounded p-3">
                                        <h6><i class="fas fa-lightbulb text-warning me-2"></i>Nguồn thực phẩm gợi ý</h6>
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <h6 class="small text-primary mb-2">Nguồn Carbs tốt:</h6>
                                                <ul class="small mb-0 ps-3">
                                                    <li>Gạo lứt, yến mạch</li>
                                                    <li>Khoai lang, khoai tây</li>
                                                    <li>Trái cây tươi</li>
                                                    <li>Rau củ</li>
                                                    <li>Ngũ cốc nguyên hạt</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <h6 class="small text-danger mb-2">Nguồn Protein tốt:</h6>
                                                <ul class="small mb-0 ps-3">
                                                    <li>Thịt nạc (gà, bò, heo)</li>
                                                    <li>Trứng, cá, hải sản</li>
                                                    <li>Sữa, sữa chua Hy Lạp</li>
                                                    <li>Đậu phụ, đậu nành</li>
                                                    <li>Protein thực vật</li>
                                                </ul>
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <h6 class="small text-success mb-2">Nguồn Chất béo tốt:</h6>
                                                <ul class="small mb-0 ps-3">
                                                    <li>Dầu olive, dầu dừa</li>
                                                    <li>Bơ, quả bơ</li>
                                                    <li>Các loại hạt, hạt chia</li>
                                                    <li>Cá béo (cá hồi, cá ngừ)</li>
                                                    <li>Trứng, các loại cheese</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="macroExplanation" class="macro-explanation bg-light rounded p-3">
                                        <h6><i class="fas fa-info-circle text-primary me-2"></i>Diễn giải kết quả</h6>
                                        <p class="mb-0">Dựa trên thông tin cá nhân và mục tiêu của bạn, chúng tôi đề xuất
                                            tiêu thụ khoảng 2000 calo mỗi ngày, bao gồm 200g carbs, 150g protein và 67g chất
                                            béo. Đây là phân bổ cân bằng giúp cung cấp đủ năng lượng và dưỡng chất cho cơ
                                            thể.</p>
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
                            <h5 class="mb-0">Hiểu về Macros</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Macros là gì?</h6>
                            <p>Macros (macronutrients) là các chất dinh dưỡng đa lượng cung cấp calo và năng lượng cho cơ
                                thể:</p>
                            <ul>
                                <li><strong>Carbohydrates:</strong> 4 calo/gram - Nguồn năng lượng chính cho cơ thể và não
                                </li>
                                <li><strong>Protein:</strong> 4 calo/gram - Cần thiết cho xây dựng và phục hồi mô cơ</li>
                                <li><strong>Chất béo:</strong> 9 calo/gram - Hỗ trợ hấp thu vitamin, sản xuất hormone và bảo
                                    vệ nội tạng</li>
                            </ul>
                            <p>Cân bằng 3 nhóm chất này là chìa khóa cho sức khỏe tổng thể và đạt được mục tiêu thể hình.
                            </p>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Các kiểu phân bổ Macros</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Cân bằng (thông thường)</h6>
                            <p>40% carb, 30% protein, 30% chất béo - Phù hợp cho hầu hết mọi người, cung cấp năng lượng đều
                                đặn.</p>
                            <h6 class="mb-2">Giàu protein</h6>
                            <p>30% carb, 40% protein, 30% chất béo - Lý tưởng cho xây dựng cơ bắp và phục hồi sau tập luyện.
                            </p>
                            <h6 class="mb-2">Ít carb</h6>
                            <p>20% carb, 40% protein, 40% chất béo - Phù hợp cho giảm cân, hạn chế đột biến insulin.</p>
                            <h6 class="mb-2">Keto</h6>
                            <p>5% carb, 30% protein, 65% chất béo - Buộc cơ thể sử dụng mỡ làm nhiên liệu chính thay vì
                                carbs.</p>
                            <p class="text-danger mb-0"><i class="fas fa-exclamation-circle me-1"></i> Lưu ý: Luôn tham
                                khảo ý kiến bác sĩ hoặc chuyên gia dinh dưỡng trước khi thay đổi đáng kể chế độ ăn.</p>
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
        /* Macro card styling */
        .macro-card {
            transition: transform 0.2s;
        }

        .macro-card:hover {
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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const macroForm = document.getElementById('macroForm');
            const resultDiv = document.getElementById('macroResult');
            const dietType = document.getElementById('dietType');
            const customMacros = document.getElementById('customMacros');
            const customCarbs = document.getElementById('customCarbs');
            const customProtein = document.getElementById('customProtein');
            const customFat = document.getElementById('customFat');
            const macroTotalWarning = document.getElementById('macroTotalWarning');

            // Hiển thị/ẩn tùy chỉnh tỷ lệ macros
            dietType.addEventListener('change', function() {
                if (this.value === 'custom') {
                    customMacros.style.display = 'flex';
                } else {
                    customMacros.style.display = 'none';
                }
            });

            // Kiểm tra tổng tỷ lệ macros
            function checkMacroTotal() {
                const carbsVal = parseInt(customCarbs.value) || 0;
                const proteinVal = parseInt(customProtein.value) || 0;
                const fatVal = parseInt(customFat.value) || 0;
                const total = carbsVal + proteinVal + fatVal;

                if (total !== 100) {
                    macroTotalWarning.style.display = 'block';
                    return false;
                } else {
                    macroTotalWarning.style.display = 'none';
                    return true;
                }
            }

            customCarbs.addEventListener('input', checkMacroTotal);
            customProtein.addEventListener('input', checkMacroTotal);
            customFat.addEventListener('input', checkMacroTotal);

            macroForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Kiểm tra tỷ lệ macros tùy chỉnh
                if (dietType.value === 'custom' && !checkMacroTotal()) {
                    return; // Không tiếp tục nếu tổng không bằng 100%
                }

                // Lấy giá trị input
                const gender = document.getElementById('gender').value;
                const age = parseInt(document.getElementById('age').value);
                const weight = parseFloat(document.getElementById('weight').value);
                const height = parseFloat(document.getElementById('height').value);
                const activity = parseFloat(document.getElementById('activity').value);
                const goal = document.getElementById('goal').value;
                const bodyFat = document.getElementById('bodyFat').value ? parseFloat(document
                    .getElementById('bodyFat').value) : null;

                // Tính BMR - Mifflin-St Jeor formula
                let bmr;
                if (gender === 'male') {
                    bmr = 10 * weight + 6.25 * height - 5 * age + 5;
                } else {
                    bmr = 10 * weight + 6.25 * height - 5 * age - 161;
                }

                // Làm tròn BMR
                bmr = Math.round(bmr);

                // Tính TDEE
                const tdee = Math.round(bmr * activity);

                // Tính calo theo mục tiêu
                let goalCalories;
                let goalDesc;

                switch (goal) {
                    case 'lose-fat':
                        goalCalories = Math.round(tdee * 0.85); // Giảm 15%
                        goalDesc = "Giảm mỡ";
                        break;
                    case 'maintain':
                        goalCalories = tdee;
                        goalDesc = "Duy trì cân nặng";
                        break;
                    case 'gain-muscle':
                        goalCalories = Math.round(tdee * 1.1); // Tăng 10%
                        goalDesc = "Tăng cơ";
                        break;
                }

                // Xác định tỷ lệ macros
                let carbPercent, proteinPercent, fatPercent, dietTypeDesc;

                switch (dietType.value) {
                    case 'balanced':
                        carbPercent = 40;
                        proteinPercent = 30;
                        fatPercent = 30;
                        dietTypeDesc = "Cân bằng";
                        break;
                    case 'high-protein':
                        carbPercent = 30;
                        proteinPercent = 40;
                        fatPercent = 30;
                        dietTypeDesc = "Giàu protein";
                        break;
                    case 'low-carb':
                        carbPercent = 20;
                        proteinPercent = 40;
                        fatPercent = 40;
                        dietTypeDesc = "Ít carb";
                        break;
                    case 'keto':
                        carbPercent = 5;
                        proteinPercent = 30;
                        fatPercent = 65;
                        dietTypeDesc = "Keto";
                        break;
                    case 'custom':
                        carbPercent = parseInt(customCarbs.value);
                        proteinPercent = parseInt(customProtein.value);
                        fatPercent = parseInt(customFat.value);
                        dietTypeDesc = "Tùy chỉnh";
                        break;
                }

                // Điều chỉnh tỷ lệ macros dựa trên mục tiêu nếu không sử dụng tùy chỉnh
                if (dietType.value !== 'custom' && dietType.value !== 'keto') {
                    if (goal === 'lose-fat') {
                        // Giảm carbs, tăng protein khi giảm mỡ
                        carbPercent -= 5;
                        proteinPercent += 5;
                    } else if (goal === 'gain-muscle') {
                        // Tăng carbs khi tăng cơ
                        if (dietType.value !== 'high-protein') {
                            carbPercent += 5;
                            fatPercent -= 5;
                        }
                    }
                }

                // Tính lượng macros
                const carbCals = Math.round(goalCalories * (carbPercent / 100));
                const proteinCals = Math.round(goalCalories * (proteinPercent / 100));
                const fatCals = Math.round(goalCalories * (fatPercent / 100));

                const carbGrams = Math.round(carbCals / 4); // 1g carbs = 4 calo
                const proteinGrams = Math.round(proteinCals / 4); // 1g protein = 4 calo
                const fatGrams = Math.round(fatCals / 9); // 1g fat = 9 calo

                // Chuẩn bị diễn giải
                let explanation;

                // Tính protein theo cân nặng
                const proteinPerKg = Math.round(proteinGrams / weight * 10) / 10;

                if (bodyFat !== null) {
                    // Tính khối lượng gân cơ (Lean Body Mass)
                    const lbm = weight * (1 - (bodyFat / 100));
                    const proteinPerLbm = Math.round(proteinGrams / lbm * 10) / 10;

                    explanation =
                        `Dựa trên thông tin của bạn (${weight}kg, ${height}cm, ${age} tuổi, ${bodyFat}% mỡ), BMR là ${bmr} calo và TDEE là ${tdee} calo. Để đạt mục tiêu ${goalDesc.toLowerCase()}, bạn nên tiêu thụ khoảng ${goalCalories} calo mỗi ngày với phân bổ: ${carbGrams}g carbs, ${proteinGrams}g protein (${proteinPerKg}g/kg tổng cân nặng hoặc ${proteinPerLbm}g/kg khối lượng gân cơ), và ${fatGrams}g chất béo.`;
                } else {
                    explanation =
                        `Dựa trên thông tin của bạn (${weight}kg, ${height}cm, ${age} tuổi), BMR là ${bmr} calo và TDEE là ${tdee} calo. Để đạt mục tiêu ${goalDesc.toLowerCase()}, bạn nên tiêu thụ khoảng ${goalCalories} calo mỗi ngày với phân bổ: ${carbGrams}g carbs, ${proteinGrams}g protein (${proteinPerKg}g/kg cân nặng), và ${fatGrams}g chất béo.`;
                }

                // Cập nhật giao diện
                document.getElementById('totalCalories').textContent = goalCalories.toLocaleString();
                document.getElementById('bmrValue').textContent = `${bmr.toLocaleString()} calo`;
                document.getElementById('tdeeValue').textContent = `${tdee.toLocaleString()} calo`;
                document.getElementById('goalDescription').textContent = goalDesc;
                document.getElementById('dietTypeDescription').textContent = dietTypeDesc;

                // Macros
                document.getElementById('carbsGrams').textContent = `${carbGrams}g`;
                document.getElementById('carbsCalories').textContent = `${carbCals.toLocaleString()} calo`;
                document.getElementById('carbsPercent').textContent = `${carbPercent}%`;

                document.getElementById('proteinGrams').textContent = `${proteinGrams}g`;
                document.getElementById('proteinCalories').textContent =
                    `${proteinCals.toLocaleString()} calo`;
                document.getElementById('proteinPercent').textContent = `${proteinPercent}%`;

                document.getElementById('fatGrams').textContent = `${fatGrams}g`;
                document.getElementById('fatCalories').textContent = `${fatCals.toLocaleString()} calo`;
                document.getElementById('fatPercent').textContent = `${fatPercent}%`;

                // Cập nhật biểu đồ
                document.getElementById('carbsBar').style.width = `${carbPercent}%`;
                document.getElementById('carbsBar').setAttribute('aria-valuenow', carbPercent);
                document.getElementById('carbsBar').textContent = `Carbs ${carbPercent}%`;

                document.getElementById('proteinBar').style.width = `${proteinPercent}%`;
                document.getElementById('proteinBar').setAttribute('aria-valuenow', proteinPercent);
                document.getElementById('proteinBar').textContent = `Protein ${proteinPercent}%`;

                document.getElementById('fatBar').style.width = `${fatPercent}%`;
                document.getElementById('fatBar').setAttribute('aria-valuenow', fatPercent);
                document.getElementById('fatBar').textContent = `Chất béo ${fatPercent}%`;

                // Diễn giải
                document.getElementById('macroExplanation').querySelector('p').textContent = explanation;

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
