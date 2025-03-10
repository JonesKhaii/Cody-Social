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

// document.getElementById('open-add-product-modal').addEventListener('click', function () {
//     document.getElementById('add-product-modal').style.display = 'block';
// });

// document.getElementById('cancel-add-product').addEventListener('click', function () {
//     document.getElementById('add-product-modal').style.display = 'none';
// });
// document.getElementById('close-add-product-modal').addEventListener('click', function () {
//     document.getElementById('add-product-modal').style.display = 'none';
// });



// JS xử lý cho phần bảng sản phẩm tiếp thị
// $(document).ready(function () {
//     // Kích hoạt DataTable cho bảng
//     var table = $('#product-dataTable').DataTable({
//         "processing": true, // Cho phép xử lý dữ liệu
//         "serverSide": false, // Bật server-side paging nếu cần
//         "searching": true, // Tính năng tìm kiếm tự động
//         "paging": true, // Bật phân trang
//         "ordering": true, // Cho phép sắp xếp cột
//         "info": true, // Hiển thị thông tin về số lượng bản ghi
//         "language": {
//             "lengthMenu": "Hiển thị _MENU_ dòng",
//             "zeroRecords": "Không tìm thấy sản phẩm",
//             "info": "Trang _PAGE_/_PAGES_",
//             "infoEmpty": "Không có dữ liệu",
//             "search": "Tìm kiếm:",
//             "paginate": {
//                 "first": "Đầu",
//                 "last": "Cuối",
//                 "next": "Tiếp",
//                 "previous": "Trước"
//             }
//         }

//     });

//     // Tùy chỉnh hành vi của ô tìm kiếm trong DataTable
//     $('#product-dataTable_filter input').on('keyup', function () {
//         table.search(this.value).draw(); // Tìm kiếm trong bảng khi gõ
//     });
// });
// Thêm class 'original-row' cho các dòng ban đầu khi tải trang
document.addEventListener('DOMContentLoaded', function () {
    let originalRows = document.querySelectorAll('#product-table-body tr');
    originalRows.forEach(row => row.classList.add('original-row'));
});


// document.getElementById('search-product').addEventListener('keyup', function () {
//     let query = this.value.trim();
//     let dropdown = document.getElementById('product-dropdown');

//     if (query.length > 2) {
//         fetch(`/affiliate/search-product?q=${query}`)
//             .then(response => response.json())
//             .then(data => {
//                 dropdown.innerHTML = '';
//                 dropdown.style.display = 'block';

//                 if (data.length > 0) {
//                     data.slice(0, 7).forEach(product => {
//                         console.log("Sản phẩm trả về từ API:",
//                             product); // ✅ Kiểm tra dữ liệu trả về từ API

//                         let div = document.createElement('div');
//                         div.classList.add('product-item');
//                         div.dataset.id = product.id;
//                         div.dataset.name = product.title;
//                         div.dataset.slug = product.slug ||
//                             ""; // ✅ Kiểm tra nếu slug bị undefined
//                         div.dataset.price = product.price;
//                         div.dataset.photo = product.photo;

//                         div.innerHTML = `
//                     <img src="${product.photo}" alt="${product.title}">
//                     <span>${product.title} - ${new Intl.NumberFormat().format(product.price)} đ</span>
//                 `;

//                         div.addEventListener('click', function () {
//                             document.getElementById('selected-product-id').value =
//                                 product.id;
//                             document.getElementById('selected-product-id').setAttribute(
//                                 "data-slug", product.slug || ""); // ✅ Cập nhật slug

//                             document.getElementById('selected-product-image').src =
//                                 product.photo;
//                             document.getElementById('selected-product-name').innerText =
//                                 product.title;
//                             document.getElementById('selected-product-price')
//                                 .innerText =
//                                 new Intl.NumberFormat().format(product.price) + " đ";

//                             document.querySelector('.selected-product-preview')
//                                 .classList.remove('d-none');
//                             dropdown.style.display = 'none';

