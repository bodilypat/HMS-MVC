<!DOCTYPE html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>{{ config('app.name', 'Library Management System ') }}</title>
        <!-- CSRF token -->
        <meta name="csrf-token" href="{{ csrf-token() }}">
         <!-- bootstrap -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
        <!-- custom style -->
        <link rel="stylessheet" href="{{ asset('css/styles.css') }}">
    </head>
    <body>
        @yield('content')
    </body>
</html>
