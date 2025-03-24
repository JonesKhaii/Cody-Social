document.addEventListener("DOMContentLoaded", function () {
    // Thêm hiệu ứng loading
    const loadingElements = document.querySelectorAll("[id$='Chart'], #postDetailTable tbody");
    loadingElements.forEach(el => {
        if (el.tagName === "TBODY") {
            el.innerHTML = `<tr><td colspan="6" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div><span class="ms-2">Đang tải dữ liệu...</span></td></tr>`;
        } else {
            el.innerHTML = `<div class="d-flex justify-content-center align-items-center" style="height:100%"><div class="spinner-border text-primary" role="status"></div><span class="ms-2">Đang tải dữ liệu...</span></div>`;
        }
    });

    // Format số với dấu phân cách hàng nghìn
    function formatNumber(num) {
        return new Intl.NumberFormat('vi-VN').format(num);
    }

    // === KPI Tổng quan với hiệu ứng đếm ===
    fetch("/doctor/post-kpi")
        .then(res => res.json())
        .then(data => {
            // Thêm hiệu ứng đếm số
            animateValue("totalPosts", 0, data.total_posts, 1000);
            animateValue("totalViews", 0, data.total_views, 1000);
            animateValue("totalLikes", 0, data.total_likes, 1000);
            animateValue("totalComments", 0, data.total_comments, 1000);

            // Đặt giá trị ER
            document.getElementById("avgER").textContent = data.avg_engagement_rate + "%";
        });

    // Hàm hiệu ứng đếm số
    function animateValue(id, start, end, duration) {
        const obj = document.getElementById(id);
        const range = end - start;
        const minTimer = 50;
        let stepTime = Math.abs(Math.floor(duration / range));
        stepTime = Math.max(stepTime, minTimer);

        let startTime = new Date().getTime();
        let endTime = startTime + duration;
        let timer;

        function run() {
            let now = new Date().getTime();
            let remaining = Math.max((endTime - now) / duration, 0);
            let value = Math.round(end - (remaining * range));
            obj.textContent = formatNumber(value);
            if (value == end) {
                clearInterval(timer);
            }
        }

        timer = setInterval(run, stepTime);
        run();
    }

    // === Biểu đồ Top bài viết (Cải tiến) ===
    fetch("/doctor/post-top")
        .then(res => res.json())
        .then(data => {
            const chart = new CanvasJS.Chart("topPostsChart", {
                animationEnabled: true,
                theme: "light2",
                backgroundColor: "transparent",
                axisX: {
                    labelFontSize: 12,
                    labelMaxWidth: 100,
                    labelWrap: true
                },
                axisY: {
                    title: "Lượt xem",
                    titleFontSize: 14,
                    includeZero: true,
                    gridColor: "#f0f0f0"
                },
                data: [{
                    type: "bar",
                    indexLabelFontSize: 12,
                    indexLabel: "{y}",
                    indexLabelPlacement: "outside",
                    indexLabelFontColor: "#555",
                    dataPoints: data.map(post => ({
                        label: post.title.length > 25 ? post.title.substring(0, 22) + "..." : post.title,
                        y: post.views,
                        color: "#4e73df"
                    }))
                }]
            });
            chart.render();
        });

    // === Biểu đồ phân phối danh mục (Cải tiến) ===
    fetch("/doctor/post-category-distribution")
        .then(res => res.json())
        .then(data => {
            const colors = ["#4e73df", "#1cc88a", "#36b9cc", "#f6c23e", "#e74a3b", "#858796", "#5a5c69"];
            const chart = new CanvasJS.Chart("categoryDistributionChart", {
                animationEnabled: true,
                backgroundColor: "transparent",
                theme: "light2",
                legend: {
                    fontSize: 12,
                    fontFamily: "Nunito"
                },
                data: [{
                    type: "doughnut",
                    indexLabelFontSize: 12,
                    radius: "85%",
                    innerRadius: "50%",
                    indexLabel: "{label} - {y}%",
                    toolTipContent: "<b>{label}:</b> {y}%",
                    dataPoints: data.map((item, index) => ({
                        label: item.category,
                        y: item.percentage || Math.round(item.total / data.reduce((sum, cat) => sum + cat.total, 0) * 100),
                        color: colors[index % colors.length]
                    }))
                }]
            });
            chart.render();
        });

    // === Bảng chi tiết từng bài viết (Cải tiến) ===
    fetch("/doctor/post-detail-stats")
        .then(res => res.json())
        .then(data => {
            const tableBody = document.querySelector("#postDetailTable tbody");
            tableBody.innerHTML = "";
            data.forEach((post, index) => {
                tableBody.innerHTML += `
                    <tr>
                        <td class="px-3">${index + 1}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="post-icon bg-light rounded me-2 p-2">
                                    <i class="fas fa-file-alt text-primary"></i>
                                </div>
                                <div class="post-info">
                                    <div class="fw-medium">${post.title}</div>
                                    <small class="text-muted">${post.created_at || 'N/A'}</small>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">${formatNumber(post.views)}</td>
                        <td class="text-center">${formatNumber(post.likes)}</td>
                        <td class="text-center">${formatNumber(post.comments)}</td>
                        <td class="text-center">
                            <span class="badge rounded-pill ${getERBadgeClass(post.engagement_rate)}">${post.engagement_rate}%</span>
                        </td>
                    </tr>
                `;
            });

            // Tìm kiếm trong bảng
            document.getElementById("postSearch").addEventListener("keyup", function () {
                const term = this.value.toLowerCase();
                const rows = tableBody.querySelectorAll("tr");

                rows.forEach(row => {
                    const title = row.querySelector(".post-info div").textContent.toLowerCase();
                    if (title.includes(term)) {
                        row.style.display = "";
                    } else {
                        row.style.display = "none";
                    }
                });
            });
        });

    // Hàm xác định màu sắc cho badge tỷ lệ tương tác
    function getERBadgeClass(rate) {
        if (rate >= 5) return "bg-success";
        if (rate >= 3) return "bg-info";
        if (rate >= 1) return "bg-warning";
        return "bg-danger";
    }

    // === Biểu đồ xu hướng (views/likes/comments theo thời gian) ===
    function renderTrendChart(range = "month") {
        fetch(`/doctor/post-trend?range=${range}`)
            .then(res => res.json())
            .then(data => {
                const views = data.views.map(item => ({
                    x: new Date(item.date || item.period),
                    y: parseInt(item.total_views)
                }));
                const likes = data.likes.map(item => ({
                    x: new Date(item.date || item.period),
                    y: parseInt(item.total_likes)
                }));
                const comments = data.comments.map(item => ({
                    x: new Date(item.date || item.period),
                    y: parseInt(item.total_comments)
                }));

                const chart = new CanvasJS.Chart("trendChart", {
                    animationEnabled: true,
                    backgroundColor: "transparent",
                    theme: "light2",
                    axisX: {
                        valueFormatString: range === "day" ? "DD MMM" : range === "week" ? "Wk DD MMM" : "MMM YYYY",
                        intervalType: range === "month" ? "month" : range === "week" ? "week" : "day",
                        gridColor: "#f0f0f0"
                    },
                    axisY: {
                        includeZero: true,
                        gridColor: "#f0f0f0"
                    },
                    toolTip: {
                        shared: true,
                        contentFormatter: function (e) {
                            let content = "";
                            if (e.entries.length > 0) {
                                content += formatDate(e.entries[0].dataPoint.x, range);
                                content += "<br/>";
                                e.entries.forEach(entry => {
                                    content += `<span style="color: ${entry.dataSeries.color};">●</span> ${entry.dataSeries.name}: <strong>${formatNumber(entry.dataPoint.y)}</strong><br/>`;
                                });
                            }
                            return content;
                        }
                    },
                    legend: {
                        cursor: "pointer",
                        fontSize: 12,
                        fontFamily: "Nunito",
                        itemclick: toggleDataSeries
                    },
                    data: [
                        {
                            type: "spline",
                            name: "Lượt xem",
                            showInLegend: true,
                            color: "#4e73df",
                            markerSize: 6,
                            xValueFormatString: "DD MMM YYYY",
                            yValueFormatString: "#,###",
                            dataPoints: views
                        },
                        {
                            type: "spline",
                            name: "Lượt thích",
                            showInLegend: true,
                            color: "#1cc88a",
                            markerSize: 6,
                            xValueFormatString: "DD MMM YYYY",
                            yValueFormatString: "#,###",
                            dataPoints: likes
                        },
                        {
                            type: "spline",
                            name: "Bình luận",
                            showInLegend: true,
                            color: "#f6c23e",
                            markerSize: 6,
                            xValueFormatString: "DD MMM YYYY",
                            yValueFormatString: "#,###",
                            dataPoints: comments
                        }
                    ]
                });

                chart.render();

                function toggleDataSeries(e) {
                    if (typeof e.dataSeries.visible === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    } else {
                        e.dataSeries.visible = true;
                    }
                    chart.render();
                }
            })
            .catch(err => {
                console.error("Error fetching data:", err);
                document.getElementById("trendChart").innerHTML =
                    `<div class="alert alert-danger">Không thể tải dữ liệu. Vui lòng thử lại sau.</div>`;
            });
    }

    // Format date for tooltip
    function formatDate(date, range) {
        const options = {
            day: range === "day" || range === "week" ? "numeric" : undefined,
            month: "short",
            year: "numeric"
        };

        if (range === "week") {
            return `Tuần ${getWeekNumber(date)} - ${date.toLocaleDateString("vi-VN", options)}`;
        }

        return date.toLocaleDateString("vi-VN", options);
    }

    // Get week number
    function getWeekNumber(date) {
        const firstDayOfYear = new Date(date.getFullYear(), 0, 1);
        const pastDaysOfYear = (date - firstDayOfYear) / 86400000;
        return Math.ceil((pastDaysOfYear + firstDayOfYear.getDay() + 1) / 7);
    }

    // Gọi ban đầu
    renderTrendChart();

    // Gọi lại khi thay đổi dropdown
    document.getElementById("trendRange").addEventListener("change", function () {
        const range = this.value;
        renderTrendChart(range);
    });
});



