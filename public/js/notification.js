// Đợi cho đến khi DOM đã tải xong
// document.addEventListener('DOMContentLoaded', function () {
//     console.log('Notification script loaded');
//     console.log('Current page:', window.location.pathname);
//     console.log('jQuery available:', typeof jQuery !== 'undefined');
//     console.log('Bootstrap available:', typeof bootstrap !== 'undefined');


//     initNotificationSystem();
//     setTimeout(function () {
//         initNotificationSystem();
//     }, 500);
// });

// function initNotificationSystem() {
//     console.log('Đang khởi tạo hệ thống thông báo...');

//     // Lấy các phần tử cần thiết
//     const notificationList = document.querySelector('#notification-list');
//     const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
//     const notificationTrigger = document.querySelector('.notification-trigger');
//     const markAllReadBtn = document.querySelector('.mark-all-read-btn');

//     // Kiểm tra DOM elements
//     console.log('Notification wrapper exists:', !!document.querySelector('.notification-wrapper'));
//     console.log('Notification trigger exists:', !!notificationTrigger);
//     console.log('Dropdown menu exists:', !!document.querySelector('.dropdown-menu'));
//     console.log('Notification list exists:', !!notificationList);

//     // Kiểm tra các phần tử cần thiết
//     if (!notificationTrigger) {
//         console.log('Không tìm thấy nút thông báo trên trang này');
//         return;
//     }

//     if (!notificationList) {
//         console.log('Không tìm thấy danh sách thông báo trên trang này');
//         return;
//     }

//     if (!csrfToken) {
//         console.error('Không tìm thấy CSRF token, không thể thực hiện các yêu cầu API');
//         return;
//     }

//     // Xác định role người dùng
//     const userRole = determineUserRole();
//     const notificationBaseUrl = userRole === 'doctor' ? '/doctor' : '/user';

//     console.log('Vai trò người dùng:', userRole);
//     console.log('Base URL cho thông báo:', notificationBaseUrl);

//     // notificationTrigger.addEventListener('click', function (e) {
//     //     e.preventDefault();
//     //     e.stopPropagation(); // Ngăn sự kiện lan truyền
//     //     console.log('Đã nhấp vào nút thông báo');

//     //     // Tải thông báo
//     //     fetchNotifications();

//     //     // Tự xử lý dropdown
//     //     const dropdown = this.closest('.notification-wrapper').querySelector('.dropdown-menu');
//     //     if (dropdown) {
//     //         console.log('Dropdown element found:', dropdown);

//     //         // Kiểm tra xem dropdown đã hiển thị chưa
//     //         const isVisible = dropdown.classList.contains('show') &&
//     //             window.getComputedStyle(dropdown).display !== 'none';
//     //         console.log('Dropdown is currently visible:', isVisible);

//     //         // Đóng tất cả dropdown khác nếu có
//     //         document.querySelectorAll('.dropdown-menu.show').forEach(function (item) {
//     //             if (item !== dropdown) {
//     //                 item.classList.remove('show');
//     //                 item.style.display = 'none';
//     //             }
//     //         });

//     //         // Toggle dropdown hiện tại
//     //         if (isVisible) {
//     //             dropdown.classList.remove('show');
//     //             dropdown.style.display = 'none';
//     //         } else {
//     //             dropdown.classList.add('show');
//     //             dropdown.style.display = 'block !important';
//     //             dropdown.style.visibility = 'visible';
//     //             dropdown.style.opacity = '1';

//     //             // Định vị dropdown đúng cách
//     //             positionDropdown(dropdown, this);
//     //         }
//     //     }
//     // });



//     // notificationTrigger.addEventListener('click', function (e) {
//     //     e.preventDefault();
//     //     e.stopPropagation(); // Ngăn sự kiện lan truyền
//     //     console.log('Đã nhấp vào nút thông báo');

//     //     // Tải thông báo
//     //     fetchNotifications();

