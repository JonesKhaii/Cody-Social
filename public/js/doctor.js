document.addEventListener('DOMContentLoaded', function () {
    // Xử lý nút chỉnh sửa bài viết
    const editPostBtns = document.querySelectorAll('.edit-post-btn');
    const editPostModal = document.getElementById('edit-post-modal');
    const closeEditPostModal = document.getElementById('close-edit-post-modal');
    const cancelEditPost = document.getElementById('cancel-edit-post');
    const editPostForm = document.getElementById('edit-post-form');

    if (editPostBtns.length > 0 && editPostModal) {
        editPostBtns.forEach(button => {
            button.addEventListener('click', function () {
                const postId = this.getAttribute('data-id');
                const title = this.getAttribute('data-title');
                const summary = this.getAttribute('data-summary');
                const description = this.getAttribute('data-description');
                const category = this.getAttribute('data-category');
                const photo = this.getAttribute('data-photo');

                setFieldValueSafely('edit-post-id', postId);
                setFieldValueSafely('edit-title', title);
                setFieldValueSafely('edit-summary', summary);
                setFieldValueSafely('edit-description', description);
                setFieldValueSafely('edit-post_cat_id', category);

                if (editPostForm) {
                    editPostForm.action = `/doctor/posts/${postId}`;
                }

                const previewImage = document.getElementById('edit-preview-image');
                if (previewImage && photo) {
                    previewImage.src = photo + '?t=' + Date.now();
                    previewImage.style.display = 'block';
                }

                editPostModal.style.display = 'block';
            });
        });

        if (closeEditPostModal) {
            closeEditPostModal.addEventListener('click', () => editPostModal.style.display = 'none');
        }

        if (cancelEditPost) {
            cancelEditPost.addEventListener('click', () => editPostModal.style.display = 'none');
        }
    }

    // Xử lý nút xóa bài viết
    const deleteButtons = document.querySelectorAll('.delete-post-btn');

    if (deleteButtons.length > 0) {
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const postId = this.getAttribute('data-id');

                if (!postId) {
                    console.error('Missing post ID for delete button');
                    return;
                }

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
                        const csrfToken = document.querySelector('meta[name="csrf-token"]');
                        if (!csrfToken) {
                            console.error('CSRF token not found');
                            return;
                        }

                        fetch(`/doctor/posts/${postId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(`HTTP error! Status: ${response.status}`);
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
                                console.error('Error:', error);
                                Swal.fire('Lỗi!', error.message, 'error');
                            });
                    }
                });
            });
        });
    }

    // Xử lý hủy lịch hẹn
    const cancelAppointmentBtns = document.querySelectorAll('.cancel-appointment-btn');

    if (cancelAppointmentBtns.length > 0) {
        cancelAppointmentBtns.forEach(function (button) {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const form = this.closest('form');

                if (!form) return;

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
    }

    // Xử lý tạo tiếp thị
    document.addEventListener('click', function (event) {
        if (event.target.closest('.create-affiliate-btn')) {
            const button = event.target.closest('.create-affiliate-btn');
            const productSlug = button.getAttribute('data-slug');
            const productId = button.getAttribute('data-id');
            const productTitle = button.closest('tr').querySelector('td:nth-child(2)').textContent.trim();

            button.disabled = true;
            button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang tạo...';

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

    // Xử lý copy link
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

    // Xử lý tab UI
    const navItems = document.querySelectorAll('.nav-item');
    const tabPanes = document.querySelectorAll('.tab-pane');
    const submenuToggles = document.querySelectorAll('.nav-link[data-toggle="submenu"]');

    navItems.forEach(item => {
        const link = item.querySelector('.nav-link');
        if (link && link.getAttribute('data-toggle') === 'tab') {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const target = this.getAttribute('href');
                if (!target) return;

                const targetId = target.substring(1);

                navItems.forEach(nav => {
                    const navLink = nav.querySelector('.nav-link');
                    if (navLink && navLink.getAttribute('data-toggle') === 'tab') {
                        nav.classList.remove('active');
                    }
                });

                tabPanes.forEach(tab => tab.classList.remove("active"));

                item.classList.add('active');
                const targetElement = document.getElementById(targetId);
                if (targetElement) {
                    targetElement.classList.add('active');
                }
            });
        }
    });

    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            const submenu = this.nextElementSibling;

            if (submenu) {
                if (submenu.classList.contains('active')) {
                    submenu.classList.remove('active');
                    this.classList.remove('active');
                } else {
                    submenu.classList.add('active');
                    this.classList.add('active');
                }
            }
        });
    });

    // Xử lý modals
    const editModal = document.getElementById('edit-modal');
    const editBtn = document.getElementById('edit-info-btn');
    const closeModal = document.getElementById('close-modal');
    const cancelModal = document.getElementById('cancel-modal');

    if (editBtn && editModal) {
        editBtn.addEventListener('click', function () {
            editModal.style.display = 'block';
        });
    }

    if (closeModal && editModal) {
        closeModal.addEventListener('click', function () {
            editModal.style.display = 'none';
        });
    }

    if (cancelModal && editModal) {
        cancelModal.addEventListener('click', function () {
            editModal.style.display = 'none';
        });
    }

    const addPostModal = document.getElementById('add-post-modal');
    const addPostBtn = document.getElementById('add-post-btn');
    const closeAddPostModal = document.getElementById('close-add-post-modal');
    const cancelAddPost = document.getElementById('cancel-add-post');

    if (addPostBtn && addPostModal) {
        addPostBtn.addEventListener('click', function () {
            addPostModal.style.display = 'block';
        });
    }

    if (closeAddPostModal && addPostModal) {
        closeAddPostModal.addEventListener('click', function () {
            addPostModal.style.display = 'none';
        });
    }

    if (cancelAddPost && addPostModal) {
        cancelAddPost.addEventListener('click', function () {
            addPostModal.style.display = 'none';
        });
    }

    // Auto hide alert
    setTimeout(function () {
        let alertBox = document.getElementById('success-alert');
        if (alertBox) {
            alertBox.style.transition = "opacity 0.5s";
            alertBox.style.opacity = "0";
            setTimeout(() => alertBox.remove(), 500);
        }
    }, 3000);

    // Xử lý sidebar responsive
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function checkScreenSize() {
        if (!sidebar) return;

        if (window.innerWidth <= 768) {
            sidebar.classList.remove('collapsed');
            if (mainContent) {
                mainContent.classList.add('full-width');
                mainContent.classList.remove('expanded');
            }
        } else if (window.innerWidth <= 1200) {
            sidebar.classList.add('collapsed');
            sidebar.classList.remove('mobile-hidden');
            if (mainContent) {
                mainContent.classList.add('expanded');
                mainContent.classList.remove('full-width');
            }
        } else {
            sidebar.classList.remove('collapsed');
            sidebar.classList.remove('mobile-hidden');
            if (mainContent) {
                mainContent.classList.remove('expanded');
                mainContent.classList.remove('full-width');
            }
        }
    }

    checkScreenSize();

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function () {
            if (sidebar) sidebar.classList.toggle('mobile-visible');
            if (sidebarOverlay) sidebarOverlay.classList.toggle('active');
        });
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function () {
            if (sidebar) sidebar.classList.remove('mobile-visible');
            sidebarOverlay.classList.remove('active');
        });
    }

    window.addEventListener('resize', checkScreenSize);

    const sidebarToggleMiddle = document.getElementById('sidebarToggleMiddle');
    const mainPanel = document.querySelector('.main-panel');

    if (sidebarToggleMiddle) {
        sidebarToggleMiddle.addEventListener('click', function () {
            if (window.innerWidth <= 992) {
                if (sidebar) sidebar.classList.toggle('active');
                if (sidebarOverlay) sidebarOverlay.classList.toggle('active');
            } else {
                if (sidebar) sidebar.classList.toggle('sidebar-collapsed');
                if (mainPanel) mainPanel.classList.toggle('main-panel-expanded');
            }

            const icon = this.querySelector('i');
            if (icon) {
                if ((window.innerWidth <= 992 && sidebar && sidebar.classList.contains('active')) ||
                    (window.innerWidth > 992 && sidebar && !sidebar.classList.contains('sidebar-collapsed'))) {
                    icon.classList.remove('fa-chevron-right');
                    icon.classList.add('fa-chevron-left');
                } else {
                    icon.classList.remove('fa-chevron-left');
                    icon.classList.add('fa-chevron-right');
                }
            }
        });
    }

    // Hàm trợ giúp để thiết lập giá trị input một cách an toàn
    function setFieldValueSafely(id, value) {
        const field = document.getElementById(id);
        if (field && value !== undefined && value !== null) {
            field.value = value;
        }
    }
});

// Datatable cho bảng sản phẩm tiếp thị
$(document).ready(function () {
    if ($.fn.DataTable && $('#product-dataTable').length) {
        $('#product-dataTable').DataTable({
            "processing": true,
            "serverSide": false,
            "searching": true,
            "paging": true,
            "ordering": true,
            "info": true,
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
    }

    if ($.fn.DataTable && $('#affiliate-product-dataTable').length) {
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
                { orderable: false, targets: [0, 3] }
            ],
            order: [[1, 'asc']],
            pageLength: 10
        });
    }

    $('.delete-form').on('submit', function (e) {
        e.preventDefault();
        if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi danh sách tiếp thị?')) {
            this.submit();
        }
    });

    $('#product-dataTable_filter input').on('keyup', function () {
        if ($.fn.DataTable && $('#product-dataTable').length) {
            $('#product-dataTable').DataTable().search(this.value).draw();
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {
    let originalRows = document.querySelectorAll('#product-table-body tr');
    originalRows.forEach(row => row.classList.add('original-row'));
});

function addCSSRule() {
    let style = document.createElement('style');
    style.type = 'text/css';
    style.innerHTML = '.rotate-90 { transform: rotate(90deg); }';
    document.getElementsByTagName('head')[0].appendChild(style);
}
addCSSRule();