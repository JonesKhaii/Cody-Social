@extends('layouts.master')

@section('main-content')
    <div class="heart-risk-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/tools">Công cụ sức khỏe</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Đánh giá nguy cơ tim mạch</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Phần chính - Form nhập liệu -->
                <div class="col-lg-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Đánh giá nguy cơ tim mạch</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-4">Công cụ này đánh giá nguy cơ mắc bệnh tim mạch trong 10 năm tới dựa trên các
                                yếu tố nguy cơ chính. Kết quả chỉ mang tính tham khảo và không thay thế cho đánh giá y tế
                                chuyên nghiệp.</p>

                            <form id="heartRiskForm" class="mb-4">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="age" class="form-label">Tuổi <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="age" min="30"
                                            max="79" required>
                                        <small class="text-muted">30-79 tuổi</small>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="gender" class="form-label">Giới tính <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="gender" required>
                                            <option value="male">Nam</option>
                                            <option value="female">Nữ</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="race" class="form-label">Chủng tộc</label>
                                        <select class="form-select" id="race">
                                            <option value="asian">Châu Á</option>
                                            <option value="white">Da trắng</option>
                                            <option value="black">Da đen</option>
                                            <option value="hispanic">Latinh</option>
                                            <option value="other">Khác</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="totalCholesterol" class="form-label">Cholesterol tổng số (mg/dL) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="totalCholesterol" min="130"
                                            max="320" required>
                                        <small class="text-muted">130-320 mg/dL</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="hdlCholesterol" class="form-label">HDL Cholesterol (mg/dL) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="hdlCholesterol" min="20"
                                            max="100" required>
                                        <small class="text-muted">20-100 mg/dL</small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="systolicBP" class="form-label">Huyết áp tâm thu (mmHg) <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="systolicBP" min="90"
                                            max="200" required>
                                        <small class="text-muted">90-200 mmHg</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="bpMedication" class="form-label">Dùng thuốc huyết áp <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="bpMedication" required>
                                            <option value="no">Không</option>
                                            <option value="yes">Có</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="diabetic" class="form-label">Tiểu đường <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="diabetic" required>
                                            <option value="no">Không</option>
                                            <option value="yes">Có</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="smoker" class="form-label">Hút thuốc <span
                                                class="text-danger">*</span></label>
                                        <select class="form-select" id="smoker" required>
                                            <option value="never">Không bao giờ</option>
                                            <option value="former">Đã bỏ</option>
                                            <option value="current">Hiện tại đang hút</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Đánh giá nguy cơ</button>
                                </div>
                            </form>

                            <!-- Kết quả sẽ hiển thị ở đây -->
                            <div id="heartRiskResult" class="mt-4" style="display: none;">
                                <div class="result-container rounded border p-3">
                                    <h5 class="result-title mb-3">Kết quả đánh giá nguy cơ tim mạch</h5>

                                    <div class="row align-items-center mb-4">
                                        <div class="col-md-6">
                                            <div class="risk-score text-center">
                                                <span id="riskPercentage" class="d-block display-4 fw-bold">0%</span>
                                                <span class="text-muted">Nguy cơ tim mạch 10 năm</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="risk-category rounded p-3 text-center text-white"
                                                id="riskCategoryContainer">
                                                <h5 id="riskCategory" class="mb-0">Nguy cơ thấp</h5>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="risk-context mb-4">
                                        <h6 class="mb-2">Diễn giải kết quả:</h6>
                                        <p id="riskExplanation" class="mb-0">Dựa trên thông tin của bạn, nguy cơ mắc
                                            bệnh tim mạch trong 10 năm tới của bạn được đánh giá là thấp. Tiếp tục duy trì
                                            lối sống lành mạnh để giữ sức khỏe tim mạch tốt.</p>
                                    </div>

                                    <div class="risk-factors bg-light mb-4 rounded p-3">
                                        <h6 class="mb-2"><i
                                                class="fas fa-exclamation-triangle text-warning me-2"></i>Yếu tố nguy cơ
                                            của bạn:</h6>
                                        <ul id="riskFactorsList" class="mb-0">
                                            <!-- Danh sách yếu tố nguy cơ sẽ được đưa vào đây -->
                                        </ul>
                                    </div>

                                    <div class="risk-recommendations">
                                        <h6 class="mb-2">Khuyến nghị:</h6>
                                        <ul id="recommendationsList" class="mb-0">
                                            <!-- Danh sách khuyến nghị sẽ được đưa vào đây -->
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
                            <h5 class="mb-0">Về công cụ đánh giá</h5>
                        </div>
                        <div class="card-body">
                            <p>Công cụ này dựa trên phiên bản đơn giản hóa của cách tính điểm nguy cơ Framingham và ACC/AHA
                                Pooled Cohort Risk Assessment, được sử dụng rộng rãi để đánh giá nguy cơ tim mạch.</p>
                            <p>Phần trăm nguy cơ tính toán cho biết khả năng một người mắc bệnh tim mạch (như nhồi máu cơ
                                tim hoặc đột quỵ) trong 10 năm tới.</p>
                            <ul class="risk-levels mb-0">
                                <li><strong>Nguy cơ thấp:</strong> &lt;5%</li>
                                <li><strong>Nguy cơ trung bình:</strong> 5-7.5%</li>
                                <li><strong>Nguy cơ cao:</strong> 7.5-20%</li>
                                <li><strong>Nguy cơ rất cao:</strong> &gt;20%</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Yếu tố nguy cơ tim mạch</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Các yếu tố chính:</h6>
                            <ul>
                                <li>Tuổi cao (đặc biệt trên 55 tuổi với nữ, 45 tuổi với nam)</li>
                                <li>Huyết áp cao (≥130/80 mmHg)</li>
                                <li>Cholesterol cao</li>
                                <li>HDL Cholesterol thấp</li>
                                <li>Hút thuốc lá</li>
                                <li>Tiểu đường</li>
                                <li>Tiền sử gia đình bị bệnh tim mạch sớm</li>
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
                                <a href="/tools/blood-pressure"
                                    class="related-tool-item d-flex align-items-center mb-2 rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-stethoscope text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Đánh giá huyết áp</div>
                                        <small class="text-muted">Phân loại mức độ huyết áp và đề xuất</small>
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

                                <a href="/tools/diabetes-risk"
                                    class="related-tool-item d-flex align-items-center rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-syringe text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Đánh giá nguy cơ tiểu đường</div>
                                        <small class="text-muted">Kiểm tra nguy cơ mắc tiểu đường type 2</small>
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
        /* Risk category styling */
        .risk-category {
            background-color: #28a745;
            /* Default success color */
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
            const heartRiskForm = document.getElementById('heartRiskForm');
            const resultDiv = document.getElementById('heartRiskResult');

            heartRiskForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Lấy giá trị input
                const age = parseInt(document.getElementById('age').value);
                const gender = document.getElementById('gender').value;
                const race = document.getElementById('race').value;
                const totalCholesterol = parseInt(document.getElementById('totalCholesterol').value);
                const hdlCholesterol = parseInt(document.getElementById('hdlCholesterol').value);
                const systolicBP = parseInt(document.getElementById('systolicBP').value);
                const bpMedication = document.getElementById('bpMedication').value === 'yes';
                const diabetic = document.getElementById('diabetic').value === 'yes';
                const smoker = document.getElementById('smoker').value;

                // Tính nguy cơ tim mạch (phiên bản đơn giản hóa)
                let riskScore = 0;

                // Điểm cơ bản dựa trên độ tuổi
                if (age < 40) riskScore += 0;
                else if (age < 50) riskScore += 2;
                else if (age < 60) riskScore += 4;
                else if (age < 70) riskScore += 6;
                else riskScore += 8;

                // Điểm cho huyết áp
                if (systolicBP < 120) riskScore += 0;
                else if (systolicBP < 130) riskScore += 1;
                else if (systolicBP < 140) riskScore += 2;
                else if (systolicBP < 160) riskScore += 3;
                else riskScore += 4;

                // Điểm cộng nếu dùng thuốc huyết áp
                if (bpMedication) riskScore += 1;

                // Điểm cho cholesterol
                const cholesterolRatio = totalCholesterol / hdlCholesterol;
                if (cholesterolRatio < 4) riskScore += 0;
                else if (cholesterolRatio < 5) riskScore += 1;
                else if (cholesterolRatio < 6) riskScore += 2;
                else riskScore += 3;

                // Điểm cho HDL (cholesterol tốt)
                if (hdlCholesterol >= 60) riskScore -= 1; // Bảo vệ
                else if (hdlCholesterol < 40) riskScore += 1; // Nguy cơ

                // Điểm cho tiểu đường
                if (diabetic) riskScore += 2;

                // Điểm cho hút thuốc
                if (smoker === 'current') riskScore += 3;
                else if (smoker === 'former') riskScore += 1;

                // Điều chỉnh theo giới tính
                if (gender === 'female') {
                    riskScore -= 1; // Phụ nữ thường có nguy cơ thấp hơn nam giới

                    // Điều chỉnh thêm cho phụ nữ sau mãn kinh
                    if (age >= 55) riskScore += 1;
                }

                // Điều chỉnh theo chủng tộc (đơn giản hóa)
                if (race === 'black') riskScore += 1;
                else if (race === 'asian') riskScore -= 1;

                // Tính phần trăm nguy cơ (đơn giản hóa từ thang điểm)
                let riskPercentage;
                if (riskScore <= 0) riskPercentage = 1;
                else if (riskScore <= 3) riskPercentage = 2 + (riskScore - 1);
                else if (riskScore <= 6) riskPercentage = 5 + (riskScore - 3) * 1.5;
                else if (riskScore <= 10) riskPercentage = 10 + (riskScore - 6) * 2.5;
                else if (riskScore <= 15) riskPercentage = 20 + (riskScore - 10) * 4;
                else riskPercentage = 40 + (riskScore - 15) * 5;

                // Giới hạn tối đa
                riskPercentage = Math.min(riskPercentage, 50);
                // Làm tròn
                riskPercentage = Math.round(riskPercentage * 10) / 10;

                // Phân loại nguy cơ và hiển thị
                let riskCategory, riskColor, riskExplanation;
                const riskFactors = [];
                const recommendations = [];

                // Thêm yếu tố nguy cơ cơ bản vào danh sách
                if (age >= 55 && gender === 'female' || age >= 45 && gender === 'male') {
                    riskFactors.push(`Tuổi (${age} tuổi)`);
                }

                if (systolicBP >= 130) {
                    riskFactors.push(`Huyết áp cao (${systolicBP} mmHg)`);
                    recommendations.push(
                        "Theo dõi huyết áp thường xuyên và cân nhắc các biện pháp kiểm soát");
                }

                if (bpMedication) {
                    riskFactors.push("Đang dùng thuốc điều trị huyết áp");
                    recommendations.push("Duy trì việc dùng thuốc theo đúng chỉ dẫn của bác sĩ");
                }

                if (totalCholesterol > 200) {
                    riskFactors.push(`Cholesterol tổng số cao (${totalCholesterol} mg/dL)`);
                    recommendations.push("Giảm chất béo bão hòa và trans fat trong chế độ ăn");
                }

                if (hdlCholesterol < 40) {
                    riskFactors.push(`HDL Cholesterol thấp (${hdlCholesterol} mg/dL)`);
                    recommendations.push("Tăng cường hoạt động thể chất và thực phẩm giàu omega-3");
                }

                if (diabetic) {
                    riskFactors.push("Tiểu đường");
                    recommendations.push("Kiểm soát đường huyết tốt và khám định kỳ với bác sĩ");
                }

                if (smoker === 'current') {
                    riskFactors.push("Đang hút thuốc lá");
                    recommendations.push(
                        "Bỏ hút thuốc là biện pháp hiệu quả nhất để giảm nguy cơ tim mạch");
                } else if (smoker === 'former') {
                    riskFactors.push("Đã từng hút thuốc lá");
                }

                // Thêm khuyến nghị cơ bản
                recommendations.push(
                    "Duy trì chế độ ăn giàu rau củ quả, ngũ cốc nguyên hạt, và protein nạc");
                recommendations.push("Tập thể dục ít nhất 150 phút/tuần với cường độ vừa phải");
                recommendations.push("Hạn chế rượu bia và đồ uống có cồn");
                recommendations.push("Kiểm tra sức khỏe định kỳ, bao gồm các chỉ số lipid máu và huyết áp");

                // Phân loại nguy cơ
                if (riskPercentage < 5) {
                    riskCategory = "Nguy cơ thấp";
                    riskColor = "#28a745"; // success green
                    riskExplanation =
                        `Nguy cơ mắc bệnh tim mạch 10 năm của bạn là ${riskPercentage}%, được đánh giá là thấp. Tiếp tục duy trì lối sống lành mạnh để giữ sức khỏe tim mạch tốt.`;
                } else if (riskPercentage < 7.5) {
                    riskCategory = "Nguy cơ trung bình";
                    riskColor = "#ffc107"; // warning yellow
                    riskExplanation =
                        `Nguy cơ mắc bệnh tim mạch 10 năm của bạn là ${riskPercentage}%, được đánh giá là trung bình. Hãy cân nhắc thay đổi lối sống và theo dõi các yếu tố nguy cơ.`;
                    recommendations.push("Nên thảo luận với bác sĩ về các biện pháp dự phòng");
                } else if (riskPercentage < 20) {
                    riskCategory = "Nguy cơ cao";
                    riskColor = "#fd7e14"; // orange
                    riskExplanation =
                        `Nguy cơ mắc bệnh tim mạch 10 năm của bạn là ${riskPercentage}%, được đánh giá là cao. Cần thực hiện các biện pháp giảm thiểu nguy cơ và tham khảo ý kiến bác sĩ.`;
                    recommendations.push("Nên gặp bác sĩ để đánh giá chi tiết và lên kế hoạch điều trị");
                    recommendations.push("Có thể cần dùng thuốc để kiểm soát các yếu tố nguy cơ");
                } else {
                    riskCategory = "Nguy cơ rất cao";
                    riskColor = "#dc3545"; // danger red
                    riskExplanation =
                        `Nguy cơ mắc bệnh tim mạch 10 năm của bạn là ${riskPercentage}%, được đánh giá là rất cao. Cần can thiệp y tế ngay lập tức để giảm nguy cơ.`;
                    recommendations.push("Cần gặp bác sĩ tim mạch càng sớm càng tốt");
                    recommendations.push(
                        "Có thể cần điều trị tích cực bằng thuốc và thay đổi lối sống triệt để");
                    recommendations.push("Theo dõi sát các chỉ số sức khỏe và tuân thủ hướng dẫn điều trị");
                }

                // Cập nhật giao diện
                document.getElementById('riskPercentage').textContent = `${riskPercentage}%`;
                document.getElementById('riskCategory').textContent = riskCategory;
                document.getElementById('riskCategoryContainer').style.backgroundColor = riskColor;
                document.getElementById('riskExplanation').textContent = riskExplanation;

                // Hiển thị yếu tố nguy cơ
                const riskFactorsList = document.getElementById('riskFactorsList');
                riskFactorsList.innerHTML = '';
                if (riskFactors.length === 0) {
                    riskFactorsList.innerHTML = '<li>Không phát hiện yếu tố nguy cơ đáng kể</li>';
                } else {
                    riskFactors.forEach(factor => {
                        const li = document.createElement('li');
                        li.textContent = factor;
                        riskFactorsList.appendChild(li);
                    });
                }

                // Hiển thị khuyến nghị
                const recommendationsList = document.getElementById('recommendationsList');
                recommendationsList.innerHTML = '';
                recommendations.forEach(recommendation => {
                    const li = document.createElement('li');
                    li.textContent = recommendation;
                    recommendationsList.appendChild(li);
                });

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