//     //     // Tự xử lý dropdown
//     //     const dropdown = this.closest('.notification-wrapper').querySelector('.dropdown-menu');
//     //     if (dropdown) {
//     //         console.log('Dropdown element found:', dropdown);

//     //         // Kiểm tra xem dropdown đã hiển thị chưa
//     //         const isVisible = dropdown.classList.contains('show');
//     //         console.log('Dropdown is currently visible:', isVisible);

//     //         // Đóng tất cả dropdown khác nếu có
//     //         document.querySelectorAll('.dropdown-menu.show').forEach(function (item) {
//     //             if (item !== dropdown) {
//     //                 item.classList.remove('show');
//     //                 item.style.setProperty('display', 'none');
//     //             }
//     //         });

//     //         // Toggle dropdown hiện tại
//     //         if (isVisible) {
//     //             dropdown.classList.remove('show');
//     //             dropdown.style.setProperty('display', 'none');
//     //         } else {
//     //             dropdown.classList.add('show');
//     //             dropdown.style.setProperty('display', 'block', 'important');
//     //             dropdown.style.visibility = 'visible';
//     //             dropdown.style.opacity = '1';

//     //             // Định vị dropdown đúng cách
//     //             positionDropdown(dropdown, this);
//     //         }
//     //     }
//     // });
//     notificationTrigger.addEventListener('click', function (e) {
//         e.preventDefault();
//         e.stopPropagation();
//         console.log('Đã nhấp vào nút thông báo');

//         // Tải thông báo
//         fetchNotifications();

//         // Tự xử lý dropdown
//         const dropdown = this.closest('.notification-wrapper').querySelector('.dropdown-menu');
//         if (dropdown) {
//             console.log('Dropdown element found:', dropdown);

//             // Kiểm tra xem dropdown đã hiển thị chưa bằng cách kiểm tra style thực tế
//             const computedStyle = window.getComputedStyle(dropdown);
//             const isVisible = computedStyle.display !== 'none';
//             console.log('Dropdown is currently visible (actual):', isVisible);

//             // Đóng tất cả dropdown khác nếu có
//             document.querySelectorAll('.dropdown-menu.show').forEach(function (item) {
//                 if (item !== dropdown) {
//                     item.classList.remove('show');
//                     item.style.cssText = 'display: none !important;';
//                 }
//             });

//             // Toggle dropdown hiện tại
//             if (isVisible) {
//                 dropdown.classList.remove('show');
//                 dropdown.style.cssText = 'display: none !important;';
//             } else {
//                 dropdown.classList.add('show');
//                 // Sử dụng cssText để ghi đè tất cả style
//                 dropdown.style.cssText = 'display: block !important; visibility: visible !important; opacity: 1 !important; z-index: 1050; position: fixed;';

//                 // Định vị dropdown đúng cách
//                 positionDropdown(dropdown, this);
//             }

//             // Debug: Kiểm tra style sau khi thay đổi
//             console.log('After toggle - display:', window.getComputedStyle(dropdown).display);
//             console.log('After toggle - class list:', dropdown.classList.contains('show'));
//         }
//     });
//     // Đóng dropdown khi click ra ngoài
//     document.addEventListener('click', function (e) {
//         if (!e.target.closest('.notification-wrapper')) {
//             document.querySelectorAll('.dropdown-menu.show').forEach(function (dropdown) {
//                 dropdown.classList.remove('show');
//             });
//         }
//     });

//     // Xử lý nút đánh dấu tất cả là đã đọc
//     if (markAllReadBtn) {
//         markAllReadBtn.addEventListener('click', function (e) {
//             e.preventDefault();
//             e.stopPropagation();
//             console.log('Đánh dấu tất cả thông báo đã đọc');
//             markAllAsRead();
//         });
//     }

//     // Tải thông báo ban đầu
//     fetchNotifications();

//     // Làm mới thông báo mỗi phút
//     setInterval(fetchNotifications, 60000);

//     // FUNCTIONS

