<!DOCTYPE html>
<html lang="vi">

<head>
    @include('layouts.head')
</head>

<body>
    <!-- Header -->
    @include('layouts.header')

    <!-- Nội dung chính -->
    @yield('main-content')

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
