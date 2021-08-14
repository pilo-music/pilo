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
    <!-- CSS files -->
    <link href="/resources/admin/css/tabler.min.css" rel="stylesheet"/>
    <link href="/resources/admin/css/demo.min.css" rel="stylesheet"/>
    <style>
        body {
            display: none;
        }
    </style>
    @yield('styles')
</head>
<body class="antialiased">
<div class="page">
    @include('admin.layouts.partials.header')
    @if (session()->has('admin_message_text'))
        <div class="alert alert-{{ session()->get('admin_message_class') }}">
            {{ session()->get('admin_message_text') }}
        </div>
    @endif
    <div class="content">
        <div class="container-xl">
            @yield('content')
        </div>
        @include('admin.layouts.partials.footer')
    </div>
</div>
<!-- Libs JS -->
<script src="/resources/admin/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="/resources/admin/libs/jquery/dist/jquery.slim.min.js"></script>
<!-- Tabler Core -->
<script src="/resources/admin/js/tabler.min.js"></script>
<script>
    document.body.style.display = "block"
</script>

@yield('scripts')
</body>
</html>
