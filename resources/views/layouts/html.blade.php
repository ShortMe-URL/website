<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="./images/link.svg" type="image/x-icon" sizes="16x16">
    {{-- META OG --}}
    <meta name="description" content="">
    <meta name="og:description" content="">
    <meta name="og:title" content="">
    <meta name="og:image" content="">

    {{-- <title>ShortMe{{ !empty($title) ? ' - ' . $title : '' }}</title> --}}
    @hasSection('title')
        <title>ShortMe - @yield('title')</title>
    @else
        <title>ShortMe</title>
    @endif

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.2/css/all.css">

    @vite('resources/css/normalize.css')
    @vite('resources/css/app.css')
    @vite('resources/css/navbar.css')

    @yield('head')
</head>

<body>
    @include("layouts.nav")

    @yield('body')

    @include("layouts.footer")

    @vite('/resources/js/app.js')
    @yield('js')
</body>

</html>