//                             console.log("Sản phẩm được chọn - ID:", product.id, "Slug:",
//                                 product.slug);
//                         });

//                         dropdown.appendChild(div);
//                     });
//                 } else {
//                     dropdown.innerHTML = '<p class="text-muted p-2">Không tìm thấy sản phẩm</p>';
//                 }
//             })
//             .catch(error => console.error('Lỗi tìm kiếm sản phẩm:', error));
//     } else {
//         dropdown.style.display = 'none';
//     }
// });



// Ẩn dropdown khi click ra ngoài
document.addEventListener('click', function (event) {
    let dropdown = document.getElementById('product-dropdown');
    if (!event.target.closest('.form-group')) {
        dropdown.style.display = 'none';
    }
});



// document.getElementById('product-dropdown').addEventListener('click', function (event) {
//     let item = event.target.closest('.product-item');
//     if (!item) return;

//     let productId = item.dataset.id;
//     let productSlug = item.dataset.slug;


//     document.getElementById('selected-product-id').value = productId;
//     document.getElementById('selected-product-id').setAttribute("data-slug", productSlug);

//     console.log("Sản phẩm được chọn - ID:", productId, "Slug:", productSlug);
// });


// document.getElementById('add-product-form').addEventListener('submit', function (event) {
//     event.preventDefault(); // Ngăn chặn reload trang

//     let productId = document.getElementById('selected-product-id').value;
//     let selectedProductSlug = document.getElementById('selected-product-id').getAttribute(
//         "data-slug"); // ✅ Lấy đúng slug

//     console.log("Product ID:", productId);
//     console.log("Product Slug:", selectedProductSlug);
//     console.log("Gửi yêu cầu đến URL:", `/affiliate/generate-link/${selectedProductSlug}`);

//     if (!productId || !selectedProductSlug) {
//         alert("Vui lòng chọn sản phẩm hợp lệ!");
//         return;
//     }

//     fetch(`/affiliate/generate-link/${selectedProductSlug}`, {
//         method: 'POST',
//         headers: {
//             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
//                 'content'),
//             'Content-Type': 'application/json'
//         },
//         body: JSON.stringify({
//             product_id: productId
//         })
//     })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 alert("Sản phẩm đã được thêm vào danh sách tiếp thị!");
//                 location.reload();
//             } else {
//                 alert(data.message);
//             }
//         })
//         .catch(error => {
//             console.error('Lỗi khi tạo link affiliate:', error);
//             alert('Có lỗi xảy ra khi thêm sản phẩm. Vui lòng kiểm tra console để biết thêm chi tiết.');
//         });
// });

// document.addEventListener('DOMContentLoaded', function () {

//     document.querySelectorAll('.create-affiliate-btn').forEach(button => {
//         button.addEventListener('click', function () {
//             // Lấy slug sản phẩm từ thuộc tính data
//             const productSlug = this.getAttribute('data-slug');
//             const productId = this.getAttribute('data-id');

//             // Lấy tên sản phẩm từ cùng dòng
//             const productTitle = this.closest('tr').querySelector(
//                 'td:nth-child(2)')
//                 .textContent.trim();

//             // Disable nút để tránh click nhiều lần
//             this.disabled = true;
//             this.innerHTML =
//                 '<i class="fa-solid fa-spinner fa-spin"></i> Đang tạo...';

//             console.log(`Tạo liên kết cho sản phẩm: ${productTitle}`);

//             // Gọi API tạo liên kết
//             fetch(`/affiliate/generate-link/${productSlug}`, {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': document.querySelector(
//                         'meta[name="csrf-token"]').getAttribute(
//                             'content')
//                 }
//             })
//                 .then(response => response.json())
//                 .then(data => {
//                     console.log(data); // In ra dữ liệu trả về từ controller

