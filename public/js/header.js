
// Thêm hiệu ứng sticky và thu nhỏ khi cuộn
document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('.navbar');
    const bottombar = document.querySelector('.bottombar');

    window.addEventListener('scroll', function () {
        if (window.pageYOffset > 50) {
            navbar.classList.add('sticky');
        } else {
            navbar.classList.remove('sticky');
        }
    });

    // Xử lý slider cho categories
    const categoryList = document.querySelector('.category-list');

    // Kiểm tra overflow
    function checkOverflow() {
        if (categoryList && categoryList.scrollWidth > categoryList.clientWidth) {
            categoryList.parentElement.classList.add('has-overflow');
        } else if (categoryList) {
            categoryList.parentElement.classList.remove('has-overflow');
        }
    }

    checkOverflow();
    window.addEventListener('resize', checkOverflow);

    // Xử lý hover cho danh mục
    const dropdownCategories = document.querySelectorAll('.dropdown-category');
    const submenuOverlay = document.querySelector('.submenu-overlay');

    if (dropdownCategories && submenuOverlay) {
        dropdownCategories.forEach(category => {
            const categoryId = category.getAttribute('data-category');
            const submenuPanel = document.getElementById('submenu-panel-' + categoryId);

            if (submenuPanel) {
                // Khi hover vào danh mục
                category.addEventListener('mouseenter', function () {
                    // Ẩn tất cả các submenu panel trước
                    document.querySelectorAll('.submenu-panel').forEach(panel => {
                        panel.classList.remove('active');
                        panel.style.display = 'none';
                    });

                    // Hiển thị submenu hiện tại
                    submenuPanel.style.display = 'block';

                    // Thêm timeout nhỏ để tạo hiệu ứng mượt mà
                    setTimeout(() => {
                        submenuPanel.classList.add('active');
                    }, 10);
                });

                // Khi di chuột ra khỏi danh mục
                category.addEventListener('mouseleave', function (e) {
                    // Kiểm tra xem chuột có di chuyển vào submenu panel hay không
                    const toElement = e.relatedTarget;

                    if (!toElement || !submenuPanel.contains(toElement)) {
                        if (!submenuOverlay.contains(toElement)) {
                            submenuPanel.classList.remove('active');

                            // Đợi hiệu ứng fade out hoàn tất rồi mới ẩn panel
                            setTimeout(() => {
                                if (!submenuPanel.classList.contains('active')) {
                                    submenuPanel.style.display = 'none';
                                }
                            }, 200);
                        }
                    }
                });
            }
        });

        // Xử lý hover cho submenu panel
        const submenuPanels = document.querySelectorAll('.submenu-panel');
        submenuPanels.forEach(panel => {
            // Khi hover vào submenu panel
            panel.addEventListener('mouseenter', function () {
                panel.classList.add('active');
            });

            // Khi rời khỏi submenu panel
            panel.addEventListener('mouseleave', function () {
                panel.classList.remove('active');

                setTimeout(() => {
                    if (!panel.classList.contains('active')) {
                        panel.style.display = 'none';
                    }
                }, 200);
            });
        });

        // Đóng tất cả submenu khi click ra ngoài
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.dropdown-category') && !e.target.closest('.submenu-panel')) {
                document.querySelectorAll('.submenu-panel').forEach(panel => {
                    panel.classList.remove('active');
                    setTimeout(() => {
                        panel.style.display = 'none';
                    }, 200);
                });
            }
        });
    }

    // Xử lý cho mobile - đảm bảo submenu đóng khi click vào đường dẫn
    const submenuLinks = document.querySelectorAll('.submenu-list a');
    submenuLinks.forEach(link => {
        link.addEventListener('click', function () {
            if (window.innerWidth < 992) {
                document.querySelectorAll('.submenu-panel').forEach(panel => {
                    panel.classList.remove('active');
                    panel.style.display = 'none';
                });
            }
        });
    });

    // Xử lý dropdown danh mục con khi click
    const categoryToggles = document.querySelectorAll('.subcategory-toggle');

    categoryToggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            // Lấy container cha
            const categoryContainer = this.closest('.category-item-container');
            const subcategoriesElem = categoryContainer.querySelector('.subcategories');
            const icon = this.querySelector('i');

            // Toggle hiển thị
            if (subcategoriesElem.style.display === 'none' || !subcategoriesElem.classList
                .contains('show')) {
                subcategoriesElem.style.display = 'block';
                subcategoriesElem.classList.add('show');
                icon.style.transform = 'rotate(180deg)';
                this.classList.add('active');
            } else {
                subcategoriesElem.classList.remove('show');
                setTimeout(() => {
                    subcategoriesElem.style.display = 'none';
                }, 300);
                icon.style.transform = 'rotate(0)';
                this.classList.remove('active');
            }
        });
    });

    // Xử lý hover (cho desktop)
    if (window.matchMedia('(min-width: 992px)').matches) {
        const categoryContainers = document.querySelectorAll('.category-item-container');

        categoryContainers.forEach(container => {
            const hasSubcategories = container.querySelector('.has-subcategories');
            if (hasSubcategories) {
                const subcategoriesElem = container.querySelector('.subcategories');

                // Hiện khi hover
                container.addEventListener('mouseenter', function () {
                    subcategoriesElem.style.display = 'block';
                    subcategoriesElem.classList.add('show');
                    const icon = container.querySelector('.subcategory-toggle i');
                    if (icon) {
                        icon.style.transform = 'rotate(180deg)';
                    }
                });

                // Ẩn khi rời chuột
                container.addEventListener('mouseleave', function () {
                    subcategoriesElem.classList.remove('show');
                    setTimeout(() => {
                        subcategoriesElem.style.display = 'none';
                    }, 300);
                    const icon = container.querySelector('.subcategory-toggle i');
                    if (icon) {
                        icon.style.transform = 'rotate(0)';
                    }
                });
            }
        });
    }

});

