<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @stack('styles')
</head>
<body class="font-sans antialiased min-h-screen bg-gray-900 text-white flex">

@auth
    @include('layouts.navigation')
@endauth

<main class="flex-1 overflow-auto h-screen py-8">
    {{ $slot }}
</main>

@if($errors->any())
    @php
        notify()->error($errors->first(), 'Whoops!');
    @endphp
@endif

{{--<x-notify-messages/>--}}

<script src="{{ mix('js/app.js') }}" defer></script>
@stack('scripts')
</body>
</html>