//                     if (data.is_existing) {
//                         // Nếu sản phẩm đã có liên kết, thay đổi nút thành "Copy link"
//                         this.classList.add(
//                             'btn-secondary'); // Thêm màu xám cho nút
//                         this.innerHTML =
//                             '<i class="fa-solid fa-link"></i> Copy link';

//                         // Cập nhật hành động của nút để sao chép link
//                         this.onclick = function () {
//                             const linkInput = document.createElement(
//                                 'input');
//                             linkInput.value = data.affiliate_link;
//                             document.body.appendChild(linkInput);
//                             linkInput.select();
//                             document.execCommand('copy');
//                             document.body.removeChild(linkInput);

//                             Swal.fire({
//                                 title: 'Liên kết đã được sao chép!',
//                                 icon: 'success',
//                                 text: 'Liên kết tiếp thị đã được sao chép vào clipboard.',
//                             });
//                         };
//                     } else {
//                         // Nếu liên kết mới được tạo, hiển thị modal hoặc thông báo
//                         Swal.fire({
//                             title: 'Tạo Liên Kết Tiếp Thị Thành Công!',
//                             html: `
//                         <p><strong>Sản phẩm:</strong> ${productTitle}</p>
//                         <p><strong>Liên kết:</strong></p>
//                         <input type="text" class="form-control" value="${data.affiliate_link}" readonly>
//                     `,
//                             icon: 'success',
//                             showCloseButton: true,
//                             showCopyButton: true
//                         });
//                     }
//                 })
//                 .catch(error => {
//                     // Xử lý lỗi
//                     Swal.fire({
//                         title: 'Lỗi',
//                         text: 'Không thể tạo liên kết. Vui lòng thử lại.',
//                         icon: 'error'
//                     });
//                     console.error('Error:',
//                         error); // In ra lỗi trong console
//                 })
//                 .finally(() => {
//                     // Khôi phục trạng thái ban đầu của nút
//                     this.disabled = false;
//                     if (!data.is_existing) {
//                         this.innerHTML =
//                             '<i class="fa-solid fa-link"></i> Tạo tiếp thị';
//                     }
//                 });
//         });
//     });


//     document.querySelectorAll('button[id^="copy-link-btn-"]').forEach(button => {
//         button.addEventListener('click', function () {
//             console.log("Clicked copy link button");

//             // Lấy slug sản phẩm từ thuộc tính data
//             const productSlug = this.getAttribute('data-slug');
//             const productId = this.getAttribute('data-id');

//             // Lấy tên sản phẩm từ cùng dòng
//             const productTitle = this.closest('tr').querySelector('td:nth-child(2)')
//                 .textContent.trim();

//             // Kiểm tra nếu sản phẩm đã có liên kết
//             const affiliateLink = this.getAttribute(
//                 'data-link'); // Link từ data-link đã có sẵn

//             // Nếu không có affiliateLink, thì không làm gì
//             if (!affiliateLink) {
//                 return Swal.fire({
//                     title: 'Lỗi',
//                     text: 'Không có liên kết tiếp thị!',
//                     icon: 'error'
//                 });
//             }

//             // Tạo input ẩn để sao chép link
//             const linkInput = document.createElement('input');
//             linkInput.value = affiliateLink; // Link affiliate từ data-link
//             document.body.appendChild(linkInput);
//             linkInput.select();
//             document.execCommand('copy');
//             document.body.removeChild(linkInput);

//             // Hiển thị thông báo sao chép thành công
//             Swal.fire({
//                 title: 'Liên kết đã được sao chép!',
//                 icon: 'success',
//                 text: 'Liên kết tiếp thị của sản phẩm đã được sao chép vào clipboard.',
//             });
//         });
//     });





//     //Thống kê và báo cáo -------------------------------------------------------------------------------------------------

