
$(document).ready(function () {
    $('.like-btn').click(function () {
        let postId = $(this).data('post-id');
        let button = $(this);
        let likeCount = button.siblings('.like-count');

        $.ajax({
            url: likePostUrl, // Lấy URL từ Blade
            type: "POST",
            data: {
                post_id: postId,
                _token: csrfToken // Lấy CSRF token từ Blade
            },
            success: function (response) {
                if (response.liked) {
                    button.addClass('btn-success liked').removeClass('btn-primary');
                    button.find('.like-text').text('Đã thích');
                } else {
                    button.addClass('btn-primary').removeClass('btn-success liked');
                    button.find('.like-text').text('Like');
                }
                likeCount.text(response.count); // Cập nhật số lượng like chính xác
            },
            error: function (xhr) {
                alert(xhr.responseJSON ? xhr.responseJSON.error : "Lỗi không xác định");
            }
        });
    });
});


$(document).ready(function () {
    // Xử lý tìm kiếm khi nhấn nút
    $('#sidebarSearchBtn').click(function () {
        let query = $('#sidebarSearchInput').val().trim();
        if (query.length >= 2) {
            // Chuyển hướng đến trang kết quả tìm kiếm
            window.location.href = "/search-results?q=" + encodeURIComponent(query);
        }
    });

    // Xử lý tìm kiếm khi nhập từ bàn phím (Hiển thị gợi ý)
    $('#sidebarSearchInput').on('input', function () {
        let query = $(this).val().trim();
        if (query.length >= 2) {
            performSidebarSearch(query);
        } else {
            $('#sidebarSearchResults').hide();
        }
    });

    function performSidebarSearch(query) {
        $.ajax({
            url: "{{ route('search') }}",
            method: 'GET',
            data: {
                q: query
            },
            dataType: 'json',
            success: function (data) {
                let resultsBox = $('#sidebarSearchResults');
                resultsBox.empty().show();

                if (data.results.length > 0) {
                    data.results.forEach(function (post) {
                        resultsBox.append(`
                    <li class="list-group-item">
                        <a href="/post/${post.slug}" class="text-decoration-none text-dark">${post.title}</a>
                    </li>
                `);
                    });

                    // Thêm nút "Xem tất cả kết quả"
                    resultsBox.append(`
                <li class="list-group-item text-center">
                    <a href="/search-results?q=${encodeURIComponent(query)}" class="btn btn-sm btn-secondary w-100">
                        Xem tất cả kết quả
                    </a>
                </li>
            `);

                } else {
                    resultsBox.append(
                        '<li class="list-group-item text-muted">Không tìm thấy kết quả.</li>'
                    );
                }
            },
            error: function () {
                $('#sidebarSearchResults').hide();
            }
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    const replyButtons = document.querySelectorAll('.btn-reply');
    const parentInput = document.getElementById('parent_id');

    replyButtons.forEach(button => {
        button.addEventListener('click', function () {
            const commentId = this.getAttribute('data-id');
            parentInput.value = commentId;

            // Tô sáng comment đang được trả lời (tuỳ chọn)
            document.querySelectorAll('.single-comment').forEach(el => el.classList.remove('border-success'));
            const target = document.getElementById(`comment-${commentId}`);
            if (target) target.classList.add('border-success');

            // Scroll tới form
            document.querySelector('.reply').scrollIntoView({ behavior: 'smooth' });
        });
    });
});

