@extends('layouts.master')

@section('main-content')
    <div class="sleep-calculator-page py-4">
        <div class="container">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="/tools">Công cụ sức khỏe</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tính thời gian ngủ tối ưu</li>
                </ol>
            </nav>

            <div class="row">
                <!-- Phần chính - Form nhập liệu -->
                <!-- Phần chính - Form nhập liệu -->
                <div class="col-lg-8">
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-bed me-2"></i>Tính thời gian ngủ tối ưu</h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-4">Công cụ này giúp bạn xác định thời điểm đi ngủ và thức dậy tối ưu dựa trên chu
                                kỳ giấc ngủ. Mỗi chu kỳ giấc ngủ kéo dài khoảng 90 phút, và việc thức dậy vào cuối một chu
                                kỳ giúp bạn cảm thấy tỉnh táo hơn.</p>

                            <div class="calculation-tabs mb-4">
                                <ul class="nav nav-tabs" id="sleepCalculatorTabs" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="wake-up-tab" data-bs-toggle="tab"
                                            data-bs-target="#wake-up-content" type="button" role="tab"
                                            aria-controls="wake-up-content" aria-selected="true">Tôi cần thức dậy
                                            lúc</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="sleep-now-tab" data-bs-toggle="tab"
                                            data-bs-target="#sleep-now-content" type="button" role="tab"
                                            aria-controls="sleep-now-content" aria-selected="false">Tôi muốn ngủ
                                            ngay</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="go-to-bed-tab" data-bs-toggle="tab"
                                            data-bs-target="#go-to-bed-content" type="button" role="tab"
                                            aria-controls="go-to-bed-content" aria-selected="false">Tôi muốn đi ngủ
                                            lúc</button>
                                    </li>
                                </ul>

                                <div class="tab-content border-top-0 rounded-bottom border p-3"
                                    id="sleepCalculatorTabContent">
                                    <!-- Tab 1: Thức dậy lúc -->
                                    <div class="tab-pane fade show active" id="wake-up-content" role="tabpanel"
                                        aria-labelledby="wake-up-tab">
                                        <form id="wakeUpForm" class="mb-3">
                                            <div class="row align-items-end">
                                                <div class="col-md-6 mb-md-0 mb-3">
                                                    <label for="wakeUpTime" class="form-label">Thời gian thức dậy <span
                                                            class="text-danger">*</span></label>
                                                    <input type="time" class="form-control" id="wakeUpTime"
                                                        value="07:00" required>
                                                </div>
                                                <div class="col-md-3 mb-md-0 mb-3">
                                                    <label for="fallAsleepTime" class="form-label">Thời gian để ngủ</label>
                                                    <select class="form-select" id="fallAsleepTime">
                                                        <option value="14">14 phút (trung bình)</option>
                                                        <option value="5">5 phút</option>
                                                        <option value="10">10 phút</option>
                                                        <option value="20">20 phút</option>
                                                        <option value="30">30 phút</option>
                                                        <option value="60">1 giờ</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-primary w-100">Tính toán</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div id="wakeUpResult" style="display: none;">
                                            <h6 class="mb-3">Nên đi ngủ vào một trong những thời điểm sau:</h6>
                                            <div class="d-flex flex-wrap" id="wakeUpTimes">
                                                <!-- Thời gian sẽ được thêm vào bởi JavaScript -->
                                            </div>
                                            <div class="result-explanation bg-light mt-3 rounded p-3">
                                                <p class="small mb-0">Những thời điểm được đề xuất tính toán dựa trên chu kỳ
                                                    giấc ngủ 90 phút và thời gian để bạn đi vào giấc ngủ. Thức dậy ở cuối
                                                    một chu kỳ giúp bạn cảm thấy tỉnh táo hơn.</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab 2: Ngủ ngay -->
                                    <div class="tab-pane fade" id="sleep-now-content" role="tabpanel"
                                        aria-labelledby="sleep-now-tab">
                                        <form id="sleepNowForm" class="mb-3">
                                            <div class="row align-items-end">
                                                <div class="col-md-6 mb-md-0 mb-3">
                                                    <label class="form-label">Thời gian hiện tại</label>
                                                    <input type="text" class="form-control" id="currentTime" readonly>
                                                </div>
                                                <div class="col-md-3 mb-md-0 mb-3">
                                                    <label for="sleepNowFallAsleepTime" class="form-label">Thời gian để
                                                        ngủ</label>
                                                    <select class="form-select" id="sleepNowFallAsleepTime">
                                                        <option value="14">14 phút (trung bình)</option>
                                                        <option value="5">5 phút</option>
                                                        <option value="10">10 phút</option>
                                                        <option value="20">20 phút</option>
                                                        <option value="30">30 phút</option>
                                                        <option value="60">1 giờ</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-primary w-100">Tính
                                                        toán</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div id="sleepNowResult" style="display: none;">
                                            <h6 class="mb-3">Nên thức dậy vào một trong những thời điểm sau:</h6>
                                            <div class="d-flex flex-wrap" id="sleepNowTimes">
                                                <!-- Thời gian sẽ được thêm vào bởi JavaScript -->
                                            </div>
                                            <div class="result-explanation bg-light mt-3 rounded p-3">
                                                <p class="small mb-0">Dựa trên thời gian hiện tại, chúng tôi đề xuất những
                                                    thời điểm tối ưu để thức dậy sau khi hoàn thành 4-6 chu kỳ giấc ngủ (6-9
                                                    giờ).</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tab 3: Đi ngủ lúc -->
                                    <div class="tab-pane fade" id="go-to-bed-content" role="tabpanel"
                                        aria-labelledby="go-to-bed-tab">
                                        <form id="goToBedForm" class="mb-3">
                                            <div class="row align-items-end">
                                                <div class="col-md-6 mb-md-0 mb-3">
                                                    <label for="bedTime" class="form-label">Thời gian đi ngủ <span
                                                            class="text-danger">*</span></label>
                                                    <input type="time" class="form-control" id="bedTime"
                                                        value="22:00" required>
                                                </div>
                                                <div class="col-md-3 mb-md-0 mb-3">
                                                    <label for="bedTimeFallAsleepTime" class="form-label">Thời gian để
                                                        ngủ</label>
                                                    <select class="form-select" id="bedTimeFallAsleepTime">
                                                        <option value="14">14 phút (trung bình)</option>
                                                        <option value="5">5 phút</option>
                                                        <option value="10">10 phút</option>
                                                        <option value="20">20 phút</option>
                                                        <option value="30">30 phút</option>
                                                        <option value="60">1 giờ</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" class="btn btn-primary w-100">Tính
                                                        toán</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div id="goToBedResult" style="display: none;">
                                            <h6 class="mb-3">Nên thức dậy vào một trong những thời điểm sau:</h6>
                                            <div class="d-flex flex-wrap" id="goToBedTimes">
                                                <!-- Thời gian sẽ được thêm vào bởi JavaScript -->
                                            </div>
                                            <div class="result-explanation bg-light mt-3 rounded p-3">
                                                <p class="small mb-0">Những thời điểm được đề xuất dựa trên thời gian đi
                                                    ngủ và các chu kỳ giấc ngủ hoàn chỉnh (90 phút mỗi chu kỳ).</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="sleepRecommendation" class="mt-4">
                                <div class="card mb-3">
                                    <div class="card-header bg-primary text-white">
                                        <h6 class="mb-0">Nhu cầu giấc ngủ theo độ tuổi</h6>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table class="table-striped mb-0 table">
                                                <thead>
                                                    <tr>
                                                        <th>Độ tuổi</th>
                                                        <th>Khuyến nghị</th>
                                                        <th>Có thể chấp nhận</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Trẻ sơ sinh (0-3 tháng)</td>
                                                        <td>14-17 giờ</td>
                                                        <td>11-19 giờ</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Trẻ nhỏ (4-11 tháng)</td>
                                                        <td>12-15 giờ</td>
                                                        <td>10-18 giờ</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Trẻ mới biết đi (1-2 tuổi)</td>
                                                        <td>11-14 giờ</td>
                                                        <td>9-16 giờ</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Trẻ mẫu giáo (3-5 tuổi)</td>
                                                        <td>10-13 giờ</td>
                                                        <td>8-14 giờ</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Trẻ em (6-13 tuổi)</td>
                                                        <td>9-11 giờ</td>
                                                        <td>7-12 giờ</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Thanh thiếu niên (14-17 tuổi)</td>
                                                        <td>8-10 giờ</td>
                                                        <td>7-11 giờ</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Người trẻ (18-25 tuổi)</td>
                                                        <td>7-9 giờ</td>
                                                        <td>6-11 giờ</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Người trưởng thành (26-64 tuổi)</td>
                                                        <td>7-9 giờ</td>
                                                        <td>6-10 giờ</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Người cao tuổi (65+ tuổi)</td>
                                                        <td>7-8 giờ</td>
                                                        <td>5-9 giờ</td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
                            <h5 class="mb-0">Về chu kỳ giấc ngủ</h5>
                        </div>
                        <div class="card-body">
                            <h6 class="mb-2">Chu kỳ giấc ngủ là gì?</h6>
                            <p>Chu kỳ giấc ngủ là quá trình cơ thể chuyển qua các giai đoạn ngủ khác nhau. Mỗi chu kỳ kéo
                                dài khoảng 90 phút và lặp lại 4-6 lần mỗi đêm.</p>
                            <p>Mỗi chu kỳ bao gồm:</p>
                            <ul>
                                <li><strong>NREM Giai đoạn 1:</strong> Ngủ nhẹ, dễ thức tỉnh</li>
                                <li><strong>NREM Giai đoạn 2:</strong> Nhịp tim và hơi thở chậm lại</li>
                                <li><strong>NREM Giai đoạn 3:</strong> Giấc ngủ sâu, khó đánh thức</li>
                                <li><strong>REM:</strong> Giai đoạn mơ, hoạt động não tăng cao</li>
                            </ul>
                            <p>Thức dậy vào cuối một chu kỳ (khi đang ở giai đoạn nhẹ) sẽ giúp bạn cảm thấy tỉnh táo hơn so
                                với thức dậy giữa chu kỳ.</p>
                        </div>
                    </div>

                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Lời khuyên cho giấc ngủ tốt</h5>
                        </div>
                        <div class="card-body">
                            <ul>
                                <li><strong>Duy trì lịch trình:</strong> Đi ngủ và thức dậy vào cùng một thời điểm mỗi ngày,
                                    kể cả cuối tuần</li>
                                <li><strong>Tạo môi trường ngủ tối ưu:</strong> Yên tĩnh, mát mẻ, tối và thoải mái</li>
                                <li><strong>Hạn chế ánh sáng xanh:</strong> Tránh các thiết bị điện tử ít nhất 1 giờ trước
                                    khi ngủ</li>
                                <li><strong>Tránh caffeine và rượu:</strong> Không dùng caffeine sau buổi chiều và rượu
                                    trước khi ngủ</li>
                                <li><strong>Tập thể dục thường xuyên:</strong> Nhưng tránh hoạt động cường độ cao gần giờ đi
                                    ngủ</li>
                                <li><strong>Thư giãn trước khi ngủ:</strong> Đọc sách, thực hành hít thở sâu hoặc thiền</li>
                            </ul>
                            <p class="text-danger mb-0"><i class="fas fa-exclamation-circle me-1"></i> Lưu ý: Nếu bạn
                                thường xuyên gặp vấn đề về giấc ngủ, hãy tham khảo ý kiến bác sĩ.</p>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Công cụ liên quan</h5>
                        </div>
                        <div class="card-body">
                            <div class="related-tools">
                                <a href="/tools/bmi-calculator"
                                    class="related-tool-item d-flex align-items-center mb-2 rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-calculator text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính chỉ số BMI</div>
                                        <small class="text-muted">Cân nặng ảnh hưởng đến giấc ngủ</small>
                                    </div>
                                </a>

                                <a href="/tools/water-intake"
                                    class="related-tool-item d-flex align-items-center mb-2 rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-tint text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Lượng nước cần uống</div>
                                        <small class="text-muted">Đủ nước giúp giấc ngủ chất lượng</small>
                                    </div>
                                </a>

                                <a href="/tools/calorie-needs"
                                    class="related-tool-item d-flex align-items-center rounded p-2">
                                    <div class="tool-icon bg-light me-2 rounded p-2">
                                        <i class="fas fa-utensils text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="tool-name">Tính nhu cầu calo</div>
                                        <small class="text-muted">Chế độ ăn ảnh hưởng đến giấc ngủ</small>
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
        /* Time card styling */
        .time-card {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 10px 15px;
            margin-right: 10px;
            margin-bottom: 10px;
            transition: all 0.3s;
            cursor: pointer;
            border: 1px solid #dee2e6;
        }

        .time-card:hover {
            background-color: #e9ecef;
            transform: translateY(-3px);
        }

        .time-card.optimal {
            background-color: #d4edda;
            border-color: #c3e6cb;
        }

        .time-card.ideal {
            background-color: #cce5ff;
            border-color: #b8daff;
        }

        .cycle-count {
            font-size: 0.75rem;
            color: #6c757d;
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
            // Các form
            const wakeUpForm = document.getElementById('wakeUpForm');
            const sleepNowForm = document.getElementById('sleepNowForm');
            const goToBedForm = document.getElementById('goToBedForm');

            // Các container kết quả
            const wakeUpResult = document.getElementById('wakeUpResult');
            const sleepNowResult = document.getElementById('sleepNowResult');
            const goToBedResult = document.getElementById('goToBedResult');

            // Cập nhật thời gian hiện tại
            function updateCurrentTime() {
                const now = new Date();
                const hours = now.getHours().toString().padStart(2, '0');
                const minutes = now.getMinutes().toString().padStart(2, '0');
                document.getElementById('currentTime').value = `${hours}:${minutes}`;
            }

            // Cập nhật thời gian ban đầu
            updateCurrentTime();

            // Cập nhật thời gian mỗi phút
            setInterval(updateCurrentTime, 60000);

            // Định dạng thời gian
            function formatTime(date) {
                const hours = date.getHours().toString().padStart(2, '0');
                const minutes = date.getMinutes().toString().padStart(2, '0');
                return `${hours}:${minutes}`;
            }

            // Chuyển đổi chuỗi thời gian thành đối tượng Date
            function parseTimeString(timeString) {
                const now = new Date();
                const [hours, minutes] = timeString.split(':').map(Number);

                const date = new Date(now);
                date.setHours(hours, minutes, 0, 0);

                return date;
            }

            // Tạo phần tử hiển thị thời gian
            function createTimeCard(time, cycleCount, isOptimal = false, isIdeal = false) {
                const timeCard = document.createElement('div');
                timeCard.className = `time-card ${isOptimal ? 'optimal' : ''} ${isIdeal ? 'ideal' : ''}`;

                const timeDisplay = document.createElement('div');
                timeDisplay.className = 'time-display fw-bold';
                timeDisplay.textContent = time;

                const cycleDisplay = document.createElement('div');
                cycleDisplay.className = 'cycle-count';
                cycleDisplay.textContent = cycleCount;

                timeCard.appendChild(timeDisplay);
                timeCard.appendChild(cycleDisplay);

                return timeCard;
            }

            // Form 1: Tính giờ đi ngủ dựa trên giờ thức dậy
            wakeUpForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const wakeUpTime = parseTimeString(document.getElementById('wakeUpTime').value);
                const fallAsleepMinutes = parseInt(document.getElementById('fallAsleepTime').value);

                // Tính thời gian đi ngủ cho 4-6 chu kỳ (6-9 giờ ngủ)
                const timesToSleep = [];
                const timesContainer = document.getElementById('wakeUpTimes');
                timesContainer.innerHTML = '';

                for (let i = 4; i <= 6; i++) {
                    // Tính thời gian ngủ (90 phút mỗi chu kỳ)
                    const sleepTime = new Date(wakeUpTime);
                    sleepTime.setMinutes(sleepTime.getMinutes() - (i * 90));

                    // Trừ thời gian đi vào giấc ngủ
                    sleepTime.setMinutes(sleepTime.getMinutes() - fallAsleepMinutes);

                    // Định dạng kết quả
                    const formattedTime = formatTime(sleepTime);
                    const cycleText = `${i} chu kỳ (${i * 1.5} giờ)`;

                    // Thêm vào danh sách
                    timesToSleep.push({
                        time: formattedTime,
                        cycles: cycleText,
                        isOptimal: i === 5, // 5 chu kỳ là tối ưu cho hầu hết mọi người
                        isIdeal: i === 6 // 6 chu kỳ là lý tưởng nếu có thể
                    });
                }

                // Hiển thị kết quả
                timesToSleep.reverse().forEach(timeObj => {
                    const timeCard = createTimeCard(timeObj.time, timeObj.cycles, timeObj.isOptimal,
                        timeObj.isIdeal);
                    timesContainer.appendChild(timeCard);
                });

                wakeUpResult.style.display = 'block';
            });

            // Form 2: Tính giờ thức dậy dựa trên việc đi ngủ ngay bây giờ
            sleepNowForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const now = new Date();
                const fallAsleepMinutes = parseInt(document.getElementById('sleepNowFallAsleepTime').value);

                // Thêm thời gian đi vào giấc ngủ
                const sleepStart = new Date(now);
                sleepStart.setMinutes(sleepStart.getMinutes() + fallAsleepMinutes);

                // Tính thời gian thức dậy cho 4-6 chu kỳ
                const timesToWakeUp = [];
                const timesContainer = document.getElementById('sleepNowTimes');
                timesContainer.innerHTML = '';

                for (let i = 4; i <= 6; i++) {
                    // Tính thời gian thức dậy (90 phút mỗi chu kỳ)
                    const wakeUpTime = new Date(sleepStart);
                    wakeUpTime.setMinutes(wakeUpTime.getMinutes() + (i * 90));

                    // Định dạng kết quả
                    const formattedTime = formatTime(wakeUpTime);
                    const cycleText = `${i} chu kỳ (${i * 1.5} giờ)`;

                    // Thêm vào danh sách
                    timesToWakeUp.push({
                        time: formattedTime,
                        cycles: cycleText,
                        isOptimal: i === 5,
                        isIdeal: i === 6
                    });
                }

                // Hiển thị kết quả
                timesToWakeUp.forEach(timeObj => {
                    const timeCard = createTimeCard(timeObj.time, timeObj.cycles, timeObj.isOptimal,
                        timeObj.isIdeal);
                    timesContainer.appendChild(timeCard);
                });

                sleepNowResult.style.display = 'block';
            });

            // Form 3: Tính giờ thức dậy dựa trên giờ đi ngủ
            goToBedForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const bedTime = parseTimeString(document.getElementById('bedTime').value);
                const fallAsleepMinutes = parseInt(document.getElementById('bedTimeFallAsleepTime').value);

                // Thêm thời gian đi vào giấc ngủ
                const sleepStart = new Date(bedTime);
                sleepStart.setMinutes(sleepStart.getMinutes() + fallAsleepMinutes);

                // Tính thời gian thức dậy cho 4-6 chu kỳ
                const timesToWakeUp = [];
                const timesContainer = document.getElementById('goToBedTimes');
                timesContainer.innerHTML = '';

                for (let i = 4; i <= 6; i++) {
                    // Tính thời gian thức dậy (90 phút mỗi chu kỳ)
                    const wakeUpTime = new Date(sleepStart);
                    wakeUpTime.setMinutes(wakeUpTime.getMinutes() + (i * 90));

                    // Định dạng kết quả
                    const formattedTime = formatTime(wakeUpTime);
                    const cycleText = `${i} chu kỳ (${i * 1.5} giờ)`;

                    // Thêm vào danh sách// Thêm vào danh sách
                    timesToWakeUp.push({
                        time: formattedTime,
                        cycles: cycleText,
                        isOptimal: i === 5,
                        isIdeal: i === 6
                    });
                }

                // Hiển thị kết quả
                timesToWakeUp.forEach(timeObj => {
                    const timeCard = createTimeCard(timeObj.time, timeObj.cycles, timeObj.isOptimal,
                        timeObj.isIdeal);
                    timesContainer.appendChild(timeCard);
                });

                goToBedResult.style.display = 'block';
            });

            // Xử lý tab
            const tabButtons = document.querySelectorAll('.nav-link');
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Ẩn tất cả kết quả khi chuyển tab
                    wakeUpResult.style.display = 'none';
                    sleepNowResult.style.display = 'none';
                    goToBedResult.style.display = 'none';
                });
            });

            // Trigger form đầu tiên khi tải trang
            wakeUpForm.dispatchEvent(new Event('submit'));
        });
    </script>
@endsection
