const categorySlug = window.FORUM_DATA.categorySlug;
const threadSlug = window.FORUM_DATA.threadSlug;
const csrfToken = window.FORUM_DATA.csrfToken;
const currentUserPhoto = window.FORUM_DATA.currentUserPhoto;
const currentUserName = window.FORUM_DATA.currentUserName;




document.addEventListener('DOMContentLoaded', function () {



    // Xử lý nút trả lời
    const replyButtons = document.querySelectorAll('.btn-reply');
    const cancelButtons = document.querySelectorAll('.btn-cancel');

    replyButtons.forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.getAttribute('data-post-id');
            document.getElementById(`reply-form-${postId}`).style.display = 'block';
        });
    });

    cancelButtons.forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.getAttribute('data-post-id');
            document.getElementById(`reply-form-${postId}`).style.display = 'none';
        });
    });

    document.querySelectorAll('.reply-form-element').forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            const content = this.querySelector('textarea[name="content"]').value.trim();
            const parentId = postId;
            const url = this.dataset.action;

            if (!content) return;

            const formData = new FormData();
            formData.append('content', content);
            formData.append('parent_id', parentId);

            // Optional: show optimistic UI (tuỳ bạn)
            const replyContainer = document.querySelector(`#reply-form-${postId}`);
            const tempReply = document.createElement('div');
            tempReply.className = 'reply-item optimistic-comment';
            tempReply.innerHTML = `
            <div class="reply-author">
                <div class="author-avatar">
                    <img src="{{ Auth::user()->photo ?? asset('images/avatar-placeholder.png') }}" alt="Bạn">
                </div>
                <div class="author-info">
                    <div class="author-name">Bạn</div>
                    <div class="reply-date">Đang gửi...</div>
                </div>
            </div>
            <div class="reply-content">${content}</div>
        `;
            replyContainer.insertAdjacentElement('beforebegin', tempReply);

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    if (!data.success || !data.post) throw new Error('Gửi thất bại');

                    tempReply.remove();

                    const realReply = document.createElement('div');
                    realReply.className = 'reply-item';
                    realReply.innerHTML = `
                <div class="reply-author">
                    <div class="author-avatar">
                        <img src="${data.post.user_photo}" alt="${data.post.user_name}">
                    </div>
                    <div class="author-info">
                        <div class="author-name">${data.post.user_name}</div>
                        <div class="reply-date">${data.post.created_at}</div>
                    </div>
                </div>
                <div class="reply-content">${data.post.content}</div>
            `;
                    replyContainer.insertAdjacentElement('beforebegin', realReply);
                    this.querySelector('textarea[name="content"]').value = '';
                    replyContainer.style.display = 'none';
                })
                .catch(err => {
                    console.error('Reply failed:', err);
                    tempReply.remove();
                    alert('Gửi phản hồi thất bại!');
                });
        });
    });

    // CommentComment
    const commentForm = document.getElementById('comment-form');
    const commentInput = document.getElementById('comment-content');
    const commentContainer = document.getElementById('comments-container');

    if (commentForm) {
        commentForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const content = commentInput.value.trim();
            if (!content) return;

            // Gửi optimistic comment
            const tempComment = document.createElement('div');
            tempComment.className = 'post-item optimistic-comment';
            tempComment.innerHTML = `
            <div class="post-author">
                <div class="author-avatar">
                    <img src="{{ Auth::user()->photo ?? asset('images/avatar-placeholder.png') }}" alt="Bạn">
                </div>
                <div class="author-name">Bạn</div>
                <div class="post-date">Đang gửi...</div>
            </div>
            <div class="post-body">
                <div class="post-content">${content}</div>
            </div>
        `;
            commentContainer.prepend(tempComment);

            // Chuẩn bị dữ liệu
            const formData = new FormData();
            formData.append('content', content);

            fetch(commentForm.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(async res => {
                    const data = await res.json().catch(() =>
                        ({})); // handle JSON parse error
                    console.log('Server response:', res.status, data);

                    if (!res.ok || !data.success || !data.post) throw new Error(
                        'Gửi thất bại');

                    // Xóa optimistic comment
                    tempComment.remove();

                    // Tạo bình luận thật
                    const realComment = document.createElement('div');
                    realComment.className = 'post-item';
                    realComment.innerHTML = `
                    <div class="post-author">
                        <div class="author-avatar">
                            <img src="${data.post.user_photo}" alt="${data.post.user_name}">
                        </div>
                        <div class="author-name">${data.post.user_name}</div>
                        <div class="post-date">${data.post.created_at}</div>
                    </div>
                    <div class="post-body">
                        <div class="post-content">${data.post.content}</div>
                    </div>
                `;
                    commentContainer.prepend(realComment);
                })
                .catch(err => {
                    console.error('Gửi bình luận lỗi:', err);
                    tempComment.remove();
                    alert('Gửi bình luận thất bại!');
                });

            commentInput.value = '';
        });
    }


    // Xử lý nút Like

    const likeButtons = document.querySelectorAll('.btn-like');

    likeButtons.forEach(button => {
        button.addEventListener('click', function () {
            const postId = this.getAttribute('data-post-id');
            const likeCountEl = this.querySelector('.like-count');
            const isLiked = this.classList.contains('liked');

            let currentLikes = parseInt(likeCountEl.textContent);
            if (isLiked) {
                likeCountEl.textContent = currentLikes - 1;
                this.classList.remove('liked');
            } else {
                likeCountEl.textContent = currentLikes + 1;
                this.classList.add('liked');
            }


            const url = `/forum/${categorySlug}/${threadSlug}/posts/${postId}/like`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
                .then(response => response.json())
                .then(data => {

                    if (!data.success) {

                        if (isLiked) {
                            likeCountEl.textContent = currentLikes;
                            this.classList.add('liked');
                        } else {
                            likeCountEl.textContent = currentLikes;
                            this.classList.remove('liked');
                        }
                        alert('Đã có lỗi khi xử lý Like');
                    }
                })
                .catch(error => {

                    if (isLiked) {
                        likeCountEl.textContent = currentLikes;
                        this.classList.add('liked');
                    } else {
                        likeCountEl.textContent = currentLikes;
                        this.classList.remove('liked');
                    }
                    console.error('Like error:', error);
                });
        });
    });

    // xóa 

    // Xóa cmt
    const deleteButtons = document.querySelectorAll('.btn-delete');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            const form = this.closest('form');

            if (!form) return;

            e.preventDefault();
            if (!confirm('Bạn có chắc chắn muốn xóa bình luận này?')) return;

            const postItem = this.closest('.reply-item') || this.closest('.post-item');

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: new URLSearchParams({
                    '_method': 'DELETE'
                })
            })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        postItem.style.transition = 'opacity 0.3s';
                        postItem.style.opacity = '0';

                        setTimeout(() => {
                            postItem.remove();
                            alert('🗑️ Xóa bình luận thành công!');
                        }, 300);
                    } else {
                        alert('Xóa thất bại!');
                    }
                })
                .catch(err => {
                    console.error('Lỗi khi xóa bình luận:', err);
                    alert('Không thể xóa bình luận. Vui lòng thử lại.');
                });
        });
    });



    // xóa thread
    document.querySelectorAll('.btn-delete-thread').forEach(btn => {
        btn.addEventListener('click', function () {
            const url = this.dataset.url;
            if (!url) return alert('❌ Không có URL xóa.');

            if (!confirm('Bạn có chắc muốn xóa chủ đề này?')) return;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    _method: 'DELETE'
                })
            })
                .then(res => {
                    if (!res.ok) throw new Error('Lỗi khi xóa thread');
                    return res.json();
                })
                .then(data => {
                    if (data.success && data.redirect_url) {
                        alert('✅ Chủ đề đã được xóa!');
                        window.location.href = data.redirect_url;
                    } else {
                        alert('❌ Xóa không thành công!');
                    }
                })
                .catch(err => {
                    console.error('❌ Lỗi khi xóa thread:', err);
                    alert('Đã xảy ra lỗi khi xóa chủ đề.');
                });
        });
    });





    // Xử lý nút Copy Link
    const copyLinkBtn = document.getElementById('copyLinkBtn');

    if (copyLinkBtn) {
        copyLinkBtn.addEventListener('click', function () {
            const url = this.getAttribute('data-url');

            // Tạo một element tạm thời để copy
            const tempInput = document.createElement('input');
            tempInput.value = url;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);

            // Hiển thị thông báo
            alert('Đã sao chép liên kết vào clipboard!');
        });
    }

    // Xử lý nút Share
    const shareButton = document.getElementById('shareButton');

    if (shareButton) {
        shareButton.addEventListener('click', function () {
            // Kiểm tra Web Share API có khả dụng không
            if (navigator.share) {
                navigator.share({
                    title: '{{ $thread->title }}',
                    url: window.location.href
                })
                    .catch(error => console.log('Error sharing:', error));
            } else {
                // Hiển thị các nút chia sẻ thay thế
                alert('Các tùy chọn chia sẻ có sẵn ở cột bên phải!');
            }
        });
    }



    // Edit inline

    // Edit commment
    document.querySelectorAll('.inline-edit-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const postId = this.dataset.postId;
            const content = this.dataset.content;

            let postItem = document.getElementById(`post-${postId}`);
            if (!postItem) {
                postItem = document.getElementById(`reply-${postId}`);
            }
            if (!postItem) return;

            let postContentEl = postItem.querySelector('.post-content');
            if (!postContentEl) {
                postContentEl = postItem.querySelector('.reply-content');
            }


            // Backup nội dung cũ
            const originalHTML = postContentEl.innerHTML;

            // Hiển thị textarea thay vì nội dung
            postContentEl.innerHTML = `
                <form class="inline-edit-form" data-post-id="${postId}">
                    <textarea class="form-control mb-2" rows="5" required>${content}</textarea>
                    <button type="submit" class="btn btn-primary btn-sm me-2">Cập nhật</button>
                    <button type="button" class="btn btn-secondary btn-sm btn-cancel-edit">Hủy</button>
                </form>
            `;

            // Hủy
            postItem.querySelector('.btn-cancel-edit').addEventListener('click',
                function () {
                    postContentEl.innerHTML = originalHTML;
                });

            // Gửi cập nhật
            postItem.querySelector('.inline-edit-form').addEventListener('submit', function (
                e) {
                e.preventDefault();

                const form = this;
                const newContent = form.querySelector('textarea').value.trim();

                if (newContent.length < 2) {
                    alert('Nội dung phải có ít nhất 2 ký tự.');
                    return;
                }

                const url = `/forum/${categorySlug}/${threadSlug}/posts/${postId}`;
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'PUT',
                        content: newContent
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.post) {
                            postContentEl.innerHTML = data.post.content;
                            alert(' Cập nhật thành công!');
                        } else {
                            alert(' Có lỗi xảy ra khi cập nhật.');
                        }
                    })
                    .catch(err => {
                        console.error('Update error:', err);
                        alert(' Không thể cập nhật bình luận.');
                    });
            });
        });
    });


    //ediit thread
    const editBtn = document.getElementById('edit-thread-trigger');

    // Hàm giữ nguyên format cho nội dung HTML khi sửa
    function decodeEntities(encodedString) {
        const txt = document.createElement('textarea');
        txt.innerHTML = encodedString;
        return txt.value;
    }

    // Vẫn giữ hàm escape cho title
    function escapeHTML(str) {
        return str.replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    if (editBtn) {
        editBtn.addEventListener('click', function (e) {
            e.preventDefault();
            const originalTitle = this.dataset.title;
            const originalContent = this.dataset.content;

            const titleEl = document.getElementById('thread-title-display');
            const contentEl = document.getElementById('thread-content-display');

            const oldTitleHTML = titleEl.innerHTML;
            const oldContentHTML = contentEl.innerHTML;

            // Chỉ escape title
            titleEl.innerHTML =
                `<input type="text" class="form-control mb-2" id="inline-thread-title" value="${escapeHTML(originalTitle)}">`;

            // Không escape nội dung, chỉ decode để hiển thị lại HTML đã bị encode
            contentEl.innerHTML = `
            <textarea class="form-control mb-2" id="inline-thread-content" rows="6">${decodeEntities(originalContent)}</textarea>
            <div>
                <button class="btn btn-primary btn-sm" id="btn-save-thread">Lưu</button>
                <button class="btn btn-secondary btn-sm" id="btn-cancel-thread">Hủy</button>
            </div>
        `;

            // Hủy bỏ chỉnh sửa
            document.getElementById('btn-cancel-thread').addEventListener('click', () => {
                titleEl.innerHTML = oldTitleHTML;
                contentEl.innerHTML = oldContentHTML;
            });

            // Gửi dữ liệu cập nhật
            document.getElementById('btn-save-thread').addEventListener('click', () => {
                const newTitle = document.getElementById('inline-thread-title').value.trim();
                const newContent = document.getElementById('inline-thread-content').value.trim();

                if (newTitle.length < 3 || newContent.length < 5) {
                    alert('Tiêu đề và nội dung quá ngắn!');
                    return;
                }

                const saveBtn = document.getElementById('btn-save-thread');
                saveBtn.disabled = true;
                saveBtn.innerText = 'Đang lưu...';

                fetch(`/forum/${categorySlug}/${threadSlug}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        _method: 'PUT',
                        title: newTitle,
                        content: newContent
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.thread) {
                            titleEl.textContent = data.thread.title;
                            contentEl.innerHTML = data.thread.content;
                            alert('✅ Cập nhật chủ đề thành công!');
                        } else {
                            alert('❌ Đã có lỗi khi cập nhật!');
                        }
                    })
                    .catch(err => {
                        console.error('Lỗi:', err);
                        alert('❌ Không thể kết nối máy chủ!');
                    });
            });
        });
    }

});