@php
    $isLoggedInAsDoctor = Auth::guard('doctor')->check();
    $isLoggedInAsUser = Auth::guard('web')->check();

    $role = $isLoggedInAsDoctor ? 'doctor' : ($isLoggedInAsUser ? 'user' : session('role'));
    $notificationCount = $isLoggedInAsDoctor
        ? Auth::guard('doctor')->user()->unreadNotifications->count()
        : ($isLoggedInAsUser
            ? Auth::guard('web')->user()->unreadNotifications->count()
            : 0);
@endphp

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang web của bạn')</title>

    <!-- Common CSS -->
    @include('layouts.head')

    <!-- DataTables (nếu dùng) -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Select2 & Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    <!-- AI Chatbot CSS -->
    <link rel="stylesheet" href="{{ asset('css/ai_chatbot.css') }}">

    @stack('styles') {{-- Cho phép thêm CSS từ view con --}}
</head>

<body data-role="{{ $role }}">

    {{-- Header --}}
    @include('layouts.header')

    {{-- Nội dung chính --}}
    @yield('main-content')

    {{-- Footer --}}
    @include('layouts.footer')

    {{-- Nút liên hệ nhanh --}}
    <div class="contact-quick-actions">
        <div class="contact-quick-actions-container">
            <a href="https://zalo.me/" target="_blank" class="contact-btn zalo-btn">
                <img src="{{ asset('asset/images/icon/zalo_icon.png') }}" alt="Zalo">
                <span>Zalo</span>
            </a>
            <a href="tel:+84123456789" class="contact-btn phone-btn">
                <img src="{{ asset('asset/images/icon/phone_icon.png') }}" alt="Phone">
                <span>Gọi ngay</span>
            </a>
            <a href="https://m.me/YOUR_FACEBOOK_PAGE" target="_blank" class="contact-btn messenger-btn">
                <img src="{{ asset('asset/images/icon/message_icon.png') }}" alt="Mess">
                <span>Messenger</span>
            </a>
        </div>
        <button class="toggle-contact-actions">
            <i class="fas fa-comment-dots"></i>
        </button>
    </div>

    {{-- Back to Top --}}
    <button id="backToTop" class="back-to-top" title="Back to Top">
        <i class="fa fa-angle-up"></i>
    </button>

    {{-- AI Chatbot --}}
    @include('partials.ai_chatbot')

    {{-- jQuery & Bootstrap --}}
    @if (!isset($skipJquery))
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @endif

    {{-- DataTables --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    {{-- Select2 & Swiper --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    {{-- App JS --}}
    <script src="{{ asset('js/notification.js') }}"></script>
    <script src="{{ asset('js/ai_chatbot.js') }}"></script>

    {{-- Script riêng cho từng trang --}}
    @yield('scripts')

    {{-- Script chèn thêm nếu dùng @push('scripts') --}}
    @stack('scripts')

    {{-- Inline script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Master layout loaded');

            const toggleBtn = document.querySelector('.toggle-contact-actions');
            const contactContainer = document.querySelector('.contact-quick-actions-container');

            if (toggleBtn && contactContainer) {
                toggleBtn.addEventListener('click', () => {
                    contactContainer.classList.toggle('show');
                    toggleBtn.classList.toggle('active');
                });
            }

            const backToTopButton = document.getElementById("backToTop");
            if (backToTopButton) {
                window.addEventListener('scroll', () => {
                    backToTopButton.style.display =
                        (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) ?
                        "block" : "none";
                });

                backToTopButton.addEventListener('click', () => {
                    document.body.scrollTop = 0;
                    document.documentElement.scrollTop = 0;
                });
            }
        });

        window.addEventListener('error', e => {
            console.error('JavaScript Error:', e.error);
        });

        window.addEventListener('unhandledrejection', e => {
            console.error('Unhandled Promise Rejection:', e.reason);
        });
    </script>
</body>

</html>