document.addEventListener('DOMContentLoaded', function () {
    const categoryItems = document.querySelector('.category-items');
    const prevBtn = document.getElementById('sliderPrev');
    const nextBtn = document.getElementById('sliderNext');

    if (categoryItems && prevBtn && nextBtn) {
        // Kiểm tra xem có cần hiển thị nút điều hướng không
        function checkOverflow() {
            const isOverflowing = categoryItems.scrollWidth > categoryItems.clientWidth;
            prevBtn.style.display = isOverflowing ? 'flex' : 'none';
            nextBtn.style.display = isOverflowing ? 'flex' : 'none';
        }

        // Thiết lập ban đầu
        checkOverflow();

        // Kiểm tra lại khi cửa sổ thay đổi kích thước
        window.addEventListener('resize', checkOverflow);

        // Xử lý sự kiện nút trước
        prevBtn.addEventListener('click', function () {
            categoryItems.scrollBy({
                left: -200,
                behavior: 'smooth'
            });
        });

        // Xử lý sự kiện nút sau
        nextBtn.addEventListener('click', function () {
            categoryItems.scrollBy({
                left: 200,
                behavior: 'smooth'
            });
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    // Khởi tạo dropdown trong bottombar
    initBottombarDropdown();

    // Xử lý slider cho danh mục
    initCategorySlider();
});

function initBottombarDropdown() {
    const dropdownTriggers = document.querySelectorAll('.dropdown-trigger');
    const bottombarDropdown = document.getElementById('bottombar-dropdown');
    const dropdownContent = document.getElementById('dropdown-content');

    if (!dropdownTriggers.length || !bottombarDropdown || !dropdownContent) return;

    // Biến để lưu trạng thái
    let activeCategory = null;
    let dropdownTimeout = null;
    let isDropdownOpen = false;

    // Xử lý cho từng trigger button
    dropdownTriggers.forEach(trigger => {
        const categoryType = trigger.getAttribute('data-category');

        // Cả desktop và mobile đều xử lý click
        trigger.addEventListener('click', function (e) {
            e.preventDefault();

            // Kiểm tra xem item hiện tại có đang active không
            const isCurrentlyActive = activeCategory === categoryType;

            // Dọn dẹp timeout nếu có
            if (dropdownTimeout) {
                clearTimeout(dropdownTimeout);
                dropdownTimeout = null;
            }

            if (isCurrentlyActive && isDropdownOpen) {
                // Đang active, đóng dropdown
                bottombarDropdown.classList.remove('show');
                clearActiveItems();
                isDropdownOpen = false;
                activeCategory = null;
            } else {
                // Nếu chưa active hoặc dropdown đang đóng, mở dropdown
                clearActiveItems();
                trigger.classList.add('active');
                showDropdownContent(categoryType, dropdownContent);
                bottombarDropdown.classList.add('show');
                isDropdownOpen = true;
                activeCategory = categoryType;
            }
        });

        // Desktop: Thêm hover
        if (window.matchMedia('(min-width: 992px)').matches) {
            // Hover vào menu item
            trigger.addEventListener('mouseenter', function () {
                // Hủy timeout nếu có
                if (dropdownTimeout) {
                    clearTimeout(dropdownTimeout);
                    dropdownTimeout = null;
                }

                // Đánh dấu item đang active
                clearActiveItems();
                trigger.classList.add('active');

                // Hiển thị nội dung dropdown
                showDropdownContent(categoryType, dropdownContent);

                // Mở rộng dropdown container
                bottombarDropdown.classList.add('show');
                isDropdownOpen = true;
                activeCategory = categoryType;
            });
        }
    });

    // Xử lý hover cho toàn bộ khu vực bottombar
    const bottombarArea = document.querySelector('.bottombar');

    if (bottombarArea && window.matchMedia('(min-width: 992px)').matches) {
        // Khi rời khỏi bottombar
        bottombarArea.addEventListener('mouseleave', function () {
            // Đặt timeout để đóng dropdown sau một thời gian
            dropdownTimeout = setTimeout(() => {
                bottombarDropdown.classList.remove('show');
                clearActiveItems();
                isDropdownOpen = false;
                activeCategory = null;
            }, 300); // Timeout dài hơn để người dùng có thể di chuyển thoải mái
        });

        // Khi quay lại bottombar
        bottombarArea.addEventListener('mouseenter', function () {
            // Nếu có timeout đang chờ đóng dropdown, hủy nó
            if (dropdownTimeout) {
                clearTimeout(dropdownTimeout);
                dropdownTimeout = null;
            }
        });
    }

    // Xử lý click ra ngoài để đóng dropdown
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.bottombar')) {
            bottombarDropdown.classList.remove('show');
            clearActiveItems();
            isDropdownOpen = false;
            activeCategory = null;
        }
    });
}