//     // Đảm bảo tài liệu đã tải xong trước khi thực hiện
//     document.addEventListener("DOMContentLoaded", function () {
//         // Biểu đồ doanh thu theo thời gian (Tab Thu nhập)
//         var revenueTimeChart = new CanvasJS.Chart("revenueTimeChart", {
//             animationEnabled: true,
//             theme: "light2",
//             title: {
//                 text: ""
//             },
//             axisX: {
//                 valueFormatString: "DD/MM"
//             },
//             axisY: {
//                 title: "Doanh thu (VNĐ)",
//                 includeZero: true,
//                 valueFormatString: "#,##0 ₫"
//             },
//             legend: {
//                 cursor: "pointer",
//                 verticalAlign: "bottom",
//                 horizontalAlign: "center",
//                 dockInsidePlotArea: false
//             },
//             toolTip: {
//                 shared: true,
//                 contentFormatter: function (e) {
//                     var content = e.entries[0].dataPoint.x.toLocaleDateString("vi-VN") + "<br/>";

//                     for (var i = 0; i < e.entries.length; i++) {
//                         content += "<span style='color: " + e.entries[i].dataSeries.color + ";'>" +
//                             e.entries[i].dataSeries.name + ": </span>" +
//                             new Intl.NumberFormat('vi-VN', {
//                                 style: 'currency',
//                                 currency: 'VND'
//                             }).format(e.entries[i].dataPoint.y) + "<br/>";
//                     }

//                     return content;
//                 }
//             },
//             data: [{
//                 type: "line",
//                 showInLegend: true,
//                 name: "Lịch hẹn khám",
//                 markerType: "circle",
//                 xValueFormatString: "DD/MM/YYYY",
//                 color: "#4e73df",
//                 dataPoints: [{
//                     x: new Date(2025, 0, 1),
//                     y: 2500000
//                 },
//                 {
//                     x: new Date(2025, 0, 8),
//                     y: 3250000
//                 },
//                 {
//                     x: new Date(2025, 0, 15),
//                     y: 3750000
//                 },
//                 {
//                     x: new Date(2025, 0, 22),
//                     y: 3000000
//                 },
//                 {
//                     x: new Date(2025, 0, 29),
//                     y: 3750000
//                 },
//                 {
//                     x: new Date(2025, 1, 5),
//                     y: 4250000
//                 },
//                 {
//                     x: new Date(2025, 1, 12),
//                     y: 4500000
//                 },
//                 {
//                     x: new Date(2025, 1, 19),
//                     y: 5000000
//                 },
//                 {
//                     x: new Date(2025, 1, 26),
//                     y: 5500000
//                 }
//                 ]
//             }, {
//                 type: "line",
//                 showInLegend: true,
//                 name: "Tiếp thị sản phẩm",
//                 markerType: "square",
//                 xValueFormatString: "DD/MM/YYYY",
//                 color: "#1cc88a",
//                 dataPoints: [{
//                     x: new Date(2025, 0, 1),
//                     y: 1200000
//                 },
//                 {
//                     x: new Date(2025, 0, 8),
//                     y: 1500000
//                 },
//                 {
//                     x: new Date(2025, 0, 15),
//                     y: 1350000
//                 },
//                 {
//                     x: new Date(2025, 0, 22),
//                     y: 1800000
//                 },
//                 {
//                     x: new Date(2025, 0, 29),
//                     y: 2100000
//                 },
//                 {
//                     x: new Date(2025, 1, 5),
//                     y: 2350000
//                 },
//                 {
//                     x: new Date(2025, 1, 12),
//                     y: 2700000
//                 },
//                 {
//                     x: new Date(2025, 1, 19),
//                     y: 3000000
//                 },
//                 {
//                     x: new Date(2025, 1, 26),
//                     y: 3450000
//                 }
//                 ]
//             }]
//         });
//         revenueTimeChart.render();

//         function updateChartBasedOnTimeframe(timeframe, chart) {
//             let appointmentData = [];
//             let marketingData = [];

