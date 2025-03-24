// // Nút sửa bài viết
// document.getElementById('edit-preview-image').src = this.dataset.photo + '?t=' + Date.now();

document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-post-btn');

    editButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const form = document.getElementById('edit-post-form');
            if (!form) return; // Ngừa trường hợp form chưa render

            document.getElementById('edit-post-id').value = this.dataset.id;
            document.getElementById('edit-title').value = this.dataset.title;
            document.getElementById('edit-summary').value = this.dataset.summary;
            document.getElementById('edit-description').value = this.dataset.description;
            document.getElementById('edit-post-cat-id').value = this.dataset.category;
            document.getElementById('edit-preview-image').src = this.dataset.photo + '?t=' + Date.now();
            document.getElementById('edit-post-form').action = this.dataset.url;
        });
    });
});


// Xóa bài viết 
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-post-btn').forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Xác nhận xóa bài viết?',
                text: "Bạn sẽ không thể khôi phục bài viết này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/posts/${postId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Xóa bài viết thất bại!');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Đã xóa!',
                                    text: data.message,
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 2000);
                            } else {
                                Swal.fire('Lỗi!', data.message, 'error');
                            }
                        })
                        .catch((error) => {
                            Swal.fire('Lỗi!', error.message, 'error');
                        });
                }
            });
        });
    });
});