//     // Xác định vai trò người dùng
//     function determineUserRole() {
//         // Phương pháp 1: Kiểm tra từ data attribute trên body
//         if (document.body.dataset.role) {
//             return document.body.dataset.role;
//         }

//         // Phương pháp 2: Kiểm tra từ URL
//         const currentPath = window.location.pathname;
//         if (currentPath.includes('/doctor')) {
//             return 'doctor';
//         } else if (currentPath.includes('/user')) {
//             return 'user';
//         }

//         // Phương pháp 3: Kiểm tra từ meta tag
//         const metaRole = document.querySelector('meta[name="user-role"]');
//         if (metaRole) {
//             return metaRole.content;
//         }

//         // Phương pháp 4: Kiểm tra từ class hoặc ID trên trang
//         if (document.querySelector('.doctor-dashboard, .doctor-profile, .doctor-menu')) {
//             return 'doctor';
//         }

//         // Mặc định là 'user' nếu không xác định được
//         return 'user';
//     }

//     // Định vị dropdown
//     // function positionDropdown(dropdown, trigger) {
//     //     const triggerRect = trigger.getBoundingClientRect();
//     //     const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

//     //     // Đặt vị trí dropdown
//     //     dropdown.style.position = 'absolute';
//     //     dropdown.style.top = (triggerRect.bottom + scrollTop) + 'px';

//     //     // Căn chỉnh dropdown theo chiều ngang
//     //     const viewportWidth = window.innerWidth;
//     //     const dropdownWidth = dropdown.offsetWidth || 320; // Mặc định width nếu không tính được

//     //     // Kiểm tra xem dropdown có thể hiển thị đầy đủ không
//     //     let leftPosition;

//     //     if (triggerRect.left + dropdownWidth > viewportWidth) {
//     //         // Nếu không đủ chỗ bên phải, căn phải dropdown
//     //         leftPosition = Math.max(5, viewportWidth - dropdownWidth - 5);
//     //     } else {
//     //         // Căn dropdown để biểu tượng nằm vào giữa
//     //         leftPosition = triggerRect.left - (dropdownWidth - triggerRect.width) / 2;

//     //         // Đảm bảo dropdown không ra ngoài màn hình bên trái
//     //         leftPosition = Math.max(5, leftPosition);

//     //         // Đảm bảo dropdown không ra ngoài màn hình bên phải
//     //         if (leftPosition + dropdownWidth > viewportWidth) {
//     //             leftPosition = viewportWidth - dropdownWidth - 5;
//     //         }
//     //     }

//     //     dropdown.style.left = leftPosition + 'px';
//     //     dropdown.style.right = 'auto'; // Xóa right positioning nếu có
//     //     dropdown.style.zIndex = '1050';

//     //     console.log('Đã định vị dropdown tại:', {
//     //         top: dropdown.style.top,
//     //         left: dropdown.style.left
//     //     });
//     // }

//     // Sửa hàm định vị dropdown
//     function positionDropdown(dropdown, trigger) {
//         // Lấy thông tin vị trí của nút thông báo
//         const triggerRect = trigger.getBoundingClientRect();
//         const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
//         const scrollLeft = window.pageXOffset || document.documentElement.scrollLeft;

//         // Đặt vị trí dropdown
//         dropdown.style.position = 'fixed'; // Thay vì 'absolute'
//         dropdown.style.top = (triggerRect.bottom) + 'px';

//         // Căn chỉnh dropdown theo nút thông báo
//         const dropdownWidth = dropdown.offsetWidth || 320;

//         // Tính toán vị trí để dropdown nằm bên phải và dưới nút thông báo
//         let leftPosition = triggerRect.right - dropdownWidth;

//         // Đảm bảo dropdown không ra ngoài màn hình bên trái
//         leftPosition = Math.max(10, leftPosition);

//         dropdown.style.left = leftPosition + 'px';
//         dropdown.style.right = 'auto';
//         dropdown.style.zIndex = '1050';