//             if (timeframe === "Tuần") {
//                 appointmentData = [{
//                     x: new Date(2025, 0, 1),
//                     y: 2500000
//                 },
//                 {
//                     x: new Date(2025, 0, 8),
//                     y: 3250000
//                 },
//                 {
//                     x: new Date(2025, 0, 15),
//                     y: 3750000
//                 },
//                 {
//                     x: new Date(2025, 0, 22),
//                     y: 3000000
//                 },
//                 {
//                     x: new Date(2025, 0, 29),
//                     y: 3750000
//                 },
//                 {
//                     x: new Date(2025, 1, 5),
//                     y: 4250000
//                 },
//                 {
//                     x: new Date(2025, 1, 12),
//                     y: 4500000
//                 },
//                 {
//                     x: new Date(2025, 1, 19),
//                     y: 5000000
//                 },
//                 {
//                     x: new Date(2025, 1, 26),
//                     y: 5500000
//                 }
//                 ];

//                 marketingData = [{
//                     x: new Date(2025, 0, 1),
//                     y: 1200000
//                 },
//                 {
//                     x: new Date(2025, 0, 8),
//                     y: 1500000
//                 },
//                 {
//                     x: new Date(2025, 0, 15),
//                     y: 1350000
//                 },
//                 {
//                     x: new Date(2025, 0, 22),
//                     y: 1800000
//                 },
//                 {
//                     x: new Date(2025, 0, 29),
//                     y: 2100000
//                 },
//                 {
//                     x: new Date(2025, 1, 5),
//                     y: 2350000
//                 },
//                 {
//                     x: new Date(2025, 1, 12),
//                     y: 2700000
//                 },
//                 {
//                     x: new Date(2025, 1, 19),
//                     y: 3000000
//                 },
//                 {
//                     x: new Date(2025, 1, 26),
//                     y: 3450000
//                 }
//                 ];
//                 chart.options.axisX.valueFormatString = "DD/MM";
//             } else if (timeframe === "Tháng") {
//                 appointmentData = [{
//                     x: new Date(2024, 8, 1),
//                     y: 32500000
//                 },
//                 {
//                     x: new Date(2024, 9, 1),
//                     y: 34250000
//                 },
//                 {
//                     x: new Date(2024, 10, 1),
//                     y: 33750000
//                 },
//                 {
//                     x: new Date(2024, 11, 1),
//                     y: 35500000
//                 },
//                 {
//                     x: new Date(2025, 0, 1),
//                     y: 35500000
//                 },
//                 {
//                     x: new Date(2025, 1, 1),
//                     y: 41000000
//                 }
//                 ];

//                 marketingData = [{
//                     x: new Date(2024, 8, 1),
//                     y: 10200000
//                 },
//                 {
//                     x: new Date(2024, 9, 1),
//                     y: 11500000
//                 },
//                 {
//                     x: new Date(2024, 10, 1),
//                     y: 12350000
//                 },
//                 {
//                     x: new Date(2024, 11, 1),
//                     y: 13800000
//                 },
//                 {
//                     x: new Date(2025, 0, 1),
//                     y: 12130000
//                 },
//                 {
//                     x: new Date(2025, 1, 1),
//                     y: 16320000
//                 }
//                 ];
//                 chart.options.axisX.valueFormatString = "MM/YYYY";
//             } else if (timeframe === "Năm") {
//                 appointmentData = [{
//                     x: new Date(2020, 0, 1),
//                     y: 258000000
//                 },
//                 {
//                     x: new Date(2021, 0, 1),
//                     y: 312500000
//                 },
//                 {
//                     x: new Date(2022, 0, 1),
//                     y: 345000000
//                 },
//                 {
//                     x: new Date(2023, 0, 1),
//                     y: 420000000
//                 },
//                 {
//                     x: new Date(2024, 0, 1),
//                     y: 470000000
//                 },
//                 {
//                     x: new Date(2025, 0, 1),
//                     y: 126500000
//                 } // Partial year
//                 ];

