<div class="tab-pane" id="statistics">
    <div class="container">
        <ul class="nav nav-tabs custom-nav-tabs mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link custom-tab-link active" data-custom-toggle="custom-tab" href="#post-interaction-tab">📚
                    Bài viết</a>
            </li>
            <li class="nav-item">
                <a class="nav-link custom-tab-link" data-custom-toggle="custom-tab" href="#appointment-tab">🗓️ Lịch
                    khám</a>
            </li>
            <li class="nav-item">
                <a class="nav-link custom-tab-link" data-custom-toggle="custom-tab" href="#product-tab">🛒 Sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link custom-tab-link" data-custom-toggle="custom-tab" href="#overview-tab">📊 Tổng
                    quan</a>
            </li>
        </ul>

        <div class="custom-tab-content">
            <!-- THỐNG KÊ BÀI VIẾT -->
            <div class="custom-tab-pane active" id="post-interaction-tab">
                <div class="container-fluid py-4">
                    <!-- Phần tổng quan - KPI Cards -->
                    <div class="row mb-4">
                        <div class="col-xl col-md-6 mb-4">
                            <div class="card h-100 border-0 py-2 shadow">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="bg-primary bg-gradient rounded-circle p-3 text-white">
                                                <i class="fas fa-file-alt fa-fw"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-bold text-uppercase mb-1 text-xs">Tổng số bài viết
                                            </div>
                                            <div class="h4 font-weight-bold mb-0" id="totalPosts">...</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl col-md-6 mb-4">
                            <div class="card h-100 border-0 py-2 shadow">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="bg-success bg-gradient rounded-circle p-3 text-white">
                                                <i class="fas fa-eye fa-fw"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-bold text-uppercase mb-1 text-xs">Tổng lượt xem
                                            </div>
                                            <div class="h4 font-weight-bold mb-0" id="totalViews">...</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl col-md-6 mb-4">
                            <div class="card h-100 border-0 py-2 shadow">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="bg-info bg-gradient rounded-circle p-3 text-white">
                                                <i class="fas fa-thumbs-up fa-fw"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-bold text-uppercase mb-1 text-xs">Tổng lượt thích
                                            </div>
                                            <div class="h4 font-weight-bold mb-0" id="totalLikes">...</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl col-md-6 mb-4">
                            <div class="card h-100 border-0 py-2 shadow">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="bg-warning bg-gradient rounded-circle p-3 text-white">
                                                <i class="fas fa-comments fa-fw"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-bold text-uppercase mb-1 text-xs">Tổng bình luận
                                            </div>
                                            <div class="h4 font-weight-bold mb-0" id="totalComments">...</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl col-md-6 mb-4">
                            <div class="card h-100 border-0 py-2 shadow">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="bg-danger bg-gradient rounded-circle p-3 text-white">
                                                <i class="fas fa-chart-line fa-fw"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-bold text-uppercase mb-1 text-xs">Tỷ lệ tương tác
                                                (ER)</div>
                                            <div class="h4 font-weight-bold mb-0" id="avgER">...</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Biểu đồ Trend và Phân phối danh mục -->
                    <div class="row mb-4">
                        <!-- Biểu đồ xu hướng -->
                        <div class="col-lg-8 mb-4">
                            <div class="card border-0 shadow">
                                <div
                                    class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                                    <h6 class="font-weight-bold text-primary m-0">
                                        <i class="fas fa-chart-line mr-2"></i> Xu hướng tương tác theo thời gian
                                    </h6>
                                    <div class="dropdown">
                                        <select id="trendRange" class="form-select form-select-sm bg-light border-0">
                                            <option value="month">Theo tháng</option>
                                            <option value="week">Theo tuần</option>
                                            <option value="day">Theo ngày</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="trendChart" style="height: 320px;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Phân phối danh mục -->
                        <div class="col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-header bg-white py-3">
                                    <h6 class="font-weight-bold text-primary m-0">
                                        <i class="fas fa-chart-pie mr-2"></i> Phân phối theo danh mục
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="categoryDistributionChart" style="height: 320px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Top bài viết (Dòng riêng) -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-0 shadow">
                                <div class="card-header bg-white py-3">
                                    <h6 class="font-weight-bold text-primary m-0">
                                        <i class="fas fa-trophy mr-2"></i> Top 5 bài viết hiệu suất cao
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="topPostsChart" style="height: 300px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bảng chi tiết (Dòng riêng) -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card border-0 shadow">
                                <div
                                    class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                                    <h6 class="font-weight-bold text-primary m-0">
                                        <i class="fas fa-table mr-2"></i> Chi tiết bài viết
                                    </h6>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <select id="postCategory" class="form-select form-select-sm">
                                                <option value="">Tất cả danh mục</option>
                                                <option value="tin-tuc">Tin tức</option>
                                                <option value="kien-thuc">Kiến thức</option>
                                                <option value="huong-dan">Hướng dẫn</option>
                                            </select>
                                        </div>
                                        <div>
                                            <input type="text" class="form-control form-control-sm"
                                                placeholder="Tìm kiếm..." id="postSearch">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table-hover mb-0 table" id="postDetailTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="px-3">#</th>
                                                    <th>Tiêu đề</th>
                                                    <th class="text-center">Lượt xem</th>
                                                    <th class="text-center">Likes</th>
                                                    <th class="text-center">Comments</th>
                                                    <th class="text-center">ER</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td colspan="6" class="py-3 text-center">Đang tải dữ liệu...
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between align-items-center bg-white">
                                    <div class="text-muted small">Hiển thị <span id="showingRecords">0-0</span> của
                                        <span id="totalRecords">0</span> bài viết
                                    </div>
                                    <div class="pagination-controls">
                                        <button class="btn btn-sm btn-outline-primary me-2">Trang trước</button>
                                        <button class="btn btn-sm btn-outline-primary">Trang sau</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- THỐNG KÊ LỊCH KHÁM -->
            <div class="custom-tab-pane" id="appointment-tab">
                <!-- KPI Cards and Charts content here - keeping same structure -->
                <div class="container-fluid py-4">
                    <div class="row mb-4">
                        <div class="col">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center text-white"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <div class="ms-3">
                                            <div class="text-muted text-uppercase fw-bold text-xs">Tổng số lịch khám
                                            </div>
                                            <div class="h3 fw-bold mb-0" id="totalAppointments">...</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- More KPI cards... -->
                    </div>
                    <!-- Charts content... -->
                </div>
            </div>

            <!-- THỐNG KÊ SẢN PHẨM -->
            <div class="custom-tab-pane" id="product-tab">
                <div class="card mb-4">
                    <div class="card-header"><strong>Hiệu suất các chiến dịch tiếp thị</strong></div>
                    <div class="card-body d-flex justify-content-center">
                        <div style="max-width: 700px; width: 100%">
                            <canvas id="chartCampaignPerformance"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- DASHBOARD TỔNG QUAN -->
            <div class="custom-tab-pane" id="overview-tab">
                <div class="card mb-4">
                    <div class="card-header"><strong>KPI tổng quan</strong></div>
                    <div class="card-body">
                        <ul>
                            <li>Tổng bài viết: <strong>45</strong></li>
                            <li>Tổng lượt khám: <strong>120</strong></li>
                            <li>Tổng sản phẩm tiếp thị: <strong>8</strong></li>
                            <li>ROI: <strong>210%</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom tabs styling */
        .custom-nav-tabs .nav-link {
            color: #6c757d;
            border: 1px solid transparent;
            border-radius: 0.375rem 0.375rem 0 0;
            padding: 0.75rem 1rem;
            transition: all 0.15s ease-in-out;
        }

        .custom-nav-tabs .nav-link:hover {
            border-color: #e9ecef #e9ecef #dee2e6;
            background-color: #f8f9fa;
        }

        .custom-nav-tabs .nav-link.active {
            color: #495057;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
        }

        .custom-tab-content {
            border: 1px solid #dee2e6;
            border-radius: 0 0.375rem 0.375rem 0.375rem;
            background-color: #fff;
            padding: 1rem;
        }

        .custom-tab-pane {
            display: none;
        }

        .custom-tab-pane.active {
            display: block;
        }

        /* Force tab display */
        #statistics.tab-pane {
            display: block !important;
        }
    </style>

    <script>
        // Custom tabs navigation for statistics
        document.addEventListener('DOMContentLoaded', function() {
            const customTabLinks = document.querySelectorAll('.custom-tab-link');
            const customTabPanes = document.querySelectorAll('.custom-tab-pane');

            customTabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = this.getAttribute('href');

                    // Remove active from all custom tab links
                    customTabLinks.forEach(l => l.classList.remove('active'));
                    // Remove active from all custom tab panes
                    customTabPanes.forEach(p => p.classList.remove('active'));

                    // Add active to clicked link
                    this.classList.add('active');

                    // Show target pane
                    const targetPane = document.querySelector(target);
                    if (targetPane) {
                        targetPane.classList.add('active');
                    }

                    console.log('Custom tab clicked:', target);
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</div>

<script src="/js/doctor-statistic.js"></script>