//         console.log('Đã định vị lại dropdown tại:', {
//             top: dropdown.style.top,
//             left: dropdown.style.left,
//             triggerRect: {
//                 top: triggerRect.top,
//                 right: triggerRect.right,
//                 bottom: triggerRect.bottom,
//                 left: triggerRect.left
//             }
//         });
//     }

//     // Lấy thông báo chưa đọc
//     async function fetchNotifications() {
//         try {
//             console.log('Đang tải thông báo từ:', `${notificationBaseUrl}/notifications/unread`);

//             const response = await fetch(`${notificationBaseUrl}/notifications/unread`, {
//                 headers: {
//                     'X-CSRF-TOKEN': csrfToken,
//                     'Accept': 'application/json'
//                 }
//             });

//             if (!response.ok) {
//                 throw new Error(`API Error: ${response.status}`);
//             }

//             const contentType = response.headers.get("content-type");
//             if (!contentType || !contentType.includes("application/json")) {
//                 console.warn("Response không phải là JSON, có thể xảy ra lỗi khi xử lý.");

//                 if (contentType && contentType.includes("text/html")) {
//                     throw new Error("Server trả về HTML thay vì JSON. Có thể phiên đăng nhập đã hết hạn.");
//                 }
//             }

//             const data = await response.json();
//             updateNotificationBadge(data.unread_count);
//             updateNotificationDropdown(data.notifications);
//         } catch (error) {
//             console.error('Lỗi khi tải thông báo:', error);
//             if (notificationList) {
//                 notificationList.innerHTML = '<li class="text-center py-3 text-danger">Không thể tải thông báo</li>';
//             }

//             // Xóa badge nếu có lỗi
//             const badge = document.querySelector('.notification-badge');
//             if (badge) {
//                 badge.style.display = 'none';
//             }
//         }
//     }

//     // Cập nhật badge thông báo
//     function updateNotificationBadge(count) {
//         const badge = document.querySelector('.notification-badge');
//         if (badge) {
//             if (count > 0) {
//                 badge.textContent = count;
//                 badge.style.display = 'inline-block';
//             } else {
//                 badge.style.display = 'none';
//             }
//         }
//     }

//     // Lấy icon phù hợp với loại thông báo
//     function getIconForType(type) {
//         // Mặc định sử dụng biểu tượng thông báo
//         let icon = '<i class="fas fa-bell text-primary"></i>';

//         // Tùy chỉnh dựa trên loại thông báo
//         switch (type) {
//             case 'appointment':
//                 icon = '<i class="fas fa-calendar-check text-success"></i>';
//                 break;
//             case 'message':
//                 icon = '<i class="fas fa-envelope text-info"></i>';
//                 break;
//             case 'alert':
//                 icon = '<i class="fas fa-exclamation-triangle text-warning"></i>';
//                 break;
//         }

//         return icon;
//     }

//     // Cập nhật nội dung dropdown thông báo
//     function updateNotificationDropdown(notifications) {
//         if (!notificationList) return;

//         if (!notifications || notifications.length === 0) {
//             notificationList.innerHTML = '<li class="text-center py-3">Không có thông báo mới</li>';
//             return;
//         }

//         let html = '';
//         notifications.forEach(notification => {
//             // Kiểm tra notification.data tồn tại
//             if (!notification.data) {
//                 return; // Bỏ qua thông báo này
//             }

//             const data = notification.data;
//             const createdAt = new Date(notification.created_at);
//             const timeAgo = getTimeAgo(createdAt);

//             html += `
//             <li class="notification-item-container">
//                 <a class="dropdown-item notification-item py-2" href="${data.link || '#'}" data-id="${notification.id}">
//                     <div class="d-flex align-items-start">
//                         <div class="notification-icon me-3">
//                             ${getIconForType(data.type || 'default')}
//                         </div>
//                         <div class="notification-content">
//                             <div class="notification-message" style="word-wrap: break-word; white-space: normal;">${data.message || 'Thông báo mới'}</div>
//                             <div class="notification-time text-muted"><small>${timeAgo}</small></div>
//                         </div>
//                     </div>
//                 </a>
//             </li>`;
//         });