function clearActiveItems() {
    document.querySelectorAll('.dropdown-trigger').forEach(item => {
        item.classList.remove('active');
    });
}

function showDropdownContent(categoryType, container) {
    // Lấy template tương ứng
    const template = document.getElementById(`dropdown-template-${categoryType}`);

    if (template) {
        // Clone template vào container
        container.innerHTML = template.innerHTML;

        // Nạp dữ liệu động vào template
        loadDynamicContent(categoryType, container);

        // =============== MỚI: Khởi tạo handlers cho phần dropdown danh mục con ===============
        if (categoryType === 'posts' ||
            categoryType === 'specialties' ||
            categoryType === 'doctor-specialties' ||
            categoryType === 'medical-specialties' ||
            categoryType === 'services'
        ) {
            // Chạy lại các handlers cho toggles trong dropdown vừa được render
            initSubcategoryToggles(container);
        }
        // =============== HẾT PHẦN MỚI ===============
    } else {
        container.innerHTML = '<div class="p-4 text-center">Nội dung đang được cập nhật</div>';
    }
}


function initSubcategoryToggles(container) {
    // Xử lý click vào toggle icons
    const categoryToggles = container.querySelectorAll('.subcategory-toggle');

    categoryToggles.forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            // Lấy container cha
            const categoryContainer = this.closest('.category-item-container');
            const subcategoriesElem = categoryContainer.querySelector('.subcategories');
            const icon = this.querySelector('i');

            // Toggle hiển thị
            if (subcategoriesElem.style.display === 'none' || !subcategoriesElem.classList.contains(
                'show')) {
                subcategoriesElem.style.display = 'block';
                subcategoriesElem.classList.add('show');
                icon.style.transform = 'rotate(180deg)';
                this.classList.add('active');
            } else {
                subcategoriesElem.classList.remove('show');
                setTimeout(() => {
                    subcategoriesElem.style.display = 'none';
                }, 300);
                icon.style.transform = 'rotate(0)';
                this.classList.remove('active');
            }
        });
    });

    // Xử lý hover (cho desktop)
    if (window.matchMedia('(min-width: 992px)').matches) {
        const categoryContainers = container.querySelectorAll('.category-item-container');

        categoryContainers.forEach(container => {
            const hasSubcategories = container.querySelector('.has-subcategories');
            if (hasSubcategories) {
                const subcategoriesElem = container.querySelector('.subcategories');

                // Hiện khi hover
                container.addEventListener('mouseenter', function () {
                    subcategoriesElem.style.display = 'block';
                    subcategoriesElem.classList.add('show');
                    const icon = container.querySelector('.subcategory-toggle i');
                    if (icon) {
                        icon.style.transform = 'rotate(180deg)';
                    }
                });

                // Ẩn khi rời chuột
                container.addEventListener('mouseleave', function () {
                    subcategoriesElem.classList.remove('show');
                    setTimeout(() => {
                        subcategoriesElem.style.display = 'none';
                    }, 300);
                    const icon = container.querySelector('.subcategory-toggle i');
                    if (icon) {
                        icon.style.transform = 'rotate(0)';
                    }
                });
            }
        });
    }
}


