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
    <button id="backToTop" class="back-to-top" title="Back to Top">
        <i class="fa fa-angle-up"></i>
    </button>
    <script>
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
    </script>


    </script>
    <script src="{{ asset('js/notification.js') }}"></script>
</body>

</html>
