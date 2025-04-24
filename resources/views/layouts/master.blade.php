@php
    $isLoggedInAsDoctor = Auth::guard('doctor')->check();
    $isLoggedInAsUser = Auth::guard('web')->check();

    $role = $isLoggedInAsDoctor ? 'doctor' : ($isLoggedInAsUser ? 'user' : session('role'));
    $notificationCount = 0;
    if ($isLoggedInAsDoctor) {
        $notificationCount = Auth::guard('doctor')->user()->unreadNotifications->count();
    } elseif ($isLoggedInAsUser) {
        $notificationCount = Auth::guard('web')->user()->unreadNotifications->count();
    }
@endphp
<!DOCTYPE html>
<html lang="vi">

<head>
    @include('layouts.head')
</head>

<body data-role="{{ $role }}">
    <!-- Header -->
    @include('layouts.header')

    <!-- Nội dung chính -->
    @yield('main-content')

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Scripts -->
    @yield('scripts')
    <div class="contact-quick-actions">
        <div class="contact-quick-actions-container">
            <!-- Nút Zalo -->
            <a href="https://zalo.me/" target="_blank" class="contact-btn zalo-btn">
                <img src="{{ asset('asset/images/icon/zalo_icon.png') }}" alt="Zalo">
                <span>Zalo</span>
            </a>

            <!-- Nút Điện thoại -->
            <a href="tel:+84123456789" class="contact-btn phone-btn">
                <img src="{{ asset('asset/images/icon/phone_icon.png') }}" alt="Phone">
                <span>Gọi ngay</span>
            </a>

            <!-- Nút Messenger -->
            <a href="https://m.me/YOUR_FACEBOOK_PAGE" target="_blank" class="contact-btn messenger-btn">
                <img src="{{ asset('asset/images/icon/message_icon.png') }}" alt="Mess">
                <span>Messenger</span>
            </a>
        </div>

        <!-- Nút mở/đóng các liên hệ nhanh -->
        <button class="toggle-contact-actions">
            <i class="fas fa-comment-dots"></i>
        </button>
    </div>
    <button id="backToTop" class="back-to-top" title="Back to Top">
        <i class="fa fa-angle-up"></i>
    </button>
    {{-- <script>
        // Lấy phần tử nút "Back to Top"
        var backToTopButton = document.getElementById("backToTop");

        // Khi người dùng cuộn xuống 100px từ trên cùng của trang, hiển thị nút
        window.onscroll = function() {
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                backToTopButton.style.display = "block"; // Hiển thị nút
            } else {
                backToTopButton.style.display = "none"; // Ẩn nút
            }
        };

        // Khi người dùng nhấn nút, cuộn trang lên đầu
        backToTopButton.onclick = function() {
            document.body.scrollTop = 0; // Cuộn trang lên đầu (Safari)
            document.documentElement.scrollTop = 0; // Cuộn trang lên đầu (Chrome, Firefox, IE)
        };
    </script> --}}
    <script>
        // Quản lý nút liên hệ nhanh
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.querySelector('.toggle-contact-actions');
            const contactContainer = document.querySelector('.contact-quick-actions-container');

            toggleBtn.addEventListener('click', function() {
                contactContainer.classList.toggle('show');
                toggleBtn.classList.toggle('active');
            });

            // Back to Top script giữ nguyên
            var backToTopButton = document.getElementById("backToTop");
            window.onscroll = function() {
                if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                    backToTopButton.style.display = "block";
                } else {
                    backToTopButton.style.display = "none";
                }
            };

            backToTopButton.onclick = function() {
                document.body.scrollTop = 0;
                document.documentElement.scrollTop = 0;
            };
        });
    </script>


    </script>
    <script src="{{ asset('js/notification.js') }}"></script>
</body>

</html>