function loadDynamicContent(categoryType, container) {

    if (categoryType === 'clinics' && window.dropdownData && window.dropdownData.clinics) {
        const hospitalsList = container.querySelector('.hospitals-list');
        const clinicsList = container.querySelector('.clinics-list');

        if (hospitalsList && window.dropdownData.clinics.hospitals) {
            hospitalsList.innerHTML = window.dropdownData.clinics.hospitals.map(hospital =>
                `<a class="dropdown-item" href="/clinic/${hospital.id}">${hospital.name}</a>`
            ).join('');
        }

        if (clinicsList && window.dropdownData.clinics.clinics) {
            clinicsList.innerHTML = window.dropdownData.clinics.clinics.map(clinic =>
                `<a class="dropdown-item" href="/clinic/${clinic.id}">${clinic.name}</a>`
            ).join('');
        }
    }

    // Tương tự cho các loại khác
}

// Khởi tạo slider cho danh mục
function initCategorySlider() {
    const categoryItems = document.querySelector('.category-items');
    const prevBtn = document.getElementById('sliderPrev');
    const nextBtn = document.getElementById('sliderNext');

    if (categoryItems && prevBtn && nextBtn) {
        // Kiểm tra xem có cần hiển thị nút điều hướng không
        function checkOverflow() {
            const isOverflowing = categoryItems.scrollWidth > categoryItems.clientWidth;
            prevBtn.style.display = isOverflowing ? 'flex' : 'none';
            nextBtn.style.display = isOverflowing ? 'flex' : 'none';
        }

        // Thiết lập ban đầu
        checkOverflow();

        // Kiểm tra lại khi cửa sổ thay đổi kích thước
        window.addEventListener('resize', checkOverflow);

        // Xử lý sự kiện nút trước
        prevBtn.addEventListener('click', function () {
            categoryItems.scrollBy({
                left: -200,
                behavior: 'smooth'
            });
        });

        // Xử lý sự kiện nút sau
        nextBtn.addEventListener('click', function () {
            categoryItems.scrollBy({
                left: 200,
                behavior: 'smooth'
            });
        });
    }
}