//                 marketingData = [{
//                     x: new Date(2020, 0, 1),
//                     y: 98000000
//                 },
//                 {
//                     x: new Date(2021, 0, 1),
//                     y: 115000000
//                 },
//                 {
//                     x: new Date(2022, 0, 1),
//                     y: 145000000
//                 },
//                 {
//                     x: new Date(2023, 0, 1),
//                     y: 178000000
//                 },
//                 {
//                     x: new Date(2024, 0, 1),
//                     y: 210000000
//                 },
//                 {
//                     x: new Date(2025, 0, 1),
//                     y: 28450000
//                 } // Partial year
//                 ];
//                 chart.options.axisX.valueFormatString = "YYYY";
//             }

//             chart.options.data[0].dataPoints = appointmentData;
//             chart.options.data[1].dataPoints = marketingData;
//             chart.render();
//         }
//         // Xử lý sự kiện chuyển đổi thời gian
//         const timeButtons = document.querySelectorAll(".btn-group .btn");
//         timeButtons.forEach(button => {
//             button.addEventListener("click", function () {
//                 // Bỏ chọn tất cả các nút
//                 timeButtons.forEach(btn => btn.classList.remove("btn-primary",
//                     "btn-outline-primary"));
//                 timeButtons.forEach(btn => btn.classList.add("btn-outline-primary"));

//                 // Đánh dấu nút được chọn
//                 this.classList.remove("btn-outline-primary");
//                 this.classList.add("btn-primary");

//                 // Cập nhật dữ liệu cho biểu đồ dựa trên lựa chọn
//                 updateChartBasedOnTimeframe(this.textContent.trim(), revenueTimeChart);
//             });
//         });




//         // Biểu đồ tròn cho trạng thái lịch hẹn (Tab Thống kê báo cáo)
//         fetch("{{ route('doctor.appointments.stats') }}")
//             .then(response => response.json())
//             .then(appointmentData => {
//                 if (appointmentData.error) {
//                     console.error("Lỗi:", appointmentData.error);
//                     return;
//                 }

//                 var appointmentStatusChart = new CanvasJS.Chart("appointmentStatusChartStats", {
//                     animationEnabled: true,
//                     theme: "light2",
//                     exportEnabled: false,
//                     creditText: "",
//                     title: {
//                         text: "Lịch hẹn theo trạng thái"
//                     },
//                     legend: {
//                         cursor: "pointer",
//                         verticalAlign: "center",
//                         horizontalAlign: "right",
//                         itemclick: toggleDataSeries
//                     },
//                     data: [{
//                         type: "doughnut",
//                         showInLegend: true,
//                         indexLabel: "{label}: {y}",
//                         toolTipContent: "<b>{label}</b>: {y} ({percentage}%)",
//                         dataPoints: appointmentData
//                     }]
//                 });

//                 appointmentStatusChart.render();

//                 function toggleDataSeries(e) {
//                     if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
//                         e.dataSeries.visible = false;
//                     } else {
//                         e.dataSeries.visible = true;
//                     }
//                     e.chart.render();
//                 }
//             })
//             .catch(error => console.error("Lỗi tải dữ liệu:", error));

//         // Biểu đồ cột cho tương tác trên bài viết (Tab Thống kê báo cáo)
//         fetch("/doctor/post-interactions")
//             .then(response => response.json())
//             .then(data => {
//                 var postInteractionChart = new CanvasJS.Chart("postInteractionChartStats", {
//                     animationEnabled: true,
//                     theme: "light2",
//                     exportEnabled: false,
//                     creditText: "",
//                     title: {
//                         text: "Tương tác trên bài viết"
//                     },
//                     axisX: {
//                         title: "Loại tương tác"
//                     },
//                     axisY: {
//                         title: "Số lượng",
//                         includeZero: true
//                     },
//                     data: [{
//                         type: "column",
//                         showInLegend: false,
//                         dataPoints: [{
//                             label: "Lượt thích",
//                             y: data.likes,
//                             color: "#4e73df"
//                         },
//                         {
//                             label: "Bình luận",
//                             y: data.comments,
//                             color: "#1cc88a"
//                         },
//                         {
//                             label: "Chia sẻ",
//                             y: data.shares,
//                             color: "#36b9cc"
//                         },
//                         {
//                             label: "Lưu",
//                             y: data.saves,
//                             color: "#f6c23e"
//                         }
//                         ]
//                     }]
//                 });
//                 postInteractionChart.render();
//             })
//             .catch(error => console.error("Lỗi khi tải dữ liệu:", error));

