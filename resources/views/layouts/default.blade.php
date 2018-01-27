<!DOCTYPE html>
<html>
    <head>
        <title>@yield('title', '主页') - Laravel 学习之路</title>
        <link rel="stylesheet" href="/css/app.css?ver=1.1">
    </head>
    <body>
            @include('layouts.header')

        <div class="container">
            <div class="col-md-offset-1 col-md-10">
                @include('shared.messages')
                @yield('content')
                @include('layouts.footer')
            </div>
        </div>
        <script src="/js/app.js"></script>
    </body>
</html>