document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.cancel-appointment-btn').forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const form = this.closest('form');

            Swal.fire({
                title: 'Xác nhận hủy lịch?',
                text: "Bạn có chắc chắn muốn hủy lịch hẹn này?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hủy lịch',
                cancelButtonText: 'Không'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
// Bắt sự kiện click cho nút tạo tiếp thị
document.addEventListener('click', function (event) {
    if (event.target.closest('.create-affiliate-btn')) {
        const button = event.target.closest('.create-affiliate-btn');
        const productSlug = button.getAttribute('data-slug');
        const productId = button.getAttribute('data-id');
        const productTitle = button.closest('tr').querySelector('td:nth-child(2)').textContent.trim();

        button.disabled = true;
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang tạo...';

        // Gọi API tạo liên kết
        fetch(`/affiliate/generate-link/${productSlug}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.is_existing) {
                    button.classList.remove('btn-success');
                    button.classList.add('btn-secondary');
                    button.innerHTML = '<i class="fa-solid fa-link"></i> Copy link';
                    button.setAttribute('data-link', data.affiliate_link);
                } else {
                    Swal.fire({
                        title: 'Tạo Liên Kết Thành Công!',
                        html: `<p><strong>Sản phẩm:</strong> ${productTitle}</p>
                               <p><strong>Liên kết:</strong></p>
                               <input type="text" class="form-control" value="${data.affiliate_link}" readonly>`,
                        icon: 'success',
                        showCloseButton: true
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    title: 'Lỗi',
                    text: 'Không thể tạo liên kết. Vui lòng thử lại.',
                    icon: 'error'
                });
                console.error('Error:', error);
            })
            .finally(() => {
                button.disabled = false;
                button.innerHTML = '<i class="fa-solid fa-link"></i> Tạo tiếp thị';
            });
    }
});



// Bắt sự kiện click cho nút copy link
document.addEventListener('click', function (event) {
    if (event.target.closest('[id^="copy-link-btn-"]')) {
        const button = event.target.closest('[id^="copy-link-btn-"]');
        const affiliateLink = button.getAttribute('data-link');

        if (!affiliateLink) {
            Swal.fire({
                title: 'Lỗi',
                text: 'Không có liên kết tiếp thị!',
                icon: 'error'
            });
            return;
        }

        // Sao chép liên kết vào clipboard
        const tempInput = document.createElement('input');
        tempInput.value = affiliateLink;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand('copy');
        document.body.removeChild(tempInput);

        Swal.fire({
            title: 'Liên kết đã được sao chép!',
            icon: 'success',
            text: 'Liên kết tiếp thị đã được sao chép vào clipboard.',
        });
    }
});


////////////////////////////////////
document.addEventListener('DOMContentLoaded', function () {
    const navItems = document.querySelectorAll('.nav-item');
    const tabPanes = document.querySelectorAll('.tab-pane');
    const submenuToggles = document.querySelectorAll('.nav-link[data-toggle="submenu"]');

    navItems.forEach(item => {
        const link = item.querySelector('.nav-link');
        if (link.getAttribute('data-toggle') === 'tab') {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const target = this.getAttribute('href').substring(1);

                // Remove active class from all nav items and tab panes
                navItems.forEach(nav => {
                    if (nav.querySelector('.nav-link').getAttribute(
                        'data-toggle') === 'tab') {
                        nav.classList.remove('active');
                    }
                });
                tabPanes.forEach(tab => tab.classList.remove("active"));

                // Add active class to the clicked nav item and corresponding tab pane
                item.classList.add('active');
                document.getElementById(target)
                    .classList.add('active');
            });
        }
    });

    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            const submenu = this.nextElementSibling;

            if (submenu.classList.contains('active')) {
                submenu.classList.remove('active');
                this.classList.remove('active');
            } else {
                submenu.classList.add('active');
                this.classList.add('active');
            }
        });
    });



    const editModal = document.getElementById('edit-modal');
    const editBtn = document.getElementById('edit-info-btn');
    const closeModal = document.getElementById('close-modal');
    const cancelModal = document.getElementById('cancel-modal');

    if (editBtn) {
        editBtn.addEventListener('click', function () {
            editModal.style.display = 'block';
        });
    }

    if (closeModal) {
        closeModal.addEventListener('click', function () {
            editModal.style.display = 'none';
        });
    }

    if (cancelModal) {
        cancelModal.addEventListener('click', function () {
            editModal.style.display = 'none';
        });
    }

    const addPostModal = document.getElementById('add-post-modal');
    const addPostBtn = document.getElementById('add-post-btn');
    const closeAddPostModal = document.getElementById('close-add-post-modal');
    const cancelAddPost = document.getElementById('cancel-add-post');

    addPostBtn.addEventListener('click', function () {
        addPostModal.style.display = 'block';
    });

    closeAddPostModal.addEventListener('click', function () {
        addPostModal.style.display = 'none';
    });

    cancelAddPost.addEventListener('click', function () {
        addPostModal.style.display = 'none';
    });


    setTimeout(function () {
        let alertBox = document.getElementById('success-alert');
        if (alertBox) {
            alertBox.style.transition = "opacity 0.5s";
            alertBox.style.opacity = "0";
            setTimeout(() => alertBox.remove(), 500);
        }
    }, 3000);




    const editPostBtns = document.querySelectorAll('.edit-post-btn');
    const editPostModal = document.getElementById('edit-post-modal');
    const closeEditPostModal = document.getElementById('close-edit-post-modal');
    const cancelEditPost = document.getElementById('cancel-edit-post');
    const editPostForm = document.getElementById('edit-post-form');

    editPostBtns.forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.getAttribute('data-id');
            const title = this.getAttribute('data-title');
            const summary = this.getAttribute('data-summary');
            const description = this.getAttribute('data-description');
            const category = this.getAttribute('data-category');

            document.getElementById('edit-post-id').value = postId;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-summary').value = summary;
            document.getElementById('edit-description').value = description;
            document.getElementById('edit-post-cat-id').value = category;

            editPostForm.action = `/posts/${postId}`;
            let previewImage = document.getElementById('edit-preview-image');
            previewImage.src = this.getAttribute('data-photo');
            previewImage.style.display = 'block';
            editPostModal.style.display = 'block';
        });
    });

    closeEditPostModal.addEventListener('click', () => editPostModal.style.display = 'none');
    cancelEditPost.addEventListener('click', () => editPostModal.style.display = 'none');
});

// Xử lý submenu
// document.addEventListener('DOMContentLoaded', function () {
//     // Xử lý click vào các submenu toggle
//     const submenuToggles = document.querySelectorAll('.submenu-toggle');

//     submenuToggles.forEach(toggle => {
//         toggle.addEventListener('click', function (e) {
//             e.preventDefault();
//             const parent = this.closest('.submenu-container');
//             parent.classList.toggle('open');
//         });
//     });

//     // Xử lý toggle sidebar (thu gọn/mở rộng)
//     // Thêm một nút toggle sidebar nếu cần
//     const sidebarToggleBtn = document.createElement('button');
//     sidebarToggleBtn.className = 'sidebar-toggle-btn';
//     sidebarToggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
//     document.body.appendChild(sidebarToggleBtn);

//     sidebarToggleBtn.addEventListener('click', function () {
//         const sidebar = document.querySelector('.sidebar');
//         sidebar.classList.toggle('collapsed');
//     });

//     // Hiện tooltip khi sidebar thu gọn (tùy chọn)
//     const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');

//     sidebarLinks.forEach(link => {
//         link.addEventListener('mouseenter', function () {
//             if (document.querySelector('.sidebar').classList.contains('collapsed')) {
//                 const tooltipText = this.querySelector('p').textContent;

//                 const tooltip = document.createElement('div');
//                 tooltip.className = 'sidebar-tooltip';
//                 tooltip.textContent = tooltipText;

//                 const rect = this.getBoundingClientRect();
//                 tooltip.style.top = `${rect.top + rect.height / 2}px`;
//                 tooltip.style.left = `${rect.right + 10}px`;

//                 document.body.appendChild(tooltip);
//             }
//         });

//         link.addEventListener('mouseleave', function () {
//             const tooltip = document.querySelector('.sidebar-tooltip');
//             if (tooltip) {
//                 tooltip.remove();
//             }
//         });
//     });
// });

// JS xử lý cho phần bảng sản phẩm tiếp thị
$(document).ready(function () {
    // Kích hoạt DataTable cho bảng
    var table = $('#product-dataTable').DataTable({
        "processing": true, // Cho phép xử lý dữ liệu
        "serverSide": false, // Bật server-side paging nếu cần
        "searching": true, // Tính năng tìm kiếm tự động
        "paging": true, // Bật phân trang
        "ordering": true, // Cho phép sắp xếp cột
        "info": true, // Hiển thị thông tin về số lượng bản ghi
        "language": {
            "lengthMenu": "Hiển thị _MENU_ dòng",
            "zeroRecords": "Không tìm thấy sản phẩm",
            "info": "Trang _PAGE_/_PAGES_",
            "infoEmpty": "Không có dữ liệu",
            "search": "Tìm kiếm:",
            "paginate": {
                "first": "Đầu",
                "last": "Cuối",
                "next": "Tiếp",
                "previous": "Trước"
            }
        }

    });

    // Tùy chỉnh hành vi của ô tìm kiếm trong DataTable
    $('#product-dataTable_filter input').on('keyup', function () {
        table.search(this.value).draw(); // Tìm kiếm trong bảng khi gõ
    });
});


// Đảm bảo đã tải jQuery và DataTable trước khi sử dụng mã này
$(document).ready(function () {
    // Khởi tạo DataTable cho bảng sản phẩm tiếp thị
    $('#affiliate-product-dataTable').DataTable({
        responsive: true,
        language: {
            "search": "Tìm kiếm:",
            "lengthMenu": "Hiển thị _MENU_ mục",
            "info": "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
            "infoEmpty": "Hiển thị 0 đến 0 của 0 mục",
            "infoFiltered": "(lọc từ _MAX_ mục)",
            "paginate": {
                "first": "Đầu",
                "last": "Cuối",
                "next": "Sau",
                "previous": "Trước"
            },
            "zeroRecords": "Không tìm thấy kết quả phù hợp"
        },
        columnDefs: [
            { orderable: false, targets: [0, 3] } // Không cho phép sắp xếp cột ảnh và hành động
        ],
        order: [[1, 'asc']], // Sắp xếp theo tên sản phẩm tăng dần
        pageLength: 10 // Số mục mỗi trang
    });

    // Xử lý xác nhận xóa
    $('.delete-form').on('submit', function (e) {
        e.preventDefault();
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi danh sách tiếp thị?')) {
            this.submit();
        }
    });
});
// Thêm class 'original-row' cho các dòng ban đầu khi tải trang
document.addEventListener('DOMContentLoaded', function () {
    let originalRows = document.querySelectorAll('#product-table-body tr');
    originalRows.forEach(row => row.classList.add('original-row'));
});



document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const submenuToggles = document.querySelectorAll('.nav-link[data-toggle="submenu"]');

    // Kiểm tra kích thước màn hình khi tải trang
    checkScreenSize();

    // Xử lý sự kiện khi click vào nút toggle
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            if (sidebar) sidebar.classList.toggle('mobile-visible');
            if (sidebarOverlay) sidebarOverlay.classList.toggle('active');
        });
    }

    // Đóng sidebar khi click vào overlay
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function () {
            if (sidebar) sidebar.classList.remove('mobile-visible');
            sidebarOverlay.classList.remove('active');
        });
    }

    // Xử lý submenu
    submenuToggles.forEach(function (toggle) {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            const parent = this.parentElement;

            // Toggle active class cho submenu toggle
            this.classList.toggle('active');

            // Toggle open class cho submenu container
            if (parent) parent.classList.toggle('open');

            // Toggle active class cho submenu
            const submenu = parent ? parent.querySelector('.submenu') : null;
            if (submenu) submenu.classList.toggle('active');
        });
    });

    // Kiểm tra kích thước màn hình khi thay đổi
    window.addEventListener('resize', checkScreenSize);

    function checkScreenSize() {
        if (!sidebar) return; // Nếu không tìm thấy sidebar, thoát khỏi hàm

        if (window.innerWidth <= 768) {
            // Mobile view
            sidebar.classList.remove('collapsed');
            if (mainContent) {
                mainContent.classList.add('full-width');
                mainContent.classList.remove('expanded');
            }
        } else if (window.innerWidth <= 1200) {
            // Tablet view
            sidebar.classList.add('collapsed');
            sidebar.classList.remove('mobile-hidden');
            if (mainContent) {
                mainContent.classList.add('expanded');
                mainContent.classList.remove('full-width');
            }
        } else {
            // Desktop view
            sidebar.classList.remove('collapsed');
            sidebar.classList.remove('mobile-hidden');
            if (mainContent) {
                mainContent.classList.remove('expanded');
                mainContent.classList.remove('full-width');
            }
        }
    }
});





// ==========================================================================================

// Xử lý responsive sidebar
$(document).ready(function () {
    // Khởi tạo biến theo trạng thái hiện tại của màn hình
    let isSidebarCollapsed = $(window).width() < 992;

    // Khởi tạo trạng thái sidebar
    if (isSidebarCollapsed) {
        $('#sidebar').removeClass('active');
        $('#sidebarOverlay').removeClass('active');
    }

    // Xử lý sự kiện click cho nút toggle sidebar
    $('#sidebarToggle').on('click', function () {
        $('#sidebar').toggleClass('active');
        $('#sidebarOverlay').toggleClass('active');
    });

    // Đóng sidebar khi click vào overlay (chỉ cho mobile)
    $('#sidebarOverlay').on('click', function () {
        $('#sidebar').removeClass('active');
        $(this).removeClass('active');
    });

    // Xử lý submenu
    $('.nav-link[data-toggle="submenu"]').on('click', function (e) {
        e.preventDefault();
        $(this).find('.submenu-icon').toggleClass('rotate-90');
        $(this).siblings('.submenu').toggleClass('active');
    });

    // Xử lý chuyển tab
    $('.nav-link[data-toggle="tab"]').on('click', function (e) {
        e.preventDefault();
        const target = $(this).attr('href');

        // Xóa active khỏi tất cả các tab và pane
        $('.nav-link').removeClass('active');
        $('.tab-pane').removeClass('active');

        // Thêm active cho tab và pane hiện tại
        $(this).addClass('active');
        $(target).addClass('active');

        // Đóng sidebar trên mobile sau khi chọn tab
        if ($(window).width() < 992) {
            $('#sidebar').removeClass('active');
            $('#sidebarOverlay').removeClass('active');
        }
    });

    // Xử lý resize window
    $(window).resize(function () {
        if ($(window).width() < 992) {
            // Chuyển sang mobile view
            $('#sidebar').removeClass('active');
            $('#sidebarOverlay').removeClass('active');
        } else {
            // Chuyển sang desktop view
            $('#sidebarOverlay').removeClass('active');
        }
    });

    // Xử lý responsive cho các bảng
    $('.table-responsive table').each(function () {
        if ($(this).width() > $(this).parent().width()) {
            $(this).parent().addClass('has-scroll');
        }
    });
});

// Thêm animation cho rotate icon
function addCSSRule() {
    let style = document.createElement('style');
    style.type = 'text/css';
    style.innerHTML = '.rotate-90 { transform: rotate(90deg); }';
    document.getElementsByTagName('head')[0].appendChild(style);
}
addCSSRule();



document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.getElementById('sidebar');
    const sidebarToggleMiddle = document.getElementById('sidebarToggleMiddle');
    const mainPanel = document.querySelector('.main-panel');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    // Xử lý sự kiện khi nhấn nút toggle giữa
    sidebarToggleMiddle.addEventListener('click', function () {
        if (window.innerWidth <= 992) {
            // Trên màn hình nhỏ, chuyển đổi class "active"
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
        } else {
            // Trên màn hình lớn, chuyển đổi class "sidebar-collapsed"
            sidebar.classList.toggle('sidebar-collapsed');
            mainPanel.classList.toggle('main-panel-expanded');
        }

        // Thay đổi icon tùy theo trạng thái
        const icon = this.querySelector('i');
        if ((window.innerWidth <= 992 && sidebar.classList.contains('active')) ||
            (window.innerWidth > 992 && !sidebar.classList.contains('sidebar-collapsed'))) {
            icon.classList.remove('fa-chevron-right');
            icon.classList.add('fa-chevron-left');
        } else {
            icon.classList.remove('fa-chevron-left');
            icon.classList.add('fa-chevron-right');
        }
    });

    // Xử lý sự kiện khi nhấn overlay
    sidebarOverlay.addEventListener('click', function () {
        sidebar.classList.remove('active');
        sidebarOverlay.classList.remove('active');
        // Cập nhật icon khi đóng sidebar
        const icon = sidebarToggleMiddle.querySelector('i');
        icon.classList.remove('fa-chevron-left');
        icon.classList.add('fa-chevron-right');
    });
});


// Statistics


// document.addEventListener("DOMContentLoaded", function () {
//     // === KPI Tổng quan ===
//     fetch("/doctor/post-kpi")
//         .then(res => res.json())
//         .then(data => {
//             document.getElementById("totalPosts").textContent = data.total_posts;
//             document.getElementById("totalViews").textContent = data.total_views;
//             document.getElementById("totalLikes").textContent = data.total_likes;
//             document.getElementById("totalComments").textContent = data.total_comments;
//             document.getElementById("avgER").textContent = data.avg_engagement_rate + "%";
//         });

//     // === Biểu đồ Top bài viết ===
//     fetch("/doctor/post-top")
//         .then(res => res.json())
//         .then(data => {
//             const chart = new CanvasJS.Chart("topPostsChart", {
//                 animationEnabled: true,
//                 title: { text: "Top 5 bài viết (Theo lượt xem)" },
//                 axisY: { title: "Lượt xem" },
//                 data: [{
//                     type: "column",
//                     dataPoints: data.map(post => ({ label: post.title, y: post.views }))
//                 }]
//             });
//             chart.render();
//         });

//     // === Biểu đồ phân phối danh mục ===
//     fetch("/doctor/post-category-distribution")
//         .then(res => res.json())
//         .then(data => {
//             const chart = new CanvasJS.Chart("categoryDistributionChart", {
//                 animationEnabled: true,
//                 title: { text: "Phân phối bài viết theo danh mục" },
//                 data: [{
//                     type: "pie",
//                     dataPoints: data.map(item => ({ label: item.category, y: item.total }))
//                 }]
//             });
//             chart.render();
//         });

//     // === Bảng chi tiết từng bài viết ===
//     fetch("/doctor/post-detail-stats")
//         .then(res => res.json())
//         .then(data => {
//             const tableBody = document.querySelector("#postDetailTable tbody");
//             tableBody.innerHTML = "";
//             data.forEach((post, index) => {
//                 tableBody.innerHTML += `
//                     <tr>
//                         <td>${index + 1}</td>
//                         <td>${post.title}</td>
//                         <td>${post.views}</td>
//                         <td>${post.likes}</td>
//                         <td>${post.comments}</td>
//                         <td>${post.engagement_rate}%</td>
//                     </tr>
//                 `;
//             });
//         });

//     // === Biểu đồ xu hướng (views/likes/comments theo thời gian) ===
//     function renderTrendChart(range = "month") {
//         fetch(`/doctor/post-trend?range=${range}`)
//             .then(res => res.json())
//             .then(data => {
//                 // Chuyển đổi các giá trị từ chuỗi sang số nguyên
//                 const views = data.views.map(item => ({ label: item.period, y: parseInt(item.total_views) }));
//                 const likes = data.likes.map(item => ({ label: item.period, y: parseInt(item.total_likes) }));
//                 const comments = data.comments.map(item => ({ label: item.period, y: parseInt(item.total_comments) }));

//                 const chart = new CanvasJS.Chart("trendChart", {
//                     animationEnabled: true,
//                     title: { text: "Xu hướng tương tác bài viết" },
//                     axisY: { title: "Số lượng" },
//                     toolTip: { shared: true },
//                     legend: { cursor: "pointer", itemclick: toggleDataSeries },
//                     data: [
//                         {
//                             type: "spline",
//                             name: "Lượt xem",
//                             showInLegend: true,
//                             dataPoints: views
//                         },
//                         {
//                             type: "spline",
//                             name: "Lượt thích",
//                             showInLegend: true,
//                             dataPoints: likes
//                         },
//                         {
//                             type: "spline",
//                             name: "Bình luận",
//                             showInLegend: true,
//                             dataPoints: comments
//                         }
//                     ]
//                 });

//                 chart.render();

//                 function toggleDataSeries(e) {
//                     if (typeof e.dataSeries.visible === "undefined" || e.dataSeries.visible) {
//                         e.dataSeries.visible = false;
//                     } else {
//                         e.dataSeries.visible = true;
//                     }
//                     chart.render();
//                 }
//             })
//             .catch(err => {
//                 console.error("Error fetching data:", err); // Kiểm tra lỗi nếu có
//             });
//     }

//     // Gọi ban đầu
//     renderTrendChart();

//     // Gọi lại khi thay đổi dropdown
//     document.getElementById("trendRange").addEventListener("change", function () {
//         const range = this.value;
//         renderTrendChart(range);
//     });

// });

