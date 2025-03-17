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
    <script src="{{ asset('js/notification.js') }}"></script>
</body>

</html>