//         // Biểu đồ ngang cho doanh thu theo sản phẩm (Tab Thống kê báo cáo)
//         var productRevenueChart = new CanvasJS.Chart("productRevenueChartStats", {
//             animationEnabled: true,
//             theme: "light2",
//             title: {
//                 text: ""
//             },
//             axisX: {
//                 title: "Doanh thu (VNĐ)",
//                 valueFormatString: "#,##0 ₫"
//             },
//             axisY: {
//                 title: "Sản phẩm"
//             },
//             data: [{
//                 type: "bar",
//                 indexLabel: "{y}",
//                 indexLabelFormatter: function (e) {
//                     return new Intl.NumberFormat('vi-VN', {
//                         style: 'currency',
//                         currency: 'VND'
//                     }).format(e.dataPoint.y);
//                 },
//                 dataPoints: [{
//                     label: "Vitamin tổng hợp ABC",
//                     y: 7850000,
//                     color: "#4e73df"
//                 },
//                 {
//                     label: "Máy đo huyết áp XYZ",
//                     y: 6420000,
//                     color: "#1cc88a"
//                 },
//                 {
//                     label: "Thực phẩm chức năng DEF",
//                     y: 5680000,
//                     color: "#36b9cc"
//                 },
//                 {
//                     label: "Bộ kit xét nghiệm tại nhà",
//                     y: 4250000,
//                     color: "#f6c23e"
//                 },
//                 {
//                     label: "Sản phẩm khác",
//                     y: 4250000,
//                     color: "#858796"
//                 }
//                 ]
//             }]
//         });
//         productRevenueChart.render();

//         // Hàm hỗ trợ cho biểu đồ tròn
//         function toggleDataSeries(e) {
//             if (typeof (e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
//                 e.dataSeries.visible = false;
//             } else {
//                 e.dataSeries.visible = true;
//             }
//             e.chart.render();
//         }


//         // Hàm cập nhật biểu đồ dựa trên khung thời gian
//         var chart = new CanvasJS.Chart("appointmentScheduleChart", {
//             animationEnabled: true,
//             exportEnabled: false,
//             theme: "light2",
//             title: {
//                 text: ""
//             },
//             axisX: {
//                 valueFormatString: "DD/MM"
//             },
//             axisY: {
//                 title: "Số lượng lịch hẹn",
//                 includeZero: true,
//                 valueFormatString: "#,##0"
//             },
//             data: [{
//                 type: "line",
//                 markerType: "circle",
//                 dataPoints: []
//             }]
//         });

//         chart.render();

//         // ✅ Hàm cập nhật dữ liệu biểu đồ
//         function updateChart(timeframe) {
//             let url = "{{ route('doctor.appointmentsStats') }}?timeframe=" + timeframe;
//             fetch(url)
//                 .then(response => response.json())
//                 .then(data => {
//                     let appointmentData = data.map(item => ({
//                         x: new Date(item.date),
//                         y: item.total
//                     }));

//                     // ✅ Sử dụng object map thay vì lồng if-else
//                     const formatMapping = {
//                         "day": "DD/MM",
//                         "week": "DD/MM",
//                         "month": "MM/YYYY",
//                         "year": "YYYY"
//                     };

