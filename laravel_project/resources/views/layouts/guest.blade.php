<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CafeKu') }}</title>
    @yield('head')
    </head>
<body style="margin:0;padding:0;min-height:100vh;">
    @yield('content')
    </body>
</html>
