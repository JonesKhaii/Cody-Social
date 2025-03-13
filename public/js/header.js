// JavaScript để xử lý navbar và sticky header
document.addEventListener('DOMContentLoaded', function () {
    // Tham chiếu đến các phần tử
    const navbar = document.querySelector('.navbar');
    const navbarToggler = document.querySelector('.navbar-toggler');
    const navbarCollapse = document.querySelector('.navbar-collapse');
    let lastScrollTop = 0;

    // Xử lý đóng menu khi click ra ngoài
    document.addEventListener('click', function (event) {
        const isNavbarCollapsed = window.getComputedStyle(navbarToggler).display !== 'none';
        if (isNavbarCollapsed &&
            !navbarToggler.contains(event.target) &&
            !navbarCollapse.contains(event.target) &&
            navbarCollapse.classList.contains('show')) {

            // Sử dụng Bootstrap API để đóng menu
            const bsCollapse = new bootstrap.Collapse(navbarCollapse);
            bsCollapse.hide();
        }
    });

    // Đánh dấu active menu item dựa trên URL hiện tại
    const currentPath = window.location.pathname;
    document.querySelectorAll('.navbar-nav .nav-link').forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });

    // Xử lý sticky header khi scroll
    window.addEventListener('scroll', function () {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

        // Nếu scroll xuống quá 100px, thêm sticky-top
        if (scrollTop > 100) {
            navbar.classList.add('sticky-top');
            navbar.style.boxShadow = '0 4px 10px rgba(0, 0, 0, 0.1)';
        } else {
            navbar.classList.remove('sticky-top');
            navbar.style.boxShadow = '0 2px 5px rgba(0, 0, 0, 0.1)';
        }

        lastScrollTop = scrollTop;
    });

    // Đóng menu khi click vào nav-link trên mobile
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            if (window.innerWidth < 992 && navbarCollapse.classList.contains('show')) {
                const bsCollapse = new bootstrap.Collapse(navbarCollapse);
                bsCollapse.hide();
            }
        });
    });

    // Điều chỉnh navbar khi resize màn hình
    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992 && navbarCollapse.classList.contains('show')) {
            const bsCollapse = new bootstrap.Collapse(navbarCollapse);
            bsCollapse.hide();
        }
    });
});