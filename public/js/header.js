

document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.getElementById('mainHeader');
    const navbarToggler = document.getElementById('navbarToggleBtn');
    const navbarCollapse = document.getElementById('navbarMobile');
    const notificationTrigger = document.querySelector('.notification-trigger');
    const notificationDropdown = document.querySelector('.notification-dropdown');

    let bsCollapse = new bootstrap.Collapse(navbarCollapse, {
        toggle: false
    });

    // Xử lý menu toggle
    if (navbarToggler) {
        navbarToggler.addEventListener('click', function () {
            bsCollapse.toggle();
            const isExpanded = navbarToggler.getAttribute('aria-expanded') === 'true';
            navbarToggler.setAttribute('aria-expanded', (!isExpanded).toString());

            if (isCurrentlyExpanded) {
                navbarCollapse.classList.remove('show');
            } else {
                navbarCollapse.classList.add('show');
            }
        });
    }

    // Đóng menu khi click vào nav-link (mobile)
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function () {
            if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                bsCollapse.hide();
                navbarToggler.setAttribute('aria-expanded', 'false');
            }
        });
    });

    // Đóng menu khi click ra ngoài
    document.addEventListener('click', function (event) {
        if (!navbar.contains(event.target) && navbarCollapse.classList.contains('show')) {
            bsCollapse.hide();
            navbarToggler.setAttribute('aria-expanded', 'false');
        }
    });

    // Xử lý thông báo dropdown
    if (notificationTrigger && notificationDropdown) {
        const notificationDropdownInstance = new bootstrap.Dropdown(notificationTrigger);

        notificationTrigger.addEventListener('click', function (e) {
            e.preventDefault();
            notificationDropdownInstance.toggle();
        });

        document.addEventListener('click', function (e) {
            if (!notificationDropdown.contains(e.target) && !notificationTrigger.contains(e.target)) {
                notificationDropdownInstance.hide();
            }
        });

        // Ngăn dropdown đóng khi click vào các thành phần bên trong
        notificationDropdown.addEventListener('click', function (event) {
            if (event.target.closest('.dropdown-item') === null &&
                event.target.closest('.mark-all-read-btn') !== null) {
                event.stopPropagation();
            }
        });

        const markAllReadBtn = document.querySelector('.mark-all-read-btn');
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', function (event) {
                event.stopPropagation();
                console.log('Mark all as read');
            });
        }
    }

    // Sticky navbar khi scroll
    let lastScrollTop = 0;
    window.addEventListener('scroll', function () {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        if (scrollTop > 70) {
            navbar.classList.add('sticky-top');
        } else {
            navbar.classList.remove('sticky-top');
        }

        if (window.innerWidth < 768) {
            if (scrollTop > lastScrollTop && scrollTop > 200) {
                navbar.style.transform = 'translateY(-100%)';
            } else {
                navbar.style.transform = 'translateY(0)';
            }
        } else {
            navbar.style.transform = 'translateY(0)';
        }

        lastScrollTop = scrollTop;
    });

    // Xử lý resize từ mobile sang desktop
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992 && navbarCollapse.classList.contains('show')) {
            bsCollapse.hide();
            navbarToggler.setAttribute('aria-expanded', 'false');
        }
    });

    // Load thông báo (ví dụ)
    function loadNotifications() {
        const notificationList = document.getElementById('notification-list');
        if (notificationList) {
            setTimeout(() => {
                notificationList.innerHTML = `
                    <a href="#" class="dropdown-item d-flex align-items-center py-2 px-3 border-bottom">
                        <div class="me-3">
                            <i class="fas fa-calendar-check text-primary"></i>
                        </div>
                        <div>
                            <div class="small text-muted">5 phút trước</div>
                            <p class="mb-0">Bạn có cuộc hẹn mới với Dr. Nguyen</p>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item d-flex align-items-center py-2 px-3 border-bottom">
                        <div class="me-3">
                            <i class="fas fa-comment-medical text-success"></i>
                        </div>
                        <div>
                            <div class="small text-muted">Hôm qua</div>
                            <p class="mb-0">Bác sĩ đã trả lời câu hỏi của bạn</p>
                        </div>
                    </a>`;
            }, 1000);
        }
    }

    if (notificationTrigger) {
        notificationTrigger.addEventListener('shown.bs.dropdown', loadNotifications);
    }
});
