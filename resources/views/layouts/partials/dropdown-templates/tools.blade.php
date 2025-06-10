<template id="dropdown-template-tools">
    <div class="row py-4">
        <!-- Cột bên trái: Các công cụ đo lường sức khỏe -->
        <div class="col-md-8">
            <div class="row">
                <!-- Chỉ số cơ thể -->
                <div class="col-md-6 mb-4">
                    <div class="tools-category">
                        <h6 class="tools-category-title mb-3">
                            <i class="fas fa-weight me-2"></i>Chỉ số cơ thể
                        </h6>
                        <div class="tools-list">
                            <a href="{{ route('tools.bmi') }}"
                                class="tool-item d-flex align-items-center mb-2">
                                <div class="tool-icon-container me-2">
                                    <div class="tool-icon">
                                        <i class="fas fa-calculator"></i>
                                    </div>
                                </div>
                                <div class="tool-info">
                                    <div class="tool-name">Tính chỉ số BMI</div>
                                    <small class="tool-description text-muted">Đánh giá cân nặng dựa trên
                                        chiều cao</small>
                                </div>
                            </a>
                            <a href="{{ route('tools.body-fat') }}"
                                class="tool-item d-flex align-items-center mb-2">
                                <div class="tool-icon-container me-2">
                                    <div class="tool-icon">
                                        <i class="fas fa-percentage"></i>
                                    </div>
                                </div>
                                <div class="tool-info">
                                    <div class="tool-name">Tính tỷ lệ mỡ cơ thể</div>
                                    <small class="tool-description text-muted">Ước tính phần trăm mỡ trong
                                        cơ thể</small>
                                </div>
                            </a>
                            <a href="{{ route('tools.bmr') }}"
                                class="tool-item d-flex align-items-center mb-2">
                                <div class="tool-icon-container me-2">
                                    <div class="tool-icon">
                                        <i class="fas fa-fire"></i>
                                    </div>
                                </div>
                                <div class="tool-info">
                                    <div class="tool-name">Tính BMR và TDEE</div>
                                    <small class="tool-description text-muted">Tỷ lệ trao đổi chất và nhu
                                        cầu năng lượng</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Sức khỏe tim mạch -->
                <div class="col-md-6 mb-4">
                    <div class="tools-category">
                        <h6 class="tools-category-title mb-3">
                            <i class="fas fa-heartbeat me-2"></i>Sức khỏe tim mạch
                        </h6>
                        <div class="tools-list">
                            <a href="{{ route('tools.blood-pressure') }}"
                                class="tool-item d-flex align-items-center mb-2">
                                <div class="tool-icon-container me-2">
                                    <div class="tool-icon">
                                        <i class="fas fa-stethoscope"></i>
                                    </div>
                                </div>
                                <div class="tool-info">
                                    <div class="tool-name">Đánh giá huyết áp</div>
                                    <small class="tool-description text-muted">Phân loại mức độ huyết áp và
                                        đề xuất</small>
                                </div>
                            </a>
                            <a href="{{ route('tools.heart-risk') }}"
                                class="tool-item d-flex align-items-center mb-2">
                                <div class="tool-icon-container me-2">
                                    <div class="tool-icon">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                </div>
                                <div class="tool-info">
                                    <div class="tool-name">Nguy cơ tim mạch</div>
                                    <small class="tool-description text-muted">Đánh giá nguy cơ bệnh tim
                                        mạch 10 năm</small>
                                </div>
                            </a>
                            <a href="{{ route('tools.heart-rate-zones') }}"
                                class="tool-item d-flex align-items-center mb-2">
                                <div class="tool-icon-container me-2">
                                    <div class="tool-icon">
                                        <i class="fas fa-running"></i>
                                    </div>
                                </div>
                                <div class="tool-info">
                                    <div class="tool-name">Vùng nhịp tim tập luyện</div>
                                    <small class="tool-description text-muted">Tính vùng nhịp tim hiệu quả
                                        khi tập thể dục</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Dinh dưỡng -->
                <div class="col-md-6 mb-4">
                    <div class="tools-category">
                        <h6 class="tools-category-title mb-3">
                            <i class="fas fa-apple-alt me-2"></i>Dinh dưỡng
                        </h6>
                        <div class="tools-list">
                            <a href="{{ route('tools.calorie-needs') }}"
                                class="tool-item d-flex align-items-center mb-2">
                                <div class="tool-icon-container me-2">
                                    <div class="tool-icon">
                                        <i class="fas fa-utensils"></i>
                                    </div>
                                </div>
                                <div class="tool-info">
                                    <div class="tool-name">Nhu cầu calo</div>
                                    <small class="tool-description text-muted">Tính lượng calo cần thiết
                                        hàng ngày</small>
                                </div>
                            </a>
                            <a href="{{ route('tools.water-intake') }}"
                                class="tool-item d-flex align-items-center mb-2">
                                <div class="tool-icon-container me-2">
                                    <div class="tool-icon">
                                        <i class="fas fa-tint"></i>
                                    </div>
                                </div>
                                <div class="tool-info">
                                    <div class="tool-name">Lượng nước cần uống</div>
                                    <small class="tool-description text-muted">Tính nhu cầu nước theo cân
                                        nặng và hoạt động</small>
                                </div>
                            </a>
                            <a href="{{ route('tools.macro-calculator') }}"
                                class="tool-item d-flex align-items-center mb-2">
                                <div class="tool-icon-container me-2">
                                    <div class="tool-icon">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                                <div class="tool-info">
                                    <div class="tool-name">Tính Macros</div>
                                    <small class="tool-description text-muted">Phân bổ protein, carbs và
                                        chất béo</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Công cụ chuyên khoa -->
                <div class="col-md-6 mb-4">
                    <div class="tools-category">
                        <h6 class="tools-category-title mb-3">
                            <i class="fas fa-notes-medical me-2"></i>Công cụ chuyên khoa
                        </h6>
                        <div class="tools-list">
                            <a href="{{ route('tools.pregnancy-calculator') }}"
                                class="tool-item d-flex align-items-center mb-2">
                                <div class="tool-icon-container me-2">
                                    <div class="tool-icon">
                                        <i class="fas fa-baby"></i>
                                    </div>
                                </div>
                                <div class="tool-info">
                                    <div class="tool-name">Tính ngày dự sinh</div>
                                    <small class="tool-description text-muted">Tính ngày sinh và các mốc
                                        thai kỳ</small>
                                </div>
                            </a>
                            <a href="{{ route('tools.diabetes-risk') }}"
                                class="tool-item d-flex align-items-center mb-2">
                                <div class="tool-icon-container me-2">
                                    <div class="tool-icon">
                                        <i class="fas fa-syringe"></i>
                                    </div>
                                </div>
                                <div class="tool-info">
                                    <div class="tool-name">Đánh giá nguy cơ tiểu đường</div>
                                    <small class="tool-description text-muted">Kiểm tra nguy cơ mắc tiểu
                                        đường type 2</small>
                                </div>
                            </a>
                            <a href="{{ route('tools.sleep-calculator') }}"
                                class="tool-item d-flex align-items-center mb-2">
                                <div class="tool-icon-container me-2">
                                    <div class="tool-icon">
                                        <i class="fas fa-bed"></i>
                                    </div>
                                </div>
                                <div class="tool-info">
                                    <div class="tool-name">Tính thời gian ngủ tối ưu</div>
                                    <small class="tool-description text-muted">Tính giờ đi ngủ phù hợp theo
                                        chu kỳ</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="dropdown-image-container h-100">
                <img src="{{ asset('images/dropdown/doctor-specialties.jpg') }}"
                    alt="Chuyên môn bác sĩ"
                    class="dropdown-image"
                    width="400" height="300"
                    loading="lazy">
                <div class="dropdown-cta">
                    <h6 class="text-primary">Theo dõi sức khỏe của bạn</h6>
                    <p>Sử dụng các công cụ sức khỏe miễn phí để đánh giá và theo dõi sức khỏe mỗi ngày</p>
                    <a href="{{ route('tools.index') }}" class="btn btn-primary btn-sm">Xem tất cả công cụ</a>
                </div>
            </div>
        </div>
    </div>
</template>
