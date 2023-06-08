<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8" />
    <title> @yield('title') | System Idea Konsultan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content="System Idea Konsultan" name="description" />
    <meta content="Era Konsultan" name="author" />
    <!-- App favicon -->
    <link rel="icon" type="image/jpg" href="{{ asset('assets/images/idea-konsultan-tanpa-bg.png') }}"
        sizes="16x16">

    @include('layouts.head-css')
</head>

@yield('body')

@yield('content')

@include('layouts.vendor-scripts')
</body>

</html>