//         notificationList.innerHTML = html;

//         // Thêm sự kiện click cho từng thông báo
//         document.querySelectorAll('.notification-item').forEach(item => {
//             item.addEventListener('click', function (e) {
//                 const notificationId = this.dataset.id;
//                 if (notificationId) {
//                     markAsRead(notificationId);
//                 }
//             });
//         });
//     }

//     // Đánh dấu thông báo đã đọc
//     async function markAsRead(id) {
//         try {
//             await fetch(`${notificationBaseUrl}/notifications/mark-as-read/${id}`, {
//                 method: 'POST',
//                 headers: {
//                     'X-CSRF-TOKEN': csrfToken,
//                     'Content-Type': 'application/json',
//                     'Accept': 'application/json'
//                 }
//             });
//             // Sau khi đánh dấu đã đọc, cập nhật lại danh sách thông báo
//             fetchNotifications();
//         } catch (error) {
//             console.error('Lỗi khi đánh dấu thông báo:', error);
//         }
//     }

//     // Đánh dấu tất cả thông báo đã đọc
//     async function markAllAsRead() {
//         try {
//             await fetch(`${notificationBaseUrl}/notifications/mark-all-read`, {
//                 method: 'POST',
//                 headers: {
//                     'X-CSRF-TOKEN': csrfToken,
//                     'Content-Type': 'application/json',
//                     'Accept': 'application/json'
//                 }
//             });
//             // Sau khi đánh dấu tất cả đã đọc, cập nhật lại danh sách thông báo
//             fetchNotifications();
//         } catch (error) {
//             console.error('Lỗi khi đánh dấu tất cả thông báo:', error);
//         }
//     }

//     // Định dạng thời gian
//     function getTimeAgo(date) {
//         const seconds = Math.floor((new Date() - date) / 1000);
//         let interval = Math.floor(seconds / 60);
//         if (interval < 1) return "Vừa xong";
//         if (interval < 60) return `${interval} phút trước`;
//         interval = Math.floor(interval / 60);
//         if (interval < 24) return `${interval} giờ trước`;
//         interval = Math.floor(interval / 24);
//         return `${interval} ngày trước`;
//     }
// }


document.addEventListener('DOMContentLoaded', function () {
    const notificationTrigger = document.querySelector('.notification-trigger');
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    const notificationList = document.getElementById('notification-list');
    const markAllReadBtn = document.querySelector('.mark-all-read-btn');
    const notificationBaseUrl = document.body.dataset.role === 'doctor' ? '/doctor' : '/user';

    // Fetch notifications
    async function fetchNotifications() {
        try {
            const response = await fetch(`${notificationBaseUrl}/notifications/unread`, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            updateNotificationDropdown(data.notifications);
        } catch (error) {
            console.error('Error fetching notifications:', error);
        }
    }

    // Update notification dropdown content
    function updateNotificationDropdown(notifications) {
        if (!notifications.length) {
            notificationList.innerHTML = '<li class="p-2 text-center"><small>Không có thông báo mới</small></li>';
            return;
        }

        notificationList.innerHTML = notifications.map(notification => `
            <li>
                <a class="dropdown-item" href="${notification.data.link || '#'}">
                    ${notification.data.message}
                </a>
            </li>`).join('');
    }

    // Toggle dropdown using Bootstrap API
    if (notificationTrigger) {
        notificationTrigger.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            fetchNotifications();

            const dropdownInstance = bootstrap.Dropdown.getOrCreateInstance(notificationTrigger);
            dropdownInstance.toggle();
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.notification-wrapper')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(function (dropdown) {
                bootstrap.Dropdown.getOrCreateInstance(dropdown).hide();
            });
        }
    });

    // Mark all notifications as read
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', async function (e) {
            e.preventDefault();
            try {
                await fetch(`${notificationBaseUrl}/notifications/mark-all-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });
                fetchNotifications();
            } catch (error) {
                console.error('Error marking all as read:', error);
            }
        });
    }
});
