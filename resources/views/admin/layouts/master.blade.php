<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Pilo</title>
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <meta name="msapplication-TileColor" content="#206bc4"/>
    <meta name="theme-color" content="#206bc4"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="HandheldFriendly" content="True"/>
    <meta name="MobileOptimized" content="320"/>
    <meta name="robots" content="noindex,nofollow,noarchive"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
    <link href="/resources/admin/css/tabler.min.css" rel="stylesheet"/>
{{--    <link href="/resources/admin/css/demo.min.css" rel="stylesheet"/>--}}
    <link href="/resources/admin/css/custom.css" rel="stylesheet"/>
    @yield('styles')
</head>
<body class="antialiased">
<div class="page">
    @include('admin.layouts.partials.header')
    @include('admin.layouts.partials.alert')
    <div class="content">
        <div class="container-xl">
            @yield('content')
        </div>
    </div>
</div>


<script src="/resources/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="/resources/admin/libs/jquery/dist/jquery.slim.min.js"></script>
<script src="/resources/admin/js/tabler.min.js"></script>
@yield('scripts')
</body>
</html>
