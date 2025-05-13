<template id="dropdown-template-doctor-specialties">
    <div class="row py-4">
        <!-- Cột các danh mục chuyên môn bác sĩ -->
        <div class="col-md-8">
            <div class="row">
                <!-- Danh mục Lịch sự kiện chuyên môn -->
                <div class="col-md-6 mb-3">
                    <div class="category-item-container">
                        <div class="d-flex align-items-center mb-2">
                            <div class="category-icon me-2">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h6 class="category-title has-subcategories mb-0">
                                <a href="/specialties/lich-su-kien-chuyen-mon" class="category-link">Lịch
                                    sự kiện chuyên môn</a>
                                <span class="subcategory-toggle ms-1">
                                    <i class="fas fa-chevron-down small-icon"></i>
                                </span>
                            </h6>
                        </div>

                        <div class="subcategories ms-4" style="display: none;">
                            <a href="/specialties/hoi-thao-dao-tao" class="subcategory-link d-block mb-1">
                                Hội thảo, đào tạo
                            </a>
                            <a href="/specialties/workshop-noi-bo" class="subcategory-link d-block mb-1">
                                Workshop nội bộ
                            </a>

                            <a href="/specialties/lich-su-kien-chuyen-mon" class="category-view-all mt-2">
                                Xem tất cả <i class="fas fa-angle-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Danh mục Câu chuyện nghề y -->
                <div class="col-md-6 mb-3">
                    <div class="category-item-container">
                        <div class="d-flex align-items-center mb-2">
                            <div class="category-icon me-2">
                                <i class="fas fa-book-medical"></i>
                            </div>
                            <h6 class="category-title has-subcategories mb-0">
                                <a href="/specialties/cau-chuyen-nghe-y" class="category-link">Câu chuyện
                                    nghề y</a>
                                <span class="subcategory-toggle ms-1">
                                    <i class="fas fa-chevron-down small-icon"></i>
                                </span>
                            </h6>
                        </div>

                        <div class="subcategories ms-4" style="display: none;">
                            <a href="/specialties/nhat-ky-hanh-nghe"
                                class="subcategory-link d-block mb-1">
                                Nhật ký hành nghề
                            </a>
                            <a href="/specialties/trai-nghiem-thuc-te"
                                class="subcategory-link d-block mb-1">
                                Trải nghiệm thực tế
                            </a>
                            <a href="/specialties/goc-nhin-ca-nhan" class="subcategory-link d-block mb-1">
                                Góc nhìn cá nhân về điều trị – y đức
                            </a>

                            <a href="/specialties/cau-chuyen-nghe-y" class="category-view-all mt-2">
                                Xem tất cả <i class="fas fa-angle-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Danh mục Thành tựu & nghiên cứu -->
                <div class="col-md-6 mb-3">
                    <div class="category-item-container">
                        <div class="d-flex align-items-center mb-2">
                            <div class="category-icon me-2">
                                <i class="fas fa-microscope"></i>
                            </div>
                            <h6 class="category-title has-subcategories mb-0">
                                <a href="/specialties/thanh-tuu-nghien-cuu" class="category-link">Thành
                                    tựu & nghiên cứu</a>
                                <span class="subcategory-toggle ms-1">
                                    <i class="fas fa-chevron-down small-icon"></i>
                                </span>
                            </h6>
                        </div>

                        <div class="subcategories ms-4" style="display: none;">
                            <a href="/specialties/cong-trinh-nghien-cuu-y-hoc"
                                class="subcategory-link d-block mb-1">
                                Công trình nghiên cứu y học
                            </a>
                            <a href="/specialties/bao-cao-ca-lam-sang"
                                class="subcategory-link d-block mb-1">
                                Báo cáo ca lâm sàng đặc biệt
                            </a>

                            <a href="/specialties/thanh-tuu-nghien-cuu" class="category-view-all mt-2">
                                Xem tất cả <i class="fas fa-angle-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Danh mục Video chia sẻ chuyên môn -->
                <div class="col-md-6 mb-3">
                    <div class="category-item-container">
                        <div class="d-flex align-items-center mb-2">
                            <div class="category-icon me-2">
                                <i class="fas fa-video"></i>
                            </div>
                            <h6 class="category-title mb-0">
                                <a href="/specialties/video-chia-se-chuyen-mon"
                                    class="category-link">Video chia sẻ chuyên môn</a>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cột thông tin bổ sung -->
        <div class="col-md-4">
            <div class="dropdown-image-container">
                <img src="https://images.unsplash.com/photo-1651008376811-b90baee60c1f?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    alt="Chuyên môn bác sĩ" class="dropdown-image">
                <div class="dropdown-cta">
                    <p>Khám phá và nâng cao kiến thức chuyên môn trong lĩnh vực y tế</p>
                    <a href="/specialties" class="btn btn-primary btn-sm">Xem tất cả chuyên môn</a>
                </div>
            </div>
        </div>
    </div>
</template>