document.addEventListener("DOMContentLoaded", function () {
    // Fetch KPI lịch khám
    // Fetch KPI lịch khám
    fetch("/doctor/appointment-kpi")
        .then(res => res.json())
        .then(data => {
            // Hiển thị tổng số lịch khám
            document.getElementById("totalAppointments").textContent = data.total_appointments;

            // Hiển thị từng trạng thái riêng biệt
            const statusData = data.appointment_status;
            document.getElementById("pendingAppointments").textContent = statusData['Chờ duyệt'] || 0;
            document.getElementById("upcomingAppointments").textContent = statusData['Sắp tới'] || 0;
            document.getElementById("completedAppointments").textContent = statusData['Hoàn thành'] || 0;
            document.getElementById("cancelledAppointments").textContent = statusData['Đã Huỷ'] || 0;
        })
        .catch(error => {
            console.error("Error fetching appointment KPI:", error);
            document.getElementById("totalAppointments").textContent = "Error";
        });
    // Biểu đồ xu hướng lịch khám
    fetch("/doctor/appointment-trend")
        .then(res => res.json())
        .then(data => {
            const chart = new CanvasJS.Chart("appointmentTrendChart", {
                animationEnabled: true,
                theme: "light2",
                backgroundColor: "transparent",
                axisX: {
                    valueFormatString: "DD MMM YYYY",
                    gridColor: "#f0f0f0"
                },
                axisY: {
                    includeZero: true,
                    gridColor: "#f0f0f0"
                },
                data: [{
                    type: "spline",
                    name: "Số lịch khám",
                    showInLegend: true,
                    dataPoints: data.map(item => ({
                        x: new Date(item.date),
                        y: item.total
                    }))
                }]
            });
            chart.render();
        });

    // Biểu đồ phân bổ hình thức khám
    fetch("/doctor/appointment-type-distribution")
        .then(res => res.json())
        .then(data => {
            const chart = new CanvasJS.Chart("appointmentTypeDistributionChart", {
                animationEnabled: true,
                theme: "light2",
                backgroundColor: "transparent",
                data: [{
                    type: "doughnut",
                    indexLabel: "{label} - {y}%",
                    dataPoints: data.map(item => ({
                        label: item.type,
                        y: item.percentage
                    }))
                }]
            });
            chart.render();
        });

    // Biểu đồ cột so sánh tỷ lệ lịch khám
    fetch("/doctor/appointment-comparison")
        .then(res => res.json())
        .then(data => {
            const chart = new CanvasJS.Chart("appointmentComparisonChart", {
                animationEnabled: true,
                theme: "light2",
                backgroundColor: "transparent",
                axisX: {
                    title: "Thời gian",
                    labelAngle: -45,
                    gridColor: "#f0f0f0"
                },
                axisY: {
                    title: "Tỷ lệ (%)",
                    gridColor: "#f0f0f0"
                },
                data: [{
                    type: "column",
                    indexLabel: "{y}%",
                    dataPoints: data.map(item => ({
                        label: item.period,
                        y: item.rate
                    }))
                }]
            });
            chart.render();
        });
});
