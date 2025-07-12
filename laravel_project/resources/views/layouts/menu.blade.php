<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Noir Cafe') }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700&display=swap" rel="stylesheet">
    <!-- AdminLTE CSS (optional, jika dipakai) -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        html, body {
            min-height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #18181c 0%, #232526 100%) !important;
            color: #fff !important;
            font-family: 'Montserrat', 'Lato', sans-serif !important;
        }
        body {
            width: 100vw;
            min-height: 100vh;
            overflow-x: hidden;
        }
        main {
            width: 100vw;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <main>
        @yield('content')
    </main>
</body>
</html> 