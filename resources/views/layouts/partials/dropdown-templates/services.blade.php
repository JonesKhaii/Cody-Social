<template id="dropdown-template-services">
    <div class="row py-4">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="category-item-container">
                        <div class="d-flex align-items-center mb-2">
                            <div class="category-image me-2">
                                <img src="{{ asset('asset/images/category/robot.webp') }}"
                                    class="img-fluid category-thumbnail" alt="Phẫu thuật và Thủ thuật">
                            </div>
                            <h6 class="category-title has-subcategories mb-0">
                                <a href="/treatment/phau-thuat-thu-thuat" class="category-link">Phẫu thuật
                                    và Thủ thuật tiên tiến</a>
                                <span class="subcategory-toggle ms-1">
                                    <i class="fas fa-chevron-down small-icon"></i>
                                </span>
                            </h6>
                        </div>

                        <div class="subcategories ms-4" style="display: none;">
                            <a href="/treatment/phau-thuat-robot" class="subcategory-link d-block mb-1">
                                Phẫu thuật Robot
                            </a>
                            <a href="/treatment/phau-thuat-noi-soi" class="subcategory-link d-block mb-1">
                                Phẫu thuật nội soi 3D/4K
                            </a>
                            <a href="/treatment/phau-thuat-laser" class="subcategory-link d-block mb-1">
                                Ứng dụng Laser trong phẫu thuật
                            </a>
                            <a href="/treatment/phau-thuat-thu-thuat" class="category-view-all mt-2">
                                Xem tất cả <i class="fas fa-angle-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="category-item-container">
                        <div class="d-flex align-items-center mb-2">
                            <div class="category-image me-2">
                                <img src="{{ asset('asset/images/category/DSA.png') }}"
                                    class="img-fluid category-thumbnail" alt="Chẩn đoán hình ảnh">
                            </div>
                            <h6 class="category-title has-subcategories mb-0">
                                <a href="/treatment/chan-doan-hinh-anh" class="category-link">Chẩn đoán
                                    hình ảnh công nghệ cao</a>
                                <span class="subcategory-toggle ms-1">
                                    <i class="fas fa-chevron-down small-icon"></i>
                                </span>
                            </h6>
                        </div>

                        <div class="subcategories ms-4" style="display: none;">
                            <a href="/treatment/pet-ct" class="subcategory-link d-block mb-1">
                                PET/CT - Chẩn đoán ung thư sớm
                            </a>
                            <a href="/treatment/mri-3tesla" class="subcategory-link d-block mb-1">
                                MRI 3 Tesla
                            </a>
                            <a href="/treatment/ai-radiology" class="subcategory-link d-block mb-1">
                                AI trong đọc và phân tích hình ảnh
                            </a>
                            <a href="/treatment/chan-doan-hinh-anh" class="category-view-all mt-2">
                                Xem tất cả <i class="fas fa-angle-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="category-item-container">
                        <div class="d-flex align-items-center mb-2">
                            <div class="category-image me-2">
                                <img src="{{ asset('asset/images/category/genetics.png') }}"
                                    class="img-fluid category-thumbnail" alt="Y học tái tạo">
                            </div>
                            <h6 class="category-title has-subcategories mb-0">
                                <a href="/treatment/y-hoc-tai-tao" class="category-link">Y học tái tạo và
                                    điều trị tế bào</a>
                                <span class="subcategory-toggle ms-1">
                                    <i class="fas fa-chevron-down small-icon"></i>
                                </span>
                            </h6>
                        </div>

                        <div class="subcategories ms-4" style="display: none;">
                            <a href="/treatment/te-bao-goc" class="subcategory-link d-block mb-1">
                                Liệu pháp tế bào gốc
                            </a>
                            <a href="/treatment/mien-dich-tri-lieu" class="subcategory-link d-block mb-1">
                                Miễn dịch trị liệu (Immunotherapy)
                            </a>
                            <a href="/treatment/cong-nghe-gen" class="subcategory-link d-block mb-1">
                                Chỉnh sửa gen (CRISPR)
                            </a>
                            <a href="/treatment/y-hoc-tai-tao" class="category-view-all mt-2">
                                Xem tất cả <i class="fas fa-angle-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Digital Healthcare -->
                <div class="col-md-6 mb-3">
                    <div class="category-item-container">
                        <div class="d-flex align-items-center mb-2">
                            <div class="category-image me-2">
                                <img src="{{ asset('asset/images/category/telehealth.png') }}"
                                    class="img-fluid category-thumbnail" alt="Digital Healthcare">
                            </div>
                            <h6 class="category-title has-subcategories mb-0">
                                <a href="/treatment/digital-healthcare" class="category-link">Digital
                                    Healthcare</a>
                                <span class="subcategory-toggle ms-1">
                                    <i class="fas fa-chevron-down small-icon"></i>
                                </span>
                            </h6>
                        </div>

                        <div class="subcategories ms-4" style="display: none;">
                            <a href="/treatment/telemedicine" class="subcategory-link d-block mb-1">
                                Telemedicine - Khám bệnh từ xa
                            </a>
                            <a href="/treatment/ai-diagnosis" class="subcategory-link d-block mb-1">
                                AI trong chẩn đoán bệnh
                            </a>
                            <a href="/treatment/health-monitoring" class="subcategory-link d-block mb-1">
                                Giám sát sức khỏe từ xa
                            </a>
                            <a href="/treatment/digital-healthcare" class="category-view-all mt-2">
                                Xem tất cả <i class="fas fa-angle-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="category-item-container">
                        <div class="d-flex align-items-center mb-2">
                            <div class="category-image me-2">
                                <img src="{{ asset('asset/images/category/ministry.webp') }}"
                                    class="img-fluid category-thumbnail" alt="Y học hiện đại">
                            </div>
                            <h6 class="category-title mb-0">
                                <a href="/specialties/y-hoc-hien-dai"
                                    class="category-link">Y học hiện đại</a>
                            </h6>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="category-item-container">
                        <div class="d-flex align-items-center mb-2">
                            <div class="category-image me-2">
                                <img src="{{ asset('asset/images/category/y-hoc-co-truyen.png') }}"
                                    class="img-fluid category-thumbnail" alt="Y học cổ truyền">
                            </div>
                            <h6 class="category-title mb-0">
                                <a href="forum/post/category/bai-thuoc-y-hoc-co-truyen"
                                    class="category-link">Y học cổ truyền</a>
                            </h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Kỹ thuật nổi bật và đăng ký tư vấn -->
        <div class="col-md-4">
            <h6 class="dropdown-header">Phương pháp điều trị nổi bật</h6>
            <div class="dropdown-divider"></div>

            <div class="featured-technique mb-3">
                <div class="technique-item border-bottom p-2">
                    <div class="technique-title fw-bold mb-1">Da Vinci Robot - Phẫu thuật hiện đại</div>
                    <p class="technique-desc small mb-0">Phẫu thuật Robot với độ chính xác cao, giảm đau và
                        thời gian hồi phục nhanh</p>
                </div>
                <div class="technique-item border-bottom p-2">
                    <div class="technique-title fw-bold mb-1">CAR-T Cell Therapy</div>
                    <p class="technique-desc small mb-0">Liệu pháp tế bào điều trị ung thư tiên tiến nhất
                        hiện nay</p>
                </div>
                <div class="technique-item p-2">
                    <div class="technique-title fw-bold mb-1">Phát hiện sớm Alzheimer qua AI</div>
                    <p class="technique-desc small mb-0">Công nghệ AI giúp chẩn đoán sớm bệnh Alzheimer
                        trước 5-10 năm</p>
                </div>
            </div>

            <div class="view-all-link mt-4">
                <div class="card bg-light border-0">
                    <div class="card-body p-3">
                        <h6 class="card-title text-primary">Tìm hiểu thêm</h6>
                        <p class="card-text small">Khám phá tất cả các phương pháp điều trị tiên tiến</p>
                        <a href="{{ route('treatment.index') }}" class="btn btn-primary btn-sm">Xem tất cả</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