//                     chart.options.axisX.valueFormatString = formatMapping[timeframe] || "DD/MM";
//                     chart.options.data[0].dataPoints = appointmentData;
//                     chart.render();
//                 })
//                 .catch(error => console.error("Lỗi khi tải dữ liệu:", error));
//         }

//         // ✅ Lắng nghe sự kiện khi chọn khung thời gian
//         document.querySelectorAll(".time-view-btn").forEach(button => {
//             button.addEventListener("click", function () {
//                 // Xóa class active khỏi tất cả nút trước khi thêm vào nút hiện tại
//                 document.querySelectorAll(".time-view-btn").forEach(btn => btn.classList.remove(
//                     "active"));
//                 this.classList.add("active");

//                 // Lấy giá trị khung thời gian
//                 let timeframe = this.getAttribute("data-view");
//                 updateChart(timeframe);
//             });
//         });

//         // ✅ Gọi mặc định khi trang tải lần đầu
//         updateChart("week");
//     });

//     // Kiểm tra xem token CSRF có được lấy đúng không
//     // console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));


// });


// document.addEventListener('DOMContentLoaded', function () {

//     // Bắt sự kiện click cho nút tạo tiếp thị
//     document.addEventListener('click', function (event) {
//         if (event.target.closest('.create-affiliate-btn')) {
//             const button = event.target.closest('.create-affiliate-btn');
//             const productSlug = button.getAttribute('data-slug');
//             const productId = button.getAttribute('data-id');
//             const productTitle = button.closest('tr').querySelector('td:nth-child(2)').textContent.trim();

//             button.disabled = true;
//             button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang tạo...';

//             // Gọi API tạo liên kết
//             fetch(`/affiliate/generate-link/${productSlug}`, {
//                 method: 'POST',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//                 }
//             })
//                 .then(response => response.json())
//                 .then(data => {
//                     if (data.is_existing) {
//                         button.classList.remove('btn-success');
//                         button.classList.add('btn-secondary');
//                         button.innerHTML = '<i class="fa-solid fa-link"></i> Copy link';
//                         button.setAttribute('data-link', data.affiliate_link);
//                     } else {
//                         Swal.fire({
//                             title: 'Tạo Liên Kết Thành Công!',
//                             html: `<p><strong>Sản phẩm:</strong> ${productTitle}</p>
//                                    <p><strong>Liên kết:</strong></p>
//                                    <input type="text" class="form-control" value="${data.affiliate_link}" readonly>`,
//                             icon: 'success',
//                             showCloseButton: true
//                         });
//                     }
//                 })
//                 .catch(error => {
//                     Swal.fire({
//                         title: 'Lỗi',
//                         text: 'Không thể tạo liên kết. Vui lòng thử lại.',
//                         icon: 'error'
//                     });
//                     console.error('Error:', error);
//                 })
//                 .finally(() => {
//                     button.disabled = false;
//                     button.innerHTML = '<i class="fa-solid fa-link"></i> Tạo tiếp thị';
//                 });
//         }
//     });

//     // Bắt sự kiện click cho nút copy link
//     document.addEventListener('click', function (event) {
//         if (event.target.closest('[id^="copy-link-btn-"]')) {
//             const button = event.target.closest('[id^="copy-link-btn-"]');
//             const affiliateLink = button.getAttribute('data-link');

//             if (!affiliateLink) {
//                 Swal.fire({
//                     title: 'Lỗi',
//                     text: 'Không có liên kết tiếp thị!',
//                     icon: 'error'
//                 });
//                 return;
//             }

//             // Sao chép liên kết vào clipboard
//             const tempInput = document.createElement('input');
//             tempInput.value = affiliateLink;
//             document.body.appendChild(tempInput);
//             tempInput.select();
//             document.execCommand('copy');
//             document.body.removeChild(tempInput);

//             Swal.fire({
//                 title: 'Liên kết đã được sao chép!',
//                 icon: 'success',
//                 text: 'Liên kết tiếp thị đã được sao chép vào clipboard.',
//             });
//         }
//     });
// });
