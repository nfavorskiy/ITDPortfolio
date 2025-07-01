<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    @include('layouts.navigation')

    @if(session('login_success'))
        <div id="login-notification" class="alert alert-success alert-dismissible fade show position-fixed" style="top: 80px; right: 20px; z-index: 1050; min-width: 300px;">
            <strong>Welcome!</strong> You are now logged in.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <main class="container py-4">
        @yield('content')
    </main>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const notification = document.getElementById('login-notification');
        if (notification) {
            // Auto fade after 3 seconds
            setTimeout(function() {
                notification.classList.remove('show');
                setTimeout(function() {
                    notification.remove();
                }, 150); // Wait for fade transition
            }, 3000);
        }
    });
    </script>
</body>
</html>
