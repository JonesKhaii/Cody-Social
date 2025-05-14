@extends('layouts.master')

@section('main-content')
    <div class="heart-rate-zones-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/tools">Công cụ sức khỏe</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Vùng nhịp tim tập luyện</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Phần chính - Form nhập liệu -->
                <div class="col-lg-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-running me-2"></i>Tính vùng nhịp tim tập luyện</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-4">Tập luyện trong các vùng nhịp tim khác nhau mang lại lợi ích khác nhau, từ đốt
                                mỡ đến cải thiện sức bền và khả năng tim mạch. Công cụ này giúp bạn tính các vùng nhịp tim
                                dựa trên tuổi và mức độ rèn luyện.</p>

                            <form id="hrForm" class="mb-4">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="age" class="form-label">Tuổi <span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="age" min="15"
                                            max="100" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="restingHR" class="form-label">Nhịp tim lúc nghỉ (nhịp/phút)</label>
                                        <input type="number" class="form-control" id="restingHR" min="40"
                                            max="120" placeholder="Tùy chọn">
                                        <small class="text-muted">Đo lúc nghỉ ngơi hoàn toàn, tốt nhất là sau khi thức
                                            dậy</small>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="fitness" class="form-label">Mức độ tập luyện</label>
                                        <select class="form-select" id="fitness">
                                            <option value="beginner">Mới bắt đầu</option>
                                            <option value="intermediate" selected>Trung bình</option>
                                            <option value="advanced">Nâng cao</option>
                                            <option value="athlete">Vận động viên</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="formula" class="form-label">Công thức tính</label>
                                        <select class="form-select" id="formula">
                                            <option value="standard" selected>Tiêu chuẩn (220 - Tuổi)</option>
                                            <option value="tanaka">Tanaka (208 - 0.7 × Tuổi)</option>
                                            <option value="karvonen">Karvonen (Sử dụng nhịp tim lúc nghỉ)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Tính vùng nhịp tim</button>
                                </div>
                            </form>

                            <!-- Kết quả sẽ hiển thị ở đây -->
                            <div id="hrResult" class="mt-4" style="display: none;">
                                <div class="result-container rounded border p-3">
                                    <h5 class="result-title mb-3">Các vùng nhịp tim của bạn</h5>

                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="max-hr-value mb-3 text-center">
                                                <span id="maxHR"
                                                    class="d-block display-4 fw-bold text-primary">180</span>
                                                <span class="text-muted">Nhịp tim tối đa (bpm)</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex flex-column justify-content-center">
                                            <p id="hrExplanation" class="mb-0">Đây là nhịp tim tối đa ước tính dựa trên độ
                                                tuổi của bạn. Các vùng nhịp tim dưới đây được tính dựa trên giá trị này.</p>
                                        </div>
                                    </div>

                                    <!-- Biểu đồ vùng nhịp tim -->
                                    <div class="hr-zones mb-4">
                                        <div class="zone zone-5 mb-2 p-3 text-white" style="background-color: #d62828;">
                                            <div class="row align-items-center">
                                                <div class="col-md-3">
                                                    <h6 class="mb-0">Vùng 5</h6>
                                                    <span class="small">Tối đa</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span id="zone5" class="fw-bold">171-190 bpm</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span id="zone5Percent" class="small">90-100%</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span class="small">Hiệu suất tối đa, thời gian ngắn</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zone zone-4 mb-2 p-3 text-white" style="background-color: #f77f00;">
                                            <div class="row align-items-center">
                                                <div class="col-md-3">
                                                    <h6 class="mb-0">Vùng 4</h6>
                                                    <span class="small">Ngưỡng</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span id="zone4Percent" class="small">80-90%</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span class="small">Tăng sức bền, khả năng chịu đựng</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zone zone-3 mb-2 p-3 text-white" style="background-color: #fcbf49;">
                                            <div class="row align-items-center">
                                                <div class="col-md-3">
                                                    <h6 class="mb-0">Vùng 3</h6>
                                                    <span class="small">Hiếu khí</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span id="zone3" class="fw-bold">133-151 bpm</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span id="zone3Percent" class="small">70-80%</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span class="small">Cải thiện sức bền tim mạch</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zone zone-2 mb-2 p-3 text-white" style="background-color: #90be6d;">
                                            <div class="row align-items-center">
                                                <div class="col-md-3">
                                                    <h6 class="mb-0">Vùng 2</h6>
                                                    <span class="small">Đốt mỡ</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span id="zone2" class="fw-bold">114-132 bpm</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span id="zone2Percent" class="small">60-70%</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span class="small">Tối ưu đốt mỡ, cải thiện sức khỏe tim</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="zone zone-1 p-3 text-white" style="background-color: #43aa8b;">
                                            <div class="row align-items-center">
                                                <div class="col-md-3">
                                                    <h6 class="mb-0">Vùng 1</h6>
                                                    <span class="small">Khởi động</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span id="zone1" class="fw-bold">95-113 bpm</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span id="zone1Percent" class="small">50-60%</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span class="small">Khởi động, hồi phục, cải thiện sức bền cơ
                                                        bản</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="hrRecommendation" class="hr-recommendation bg-light rounded p-3">
                                        <h6><i class="fas fa-lightbulb text-warning me-2"></i>Khuyến nghị tập luyện</h6>
                                        <p class="mb-0" id="recommendationText">Tùy thuộc vào mục tiêu tập luyện, hãy
                                            tập trung vào vùng nhịp tim phù hợp. Vùng 2 (60-70%) tối ưu cho đốt mỡ, vùng 3-4
                                            (70-90%) cải thiện sức bền tim mạch.</p>
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
                            <h5 class="mb-0">Hiểu về vùng nhịp tim</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Vùng nhịp tim là gì?</h6>
                            <p>Vùng nhịp tim là các khoảng nhịp tim được chia dựa trên tỷ lệ phần trăm của nhịp tim tối đa.
                                Mỗi vùng có lợi ích tập luyện khác nhau:</p>
                            <ul>
                                <li><strong>Vùng 1 (50-60%):</strong> Tập nhẹ nhàng, phù hợp cho khởi động và phục hồi.</li>
                                <li><strong>Vùng 2 (60-70%):</strong> Vùng đốt mỡ - tập thời gian dài, cải thiện sức khỏe
                                    tim mạch.</li>
                                <li><strong>Vùng 3 (70-80%):</strong> Vùng hiếu khí - cải thiện hệ thống tim mạch và sức
                                    bền.</li>
                                <li><strong>Vùng 4 (80-90%):</strong> Vùng ngưỡng - tăng khả năng chịu đựng và tốc độ.</li>
                                <li><strong>Vùng 5 (90-100%):</strong> Vùng tối đa - tăng hiệu suất tối đa, chỉ duy trì được
                                    trong thời gian ngắn.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Công thức tính nhịp tim</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Các công thức tính nhịp tim tối đa:</h6>
                            <ul class="mb-3">
                                <li><strong>Tiêu chuẩn:</strong> 220 - Tuổi</li>
                                <li><strong>Tanaka:</strong> 208 - (0.7 × Tuổi)</li>
                                <li><strong>Karvonen:</strong> Sử dụng nhịp tim lúc nghỉ để tính tỷ lệ dự trữ nhịp tim</li>
                            </ul>

                            <h6 class="mb-2">Làm sao để đo nhịp tim lúc nghỉ?</h6>
                            <p>Đo khi vừa thức dậy, trước khi rời khỏi giường. Đếm số nhịp đập trong 60 giây hoặc đếm trong
                                15 giây và nhân với 4.</p>
                            <p class="text-danger mb-0"><i class="fas fa-exclamation-circle me-1"></i> Kết quả chỉ mang
                                tính tham khảo, không thay thế cho tư vấn y tế chuyên nghiệp.</p>
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
        /* Zone styling */
        .zone {
            border-radius: 5px;
            transition: transform 0.2s;
        }

        .zone:hover {
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
            const hrForm = document.getElementById('hrForm');
            const resultDiv = document.getElementById('hrResult');
            const formulaSelect = document.getElementById('formula');

            // Cập nhật trạng thái ô nhập liệu nhịp tim lúc nghỉ
            formulaSelect.addEventListener('change', function() {
                const restingHR = document.getElementById('restingHR');
                if (this.value === 'karvonen') {
                    restingHR.setAttribute('required', 'required');
                    restingHR.setAttribute('placeholder', 'Bắt buộc cho công thức Karvonen');
                } else {
                    restingHR.removeAttribute('required');
                    restingHR.setAttribute('placeholder', 'Tùy chọn');
                }
            });

            hrForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Lấy giá trị input
                const age = parseInt(document.getElementById('age').value);
                const restingHR = parseInt(document.getElementById('restingHR').value || 60);
                const fitness = document.getElementById('fitness').value;
                const formulaType = document.getElementById('formula').value;

                // Tính nhịp tim tối đa
                let maxHR;
                let explanation;

                // Công thức tính nhịp tim tối đa
                if (formulaType === 'standard') {
                    maxHR = 220 - age;
                    explanation = "Nhịp tim tối đa được tính theo công thức chuẩn: 220 - Tuổi.";
                } else if (formulaType === 'tanaka') {
                    maxHR = 208 - (0.7 * age);
                    explanation =
                        "Nhịp tim tối đa được tính theo công thức Tanaka: 208 - (0.7 × Tuổi), thường chính xác hơn cho người lớn tuổi.";
                } else if (formulaType === 'karvonen') {
                    // Sử dụng công thức chuẩn cho maxHR, nhưng sẽ điều chỉnh các vùng bằng HRR
                    maxHR = 220 - age;
                    explanation = "Sử dụng công thức Karvonen với nhịp tim lúc nghỉ: " + restingHR +
                        " bpm để tính tỷ lệ phần trăm dự trữ nhịp tim (HRR).";
                }

                // Làm tròn maxHR
                maxHR = Math.round(maxHR);

                // Điều chỉnh nhịp tim tối đa dựa trên mức độ tập luyện
                if (fitness === 'beginner') {
                    // Không điều chỉnh
                } else if (fitness === 'intermediate') {
                    // Người tập trung bình có thể có nhịp tim tối đa cao hơn một chút
                    maxHR = Math.round(maxHR * 1.02);
                    explanation += " Điều chỉnh +2% cho mức độ tập luyện trung bình.";
                } else if (fitness === 'advanced') {
                    // Người tập nâng cao thường có nhịp tim tối đa cao hơn
                    maxHR = Math.round(maxHR * 1.05);
                    explanation += " Điều chỉnh +5% cho mức độ tập luyện nâng cao.";
                } else if (fitness === 'athlete') {
                    // Vận động viên có thể đạt nhịp tim cao hơn lý thuyết
                    maxHR = Math.round(maxHR * 1.08);
                    explanation += " Điều chỉnh +8% cho vận động viên.";
                }

                // Tính các vùng nhịp tim
                let zone1Lower, zone1Upper, zone2Lower, zone2Upper, zone3Lower, zone3Upper, zone4Lower,
                    zone4Upper, zone5Lower, zone5Upper;

                if (formulaType === 'karvonen') {
                    // Sử dụng công thức Karvonen với Heart Rate Reserve (HRR)
                    const hrr = maxHR - restingHR;

                    zone1Lower = Math.round(restingHR + (hrr * 0.5));
                    zone1Upper = Math.round(restingHR + (hrr * 0.6));

                    zone2Lower = Math.round(restingHR + (hrr * 0.6));
                    zone2Upper = Math.round(restingHR + (hrr * 0.7));

                    zone3Lower = Math.round(restingHR + (hrr * 0.7));
                    zone3Upper = Math.round(restingHR + (hrr * 0.8));

                    zone4Lower = Math.round(restingHR + (hrr * 0.8));
                    zone4Upper = Math.round(restingHR + (hrr * 0.9));

                    zone5Lower = Math.round(restingHR + (hrr * 0.9));
                    zone5Upper = maxHR;
                } else {
                    // Sử dụng % trực tiếp của nhịp tim tối đa
                    zone1Lower = Math.round(maxHR * 0.5);
                    zone1Upper = Math.round(maxHR * 0.6);

                    zone2Lower = Math.round(maxHR * 0.6);
                    zone2Upper = Math.round(maxHR * 0.7);

                    zone3Lower = Math.round(maxHR * 0.7);
                    zone3Upper = Math.round(maxHR * 0.8);

                    zone4Lower = Math.round(maxHR * 0.8);
                    zone4Upper = Math.round(maxHR * 0.9);

                    zone5Lower = Math.round(maxHR * 0.9);
                    zone5Upper = maxHR;
                }

                // Cập nhật giao diện
                document.getElementById('maxHR').textContent = maxHR;
                document.getElementById('hrExplanation').textContent = explanation;

                document.getElementById('zone1').textContent = `${zone1Lower}-${zone1Upper} bpm`;
                document.getElementById('zone2').textContent = `${zone2Lower}-${zone2Upper} bpm`;
                document.getElementById('zone3').textContent = `${zone3Lower}-${zone3Upper} bpm`;
                document.getElementById('zone4').textContent = `${zone4Lower}-${zone4Upper} bpm`;
                document.getElementById('zone5').textContent = `${zone5Lower}-${zone5Upper} bpm`;

                document.getElementById('zone1Percent').textContent = "50-60%";
                document.getElementById('zone2Percent').textContent = "60-70%";
                document.getElementById('zone3Percent').textContent = "70-80%";
                document.getElementById('zone4Percent').textContent = "80-90%";
                document.getElementById('zone5Percent').textContent = "90-100%";

                // Cập nhật khuyến nghị dựa trên mức độ tập luyện
                let recommendation;

                if (fitness === 'beginner') {
                    recommendation =
                        "Với người mới bắt đầu, nên tập trung vào vùng 1-2 (50-70%) để xây dựng sức bền cơ bản và thích nghi với tập luyện. Tập 3-4 lần/tuần, mỗi lần 20-30 phút.";
                } else if (fitness === 'intermediate') {
                    recommendation =
                        "Với mức tập luyện trung bình, hãy tập 70-80% thời gian ở vùng 2-3 (60-80%) để cải thiện sức bền tim mạch và đốt mỡ, và 20-30% thời gian ở vùng 4 (80-90%) để cải thiện hiệu suất. Tập 4-5 lần/tuần, 30-45 phút/lần.";
                } else if (fitness === 'advanced') {
                    recommendation =
                        "Với người tập nâng cao, sử dụng phương pháp tập luyện luân phiên vùng từ 2-5 (60-100%) để tối ưu hóa hiệu suất. Tập 5-6 lần/tuần, 45-60 phút/lần, kết hợp với tập HIIT 1-2 lần/tuần.";
                } else if (fitness === 'athlete') {
                    recommendation =
                        "Với vận động viên, tuân theo kế hoạch tập luyện chuyên biệt với sự kết hợp của cả 5 vùng nhịp tim. Chú ý đến thời gian phục hồi và giám sát sự mệt mỏi quá mức. Làm việc với huấn luyện viên để tối ưu hóa chương trình tập luyện.";
                }

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
