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
// Thêm class 'original-row' cho các dòng ban đầu khi tải trang
document.addEventListener('DOMContentLoaded', function () {
    let originalRows = document.querySelectorAll('#product-table-body tr');
    originalRows.forEach(row => row.classList.add('original-row'));
});



