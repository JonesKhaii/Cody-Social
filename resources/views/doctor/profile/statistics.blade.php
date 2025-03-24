<div class="tab-pane fade show active" id="statistics">
    <div class="container mt-4">
        <!-- Tabs con -->
        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#post-interaction-tab">📚 Bài viết</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#appointment-tab">🗓️ Lịch khám</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#product-tab">🛒 Sản phẩm</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#overview-tab">📊 Tổng quan</a>
            </li>
        </ul>

        <div class="tab-content">
            <!-- THỐNG KÊ BÀI VIẾT -->
            <div class="tab-pane fade show active" id="post-interaction-tab">
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
            {{-- <div class="tab-pane fade" id="appointment-tab">
                <div class="card mb-4">
                    <div class="card-header"><strong>Biểu đồ nhiệt lịch khám</strong></div>
                    <div class="card-body text-center">
                        <p>[Heatmap giả lập - cần thư viện hoặc custom plugin nếu muốn hiển thị thực tế]</p>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><strong>Tỷ lệ đặt lịch thành công</strong></div>
                    <div class="card-body d-flex justify-content-center">
                        <div style="max-width: 700px; width: 100%">
                            <canvas id="chartBookingRate"></canvas>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><strong>Dịch vụ khám được đặt nhiều nhất</strong></div>
                    <div class="card-body d-flex justify-content-center">
                        <div style="max-width: 600px; width: 100%">
                            <canvas id="chartTopServices"></canvas>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="tab-pane fade" id="appointment-tab">
                <div class="container-fluid py-4">
                    <!-- Phần tổng quan - KPI Cards -->
                    <div class="row mb-4">
                        {{-- <div class="col-xl col-md-6 mb-4">
                            <div class="card h-100 border-0 py-2 shadow">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="bg-primary bg-gradient rounded-circle p-3 text-white">
                                                <i class="fas fa-calendar-alt fa-fw"></i>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="font-weight-bold text-uppercase mb-1 text-xs">Tổng số lịch khám
                                            </div>
                                            <div class="h4 font-weight-bold mb-0" id="totalAppointments">...</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        <!-- Phần tổng quan - KPI Cards -->
                        <div class="row mb-4">
                            <div class="col mb-3">
                                <div class="card h-100 border-0 shadow">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-warning d-flex align-items-center justify-content-center text-white"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-calendar-alt"></i>
                                            </div>
                                            <div class="ms-3">
                                                <div class="text-muted text-uppercase fw-bold text-xs">Tổng số lịch
                                                    khám</div>
                                                <div class="h3 fw-bold mb-0" id="totalAppointments">...</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-3">
                                <div class="card h-100 border-0 shadow">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-calendar-check"></i>
                                            </div>
                                            <div class="ms-3">
                                                <div class="text-muted text-uppercase fw-bold text-xs">Chờ duyệt</div>
                                                <div class="h3 fw-bold mb-0" id="pendingAppointments">...</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col mb-3">
                                <div class="card h-100 border-0 shadow">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-success d-flex align-items-center justify-content-center text-white"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-calendar-day"></i>
                                            </div>
                                            <div class="ms-3">
                                                <div class="text-muted text-uppercase fw-bold text-xs">Sắp tới</div>
                                                <div class="h3 fw-bold mb-0" id="upcomingAppointments">...</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col mb-3">
                                <div class="card h-100 border-0 shadow">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-info d-flex align-items-center justify-content-center text-white"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-check-circle"></i>
                                            </div>
                                            <div class="ms-3">
                                                <div class="text-muted text-uppercase fw-bold text-xs">Hoàn thành</div>
                                                <div class="h3 fw-bold mb-0" id="completedAppointments">...</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col mb-3">
                                <div class="card h-100 border-0 shadow">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-danger d-flex align-items-center justify-content-center text-white"
                                                style="width: 50px; height: 50px;">
                                                <i class="fas fa-calendar-times"></i>
                                            </div>
                                            <div class="ms-3">
                                                <div class="text-muted text-uppercase fw-bold text-xs">Đã Huỷ</div>
                                                <div class="h3 fw-bold mb-0" id="cancelledAppointments">...</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <!-- Biểu đồ xu hướng -->
                    <div class="row mb-4">
                        <div class="col-lg-8 mb-4">
                            <div class="card border-0 shadow">
                                <div
                                    class="card-header d-flex justify-content-between align-items-center bg-white py-3">
                                    <h6 class="font-weight-bold text-primary m-0">
                                        <i class="fas fa-calendar-check mr-2"></i> Xu hướng lịch khám theo thời gian
                                    </h6>
                                    <div class="dropdown">
                                        <select id="appointmentTrendRange"
                                            class="form-select form-select-sm bg-light border-0">
                                            <option value="month">Theo tháng</option>
                                            <option value="week">Theo tuần</option>
                                            <option value="day">Theo ngày</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="appointmentTrendChart" style="height: 320px;"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Biểu đồ tròn phân bổ tỷ lệ hình thức khám -->
                        <div class="col-lg-4 mb-4">
                            <div class="card h-100 border-0 shadow">
                                <div class="card-header bg-white py-3">
                                    <h6 class="font-weight-bold text-primary m-0">
                                        <i class="fas fa-chart-pie mr-2"></i> Phân bổ hình thức khám
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="appointmentTypeDistributionChart" style="height: 320px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Biểu đồ cột so sánh tỷ lệ lịch khám -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card border-0 shadow">
                                <div class="card-header bg-white py-3">
                                    <h6 class="font-weight-bold text-primary m-0">
                                        <i class="fas fa-chart-bar mr-2"></i> So sánh tỷ lệ lịch khám
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div id="appointmentComparisonChart" style="height: 320px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- THỐNG KÊ SẢN PHẨM -->
            <div class="tab-pane fade" id="product-tab">
                <div class="card mb-4">
                    <div class="card-header"><strong>Hiệu suất các chiến dịch tiếp thị</strong></div>
                    <div class="card-body d-flex justify-content-center">
                        <div style="max-width: 700px; width: 100%">
                            <canvas id="chartCampaignPerformance"></canvas>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><strong>Tỷ lệ chuyển đổi theo thời gian</strong></div>
                    <div class="card-body d-flex justify-content-center">
                        <div style="max-width: 700px; width: 100%">
                            <canvas id="chartConversionRate"></canvas>
                        </div>
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header"><strong>Phễu chuyển đổi khách hàng</strong></div>
                    <div class="card-body text-center">
                        <p>[Funnel chart mô phỏng - có thể dùng chart.js plugin hoặc ảnh minh họa]</p>
                    </div>
                </div>
            </div>

            <!-- DASHBOARD TỔNG QUAN -->
            <div class="tab-pane fade" id="overview-tab">
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

                <div class="card mb-4">
                    <div class="card-header"><strong>So sánh bài viết và lịch hẹn</strong></div>
                    <div class="card-body d-flex justify-content-center">
                        <div style="max-width: 700px; width: 100%">
                            <canvas id="chartComparePostAppointment"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script>
        // Các biểu đồ bài viết (đã có)
        const chartPostInteraction = new Chart(document.getElementById('chartPostInteraction'), {
            type: 'bar',
            data: {
                labels: ['Bài viết A', 'Bài viết B', 'Bài viết C'],
                datasets: [{
                        label: 'Lượt xem',
                        backgroundColor: '#2196f3',
                        data: [1200, 980, 860]
                    },
                    {
                        label: 'Lượt thích',
                        backgroundColor: '#4caf50',
                        data: [320, 280, 150]
                    },
                    {
                        label: 'Bình luận',
                        backgroundColor: '#ffc107',
                        data: [54, 67, 23]
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tổng hợp tương tác bài viết'
                    }
                }
            }
        });

        const chartPostTrend = new Chart(document.getElementById('chartPostTrend'), {
            type: 'line',
            data: {
                labels: ['Tuần 1', 'Tuần 2', 'Tuần 3', 'Tuần 4'],
                datasets: [{
                        label: 'Lượt xem',
                        data: [300, 450, 500, 600],
                        borderColor: '#2196f3',
                        fill: false
                    },
                    {
                        label: 'Lượt thích',
                        data: [120, 150, 200, 250],
                        borderColor: '#4caf50',
                        fill: false
                    },
                    {
                        label: 'Bình luận',
                        data: [20, 40, 35, 50],
                        borderColor: '#ffc107',
                        fill: false
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Xu hướng tương tác theo thời gian'
                    }
                }
            }
        });

        const chartEngagementRate = new Chart(document.getElementById('chartEngagementRate'), {
            type: 'pie',
            data: {
                labels: ['Like/View', 'Comment/View'],
                datasets: [{
                    data: [25, 10],
                    backgroundColor: ['#4caf50', '#ffc107']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tỷ lệ chuyển đổi tương tác'
                    }
                }
            }
        });

        const chartSentiment = new Chart(document.getElementById('chartSentiment'), {
            type: 'doughnut',
            data: {
                labels: ['Tích cực', 'Tiêu cực', 'Trung lập'],
                datasets: [{
                    data: [60, 20, 20],
                    backgroundColor: ['#4caf50', '#f44336', '#9e9e9e']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Cảm xúc trong bình luận'
                    }
                }
            }
        });

        // Biểu đồ lịch khám
        const chartBookingRate = new Chart(document.getElementById('chartBookingRate'), {
            type: 'line',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4'],
                datasets: [{
                    label: 'Tỷ lệ đặt lịch thành công (%)',
                    data: [72, 81, 75, 88],
                    borderColor: '#673ab7',
                    fill: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tỷ lệ đặt lịch theo thời gian'
                    }
                }
            }
        });

        const chartTopServices = new Chart(document.getElementById('chartTopServices'), {
            type: 'bar',
            data: {
                labels: ['Khám nội tổng quát', 'Xét nghiệm máu', 'Khám da liễu'],
                datasets: [{
                    label: 'Số lượt đặt',
                    data: [120, 90, 60],
                    backgroundColor: ['#03a9f4', '#00bcd4', '#009688']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Dịch vụ khám được đặt nhiều nhất'
                    }
                }
            }
        });

        // Biểu đồ sản phẩm tiếp thị
        const chartCampaignPerformance = new Chart(document.getElementById('chartCampaignPerformance'), {
            type: 'bar',
            data: {
                labels: ['Chiến dịch A', 'Chiến dịch B', 'Chiến dịch C'],
                datasets: [{
                    label: 'Số lượt click',
                    data: [320, 210, 170],
                    backgroundColor: ['#ff9800', '#ff5722', '#e91e63']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Hiệu suất chiến dịch'
                    }
                }
            }
        });

        const chartConversionRate = new Chart(document.getElementById('chartConversionRate'), {
            type: 'line',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4'],
                datasets: [{
                    label: 'Conversion Rate (%)',
                    data: [2.1, 3.5, 2.8, 4.2],
                    borderColor: '#009688',
                    fill: false
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tỷ lệ chuyển đổi theo thời gian'
                    }
                }
            }
        });

        // Dashboard tổng quan
        const chartComparePostAppointment = new Chart(document.getElementById('chartComparePostAppointment'), {
            type: 'bar',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4'],
                datasets: [{
                        label: 'Số bài viết',
                        data: [8, 10, 12, 9],
                        backgroundColor: '#3f51b5'
                    },
                    {
                        label: 'Lịch hẹn',
                        data: [15, 18, 20, 17],
                        backgroundColor: '#8bc34a'
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'So sánh số bài viết và lịch hẹn theo tháng'
                    }
                }
            }
        });
    </script> --}}
    {{-- <script>
        fetch('/doctor/post-stats')
            .then(res => res.json())
            .then(data => {
                const titles = data.map(post => post.title);
                const views = data.map(post => post.views);
                const likes = data.map(post => post.likes);
                const comments = data.map(post => post.comments);

                // Vẽ biểu đồ tổng hợp tương tác
                new Chart(document.getElementById('chartPostInteraction'), {
                    type: 'bar',
                    data: {
                        labels: titles,
                        datasets: [{
                                label: 'Lượt xem',
                                backgroundColor: '#2196f3',
                                data: views
                            },
                            {
                                label: 'Lượt thích',
                                backgroundColor: '#4caf50',
                                data: likes
                            },
                            {
                                label: 'Bình luận',
                                backgroundColor: '#ffc107',
                                data: comments
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            title: {
                                display: true,
                                text: 'Tổng hợp tương tác bài viết'
                            }
                        }
                    }
                });

                // Vẽ bảng xếp hạng bài viết
                const tbody = document.querySelector("#ranking-posts tbody");
                if (tbody) {
                    data.forEach((post, index) => {
                        const tr = document.createElement("tr");
                        tr.innerHTML = `
                            <td>${index + 1}</td>
                            <td>${post.title}</td>
                            <td>${post.views}</td>
                            <td>${post.likes}</td>
                            <td>${post.comments}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                }
            });
    </script> --}}

</div>

<script src="/js/doctor-statistic.js"></script>
