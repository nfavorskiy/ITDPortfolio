<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <main class="py-4">
        {{ $slot }}
    </main>
</body>
</html>
