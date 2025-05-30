
document.addEventListener('DOMContentLoaded', function () {

    function createSmoothCarousel(postList) {
        const items = Array.from(postList.children);
        if (items.length < 3) return;

        let intervalId;
        let isTransitioning = false;

        function smoothRotateItems() {
            if (isTransitioning) return;
            isTransitioning = true;

            const currentActive = postList.querySelector('.active-item');
            const firstItem = postList.firstElementChild;

            // 1. Exit animation mượt mà hơn
            if (currentActive) {
                currentActive.classList.add('exiting');
                currentActive.classList.remove('active-item');
            }

            // 2. Giảm delay và tối ưu DOM manipulation
            setTimeout(() => {
                // Disable transitions tạm thời để tránh giật
                items.forEach(item => {
                    item.style.transition = 'none';
                });

                // Di chuyển item đầu xuống cuối
                postList.appendChild(firstItem);

                // Force reflow để đảm bảo DOM update
                postList.offsetHeight;

                // Re-enable transitions
                setTimeout(() => {
                    items.forEach(item => {
                        item.style.transition = '';
                    });

                    // Clean up animation classes
                    firstItem.classList.remove('exiting', 'entering');

                    // Smooth enter animation cho item mới
                    const newFirstItem = postList.firstElementChild;
                    newFirstItem.classList.add('active-item', 'entering');

                    // Clean up
                    setTimeout(() => {
                        newFirstItem.classList.remove('entering');
                        isTransitioning = false;
                    }, 300); // Giảm delay

                }, 50); // Giảm delay
            }, 150); // Giảm delay từ 300ms xuống 200ms
        }

        function startCarousel() {
            const firstItem = postList.firstElementChild;
            if (firstItem) firstItem.classList.add('active-item');

            intervalId = setInterval(smoothRotateItems, 3000);
        }

        function stopCarousel() {
            clearInterval(intervalId);
        }

        // Pause carousel khi hover
        const categoryItem = postList.closest('.category-forum-item');
        if (categoryItem) {
            categoryItem.addEventListener('mouseenter', stopCarousel);
            categoryItem.addEventListener('mouseleave', startCarousel);
        }

        startCarousel();
        return stopCarousel;
    }
    // Khởi tạo smooth carousel cho tất cả categories
    document.querySelectorAll('.post-list').forEach(postList => {
        const categoryItem = postList.closest('.category-forum-item');
        if (categoryItem && !categoryItem.classList.contains('no-animation')) {
            createSmoothCarousel(postList);
        }
    });


    // Toggle search form
    const searchToggle = document.getElementById('searchToggle');
    const searchCollapse = document.getElementById('searchCollapse');

    if (searchToggle && searchCollapse) {
        searchToggle.addEventListener('click', function () {
            searchCollapse.classList.toggle('show');

            // Focus on input when visible
            if (searchCollapse.classList.contains('show')) {
                const searchInput = searchCollapse.querySelector('input');
                if (searchInput) searchInput.focus();
            }
        });
    }


    document.querySelectorAll('.filter-category').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const slug = this.closest('.category-forum-item').dataset.slug;

            fetch(`/forum/category/${slug}/threads`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('topic-list').innerHTML = data
                            .threads_html;

                        // Active class
                        document.querySelectorAll('.category-forum-item').forEach(li =>
                            li
                                .classList.remove('active'));
                        this.closest('.category-forum-item').classList.add('active');
                    }
                })
                .catch(err => {
                    console.error('Lỗi tải chủ đề:', err);
                    alert('Không thể tải chủ đề. Vui lòng thử lại.');
                });
        });
    });


    const searchInput = document.getElementById('live-search-input');
    let searchTimeout = null;

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            const keyword = this.value.trim();

            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (keyword.length >= 2) {
                    fetch(`/forum/search?q=${encodeURIComponent(keyword)}`)
                        .then(res => res.json())
                        .then(data => {
                            const topicList = document.getElementById('topic-list');

                            if (data.success) {
                                topicList.innerHTML = data.threads_html;
                            } else {
                                topicList.innerHTML =
                                    `<div class="empty-topics"><p>${data.message}</p></div>`;
                            }
                        })
                        .catch(err => {
                            console.error('Search error:', err);
                        });
                }
            }, 300);
        });
    }


    document.querySelectorAll('.show-more').forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const categoryId = this.dataset.category;
            const hiddenPosts = document.querySelectorAll(
                `.post-item.hidden-post[data-category="${categoryId}"]`);

            hiddenPosts.forEach(function (post) {
                post.style.display = 'block';
            });

            this.style.display = 'none';
            document.querySelector(`.show-less[data-category="${categoryId}"]`).style
                .display = 'inline-block';
        });
    });

    // Xử lý nút "Thu gọn"
    document.querySelectorAll('.show-less').forEach(function (button) {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const categoryId = this.dataset.category;
            const hiddenPosts = document.querySelectorAll(
                `.post-item.hidden-post[data-category="${categoryId}"]`);

            hiddenPosts.forEach(function (post) {
                post.style.display = 'none';
            });

            this.style.display = 'none';
            document.querySelector(`.show-more[data-category="${categoryId}"]`).style
                .display = 'inline-block';
        });
    });

    document.querySelectorAll('.post-list').forEach(function (list) {
        const itemCount = list.children.length;

        // Chỉ setup carousel nếu có từ 3 items trở lên
        if (itemCount >= 3) {
            // Giới hạn tối đa 6 items để không quá phức tạp
            const dataItems = Math.min(itemCount, 6);
            list.setAttribute('data-items', dataItems);

            console.log(`Setup carousel for ${itemCount} items`);
        }
    });

});
