@extends('layouts.master')

@section('main-content')
    <div class="calorie-needs-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/tools">Công cụ sức khỏe</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tính nhu cầu calo</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Phần chính - Form nhập liệu -->
                <div class="col-lg-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-utensils me-2"></i>Tính nhu cầu calo</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-4">Công cụ này giúp bạn tính toán nhu cầu calo hàng ngày dựa trên các thông số cơ
                                thể và mục tiêu cân nặng của bạn. Kết quả giúp bạn lập kế hoạch dinh dưỡng phù hợp.</p>

                            <form id="calorieForm" class="mb-4">
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
                                            <option value="lose-fast">Giảm cân nhanh (-15% calo)</option>
                                            <option value="lose" selected>Giảm cân (-10% calo)</option>
                                            <option value="maintain">Duy trì cân nặng</option>
                                            <option value="gain">Tăng cân (+10% calo)</option>
                                            <option value="gain-muscle">Tăng cơ (+15% calo)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="formula" class="form-label">Công thức tính</label>
                                        <select class="form-select" id="formula">
                                            <option value="mifflin" selected>Mifflin-St Jeor (khuyến nghị)</option>
                                            <option value="harris">Harris-Benedict</option>
                                            <option value="who">WHO/FAO</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Tính nhu cầu calo</button>
                                </div>
                            </form>

                            <!-- Kết quả sẽ hiển thị ở đây -->
                            <div id="calorieResult" class="mt-4" style="display: none;">
                                <div class="result-container rounded border p-3">
                                    <h5 class="result-title mb-3">Kết quả tính nhu cầu calo</h5>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="calorie-base mb-3 text-center">
                                                <span id="baseBMR" class="d-block h4 fw-bold text-primary">0</span>
                                                <span class="text-muted">Tỷ lệ trao đổi chất cơ bản (BMR)</span>
                                                <small class="d-block text-muted mt-1">Calo cần thiết khi nghỉ ngơi</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="calorie-maintenance mb-3 text-center">
                                                <span id="maintenanceCalories"
                                                    class="d-block h4 fw-bold text-success">0</span>
                                                <span class="text-muted">Calo duy trì cân nặng (TDEE)</span>
                                                <small class="d-block text-muted mt-1">Calo để duy trì cân nặng hiện
                                                    tại</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="calorie-goal border-top mb-4 pt-3">
                                        <div class="text-center">
                                            <span id="goalCalories"
                                                class="d-block display-4 fw-bold text-primary">0</span>
                                            <span class="text-muted d-block mb-2">Calo cần thiết theo mục tiêu của
                                                bạn</span>
                                            <span id="goalDescription" class="badge rounded-pill mb-2 px-3 py-2">Giảm
                                                cân</span>
                                        </div>
                                        <div class="calorie-explanation bg-light mt-3 rounded p-3">
                                            <p id="calorieExplanation" class="mb-0">Dựa trên thông tin của bạn, để đạt
                                                được mục tiêu giảm cân, bạn nên tiêu thụ khoảng [calorie] calo mỗi ngày.</p>
                                        </div>
                                    </div>

                                    <h6 class="mb-3">Phân bổ dinh dưỡng đại khái</h6>
                                    <div class="row mb-3">
                                        <div class="col-md-4 mb-3">
                                            <div class="nutrient-card rounded border p-3 text-center">
                                                <h6 class="text-danger">Protein</h6>
                                                <span id="proteinGrams" class="d-block h5 mb-0">0g</span>
                                                <span id="proteinCals" class="d-block small text-muted">0 calo
                                                    (30%)</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="nutrient-card rounded border p-3 text-center">
                                                <h6 class="text-primary">Carbohydrates</h6>
                                                <span id="carbGrams" class="d-block h5 mb-0">0g</span>
                                                <span id="carbCals" class="d-block small text-muted">0 calo (40%)</span>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <div class="nutrient-card rounded border p-3 text-center">
                                                <h6 class="text-success">Chất béo</h6>
                                                <span id="fatGrams" class="d-block h5 mb-0">0g</span>
                                                <span id="fatCals" class="d-block small text-muted">0 calo (30%)</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="calorieRecommendation" class="calorie-recommendation bg-light rounded p-3">
                                        <h6><i class="fas fa-lightbulb text-warning me-2"></i>Khuyến nghị dinh dưỡng</h6>
                                        <p class="mb-0" id="recommendationText">Để đạt được mục tiêu, hãy tập trung vào
                                            thực phẩm nguyên chất, tăng lượng protein, điều chỉnh carbs theo mức độ hoạt
                                            động, và chọn chất béo lành mạnh từ các nguồn như cá, các loại hạt, và dầu ô
                                            liu.</p>
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
                            <h5 class="mb-0">Hiểu về nhu cầu calo</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">BMR là gì?</h6>
                            <p>Basal Metabolic Rate (BMR) là lượng calo tối thiểu cơ thể cần để duy trì các chức năng sống
                                cơ bản khi nghỉ ngơi hoàn toàn.</p>
                            <hr>
                            <h6 class="mb-2">TDEE là gì?</h6>
                            <p>Total Daily Energy Expenditure (TDEE) là tổng lượng calo cơ thể tiêu thụ trong một ngày, bao
                                gồm BMR và năng lượng cho hoạt động thể chất.</p>
                            <hr>
                            <h6 class="mb-2">Các yếu tố ảnh hưởng:</h6>
                            <ul class="mb-0">
                                <li>Giới tính: Nam thường cần nhiều calo hơn nữ</li>
                                <li>Tuổi: Nhu cầu calo giảm dần theo tuổi</li>
                                <li>Cân nặng và chiều cao: Người nặng hơn cần nhiều calo hơn</li>
                                <li>Hoạt động thể chất: Vận động nhiều cần năng lượng cao hơn</li>
                                <li>Tỷ lệ cơ/mỡ: Cơ bắp đốt cháy nhiều calo hơn mỡ</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Lời khuyên về dinh dưỡng</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Giảm cân an toàn:</h6>
                            <p>Giảm 0.5-1kg/tuần là mức độ giảm cân khỏe mạnh và bền vững. Tránh giảm dưới 1200 calo/ngày
                                (nữ) hoặc 1500 calo/ngày (nam).</p>

                            <h6 class="mb-2">Tăng cân khỏe mạnh:</h6>
                            <p>Tăng 0.25-0.5kg/tuần là lý tưởng cho việc tăng cân chất lượng (chủ yếu là cơ, không phải mỡ).
                            </p>

                            <h6 class="mb-2">Phân bổ dinh dưỡng:</h6>
                            <ul>
                                <li><strong>Protein:</strong> 1.6-2.2g/kg cân nặng cho người tập luyện, 0.8-1.6g/kg cho
                                    người ít vận động</li>
                                <li><strong>Carbohydrates:</strong> 3-5g/kg tùy mức độ hoạt động</li>
                                <li><strong>Chất béo:</strong> 0.5-1.5g/kg, ưu tiên chất béo không bão hòa</li>
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

                                <a href="/tools/water-intake"
                                    class="related-tool-item d-flex align-items-center mb-2 rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-tint text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Lượng nước cần uống</div>
                                        <small class="text-muted">Tính nhu cầu nước theo cân nặng</small>
                                    </div>
                                </a>

                                <a href="/tools/bmr-calculator"
                                    class="related-tool-item d-flex align-items-center rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-fire text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính BMR và TDEE</div>
                                        <small class="text-muted">Tỷ lệ trao đổi chất chi tiết</small>
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
        /* Nutrient card styling */
        .nutrient-card {
            transition: transform 0.2s;
        }

        .nutrient-card:hover {
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
            const calorieForm = document.getElementById('calorieForm');
            const resultDiv = document.getElementById('calorieResult');

            calorieForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Lấy giá trị input
                const gender = document.getElementById('gender').value;
                const age = parseInt(document.getElementById('age').value);
                const weight = parseFloat(document.getElementById('weight').value);
                const height = parseFloat(document.getElementById('height').value);
                const activity = parseFloat(document.getElementById('activity').value);
                const goal = document.getElementById('goal').value;
                const formula = document.getElementById('formula').value;

                // Tính BMR dựa trên công thức được chọn
                let bmr = 0;

                if (formula === 'mifflin') {
                    // Công thức Mifflin-St Jeor
                    if (gender === 'male') {
                        bmr = 10 * weight + 6.25 * height - 5 * age + 5;
                    } else {
                        bmr = 10 * weight + 6.25 * height - 5 * age - 161;
                    }
                } else if (formula === 'harris') {
                    // Công thức Harris-Benedict
                    if (gender === 'male') {
                        bmr = 13.397 * weight + 4.799 * height - 5.677 * age + 88.362;
                    } else {
                        bmr = 9.247 * weight + 3.098 * height - 4.330 * age + 447.593;
                    }
                } else if (formula === 'who') {
                    // Công thức WHO/FAO
                    if (gender === 'male') {
                        if (age < 30) bmr = 15.3 * weight + 679;
                        else if (age < 60) bmr = 11.6 * weight + 879;
                        else bmr = 13.5 * weight + 487;
                    } else {
                        if (age < 30) bmr = 14.7 * weight + 496;
                        else if (age < 60) bmr = 8.7 * weight + 829;
                        else bmr = 10.5 * weight + 596;
                    }
                }

                // Làm tròn BMR
                bmr = Math.round(bmr);

                // Tính TDEE (Total Daily Energy Expenditure)
                const tdee = Math.round(bmr * activity);

                // Tính calo theo mục tiêu
                let goalCalories;
                let goalDesc;
                let goalBadgeClass;

                switch (goal) {
                    case 'lose-fast':
                        goalCalories = Math.round(tdee * 0.85); // Giảm 15%
                        goalDesc = "Giảm cân nhanh";
                        goalBadgeClass = "bg-danger";
                        break;
                    case 'lose':
                        goalCalories = Math.round(tdee * 0.9); // Giảm 10%
                        goalDesc = "Giảm cân";
                        goalBadgeClass = "bg-warning";
                        break;
                    case 'maintain':
                        goalCalories = tdee;
                        goalDesc = "Duy trì cân nặng";
                        goalBadgeClass = "bg-info";
                        break;
                    case 'gain':
                        goalCalories = Math.round(tdee * 1.1); // Tăng 10%
                        goalDesc = "Tăng cân";
                        goalBadgeClass = "bg-success";
                        break;
                    case 'gain-muscle':
                        goalCalories = Math.round(tdee * 1.15); // Tăng 15%
                        goalDesc = "Tăng cơ";
                        goalBadgeClass = "bg-primary";
                        break;
                }

                // Tính phân bổ macros (mặc định: 30% protein, 40% carbs, 30% chất béo)
                let proteinPercent, carbPercent, fatPercent;

                if (goal === 'lose-fast' || goal === 'lose') {
                    // Tăng protein cho giảm cân
                    proteinPercent = 35;
                    carbPercent = 35;
                    fatPercent = 30;
                } else if (goal === 'gain-muscle') {
                    // Tăng protein và carbs cho tăng cơ
                    proteinPercent = 30;
                    carbPercent = 45;
                    fatPercent = 25;
                } else {
                    // Cân bằng cho duy trì và tăng cân thông thường
                    proteinPercent = 30;
                    carbPercent = 40;
                    fatPercent = 30;
                }

                const proteinCals = Math.round(goalCalories * (proteinPercent / 100));
                const carbCals = Math.round(goalCalories * (carbPercent / 100));
                const fatCals = Math.round(goalCalories * (fatPercent / 100));

                const proteinGrams = Math.round(proteinCals / 4); // 1g protein = 4 calo
                const carbGrams = Math.round(carbCals / 4); // 1g carbs = 4 calo
                const fatGrams = Math.round(fatCals / 9); // 1g fat = 9 calo

                // Chuẩn bị diễn giải và khuyến nghị
                let explanation, recommendation;

                explanation =
                    `Dựa trên thông tin của bạn, BMR (tỷ lệ trao đổi chất cơ bản) là ${bmr} calo/ngày và TDEE (tổng năng lượng tiêu thụ hàng ngày) là ${tdee} calo/ngày. Để đạt được mục tiêu ${goalDesc.toLowerCase()}, bạn nên tiêu thụ khoảng ${goalCalories} calo mỗi ngày.`;

                // Khuyến nghị dựa trên mục tiêu
                if (goal === 'lose-fast' || goal === 'lose') {
                    recommendation =
                        `Để giảm cân hiệu quả và lành mạnh, hãy tập trung vào thực phẩm nguyên chất, giàu protein (khoảng ${proteinGrams}g/ngày), hạn chế carbs đơn giản, và chọn chất béo lành mạnh. Kết hợp tập luyện cardio và tập sức bền. Đừng giảm dưới ${gender === 'male' ? 1500 : 1200} calo/ngày để đảm bảo sức khỏe.`;
                } else if (goal === 'maintain') {
                    recommendation =
                        `Để duy trì cân nặng, hãy tập trung vào chế độ ăn cân bằng với khoảng ${proteinGrams}g protein, ${carbGrams}g carbs, và ${fatGrams}g chất béo mỗi ngày. Duy trì tập luyện đều đặn và theo dõi cân nặng hàng tuần để điều chỉnh nếu cần.`;
                } else if (goal === 'gain' || goal === 'gain-muscle') {
                    recommendation =
                        `Để tăng cân/cơ bắp, hãy tăng cường tiêu thụ protein (cố gắng đạt ${proteinGrams}g/ngày hoặc khoảng ${Math.round(proteinGrams/weight * 10) / 10}g/kg cân nặng), ưu tiên carbs phức hợp (${carbGrams}g/ngày), và đảm bảo đủ chất béo tốt (${fatGrams}g/ngày). Tập luyện sức bền 3-5 lần/tuần và tăng cường ăn nhiều bữa nhỏ nếu khó tiêu thụ đủ calo.`;
                }

                // Cập nhật giao diện
                document.getElementById('baseBMR').textContent = bmr.toLocaleString();
                document.getElementById('maintenanceCalories').textContent = tdee.toLocaleString();
                document.getElementById('goalCalories').textContent = goalCalories.toLocaleString();

                const goalBadge = document.getElementById('goalDescription');
                goalBadge.textContent = goalDesc;
                goalBadge.className = `badge rounded-pill px-3 py-2 mb-2 ${goalBadgeClass}`;

                document.getElementById('calorieExplanation').textContent = explanation;
                document.getElementById('recommendationText').textContent = recommendation;

                // Cập nhật macros
                document.getElementById('proteinGrams').textContent = `${proteinGrams}g`;
                document.getElementById('proteinCals').textContent =
                    `${proteinCals} calo (${proteinPercent}%)`;

                document.getElementById('carbGrams').textContent = `${carbGrams}g`;
                document.getElementById('carbCals').textContent = `${carbCals} calo (${carbPercent}%)`;

                document.getElementById('fatGrams').textContent = `${fatGrams}g`;
                document.getElementById('fatCals').textContent = `${fatCals} calo (${fatPercent}%)`;

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
