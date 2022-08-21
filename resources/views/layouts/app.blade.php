<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MPV9RSCKXV"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-MPV9RSCKXV');
    </script>

    <link rel="icon" href="/img/imctech_icon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa&family=Montserrat:wght@400;800&family=Press+Start+2P&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/app_mobile.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <script src="/js/app.js"></script>
    <script src="/js/main.js"></script>
    <script src="/js/cookie.js"></script>

@yield('head')
</head>

<body>
    <div id="cookieNotice" class="notice">
        <div class="notice_text">Мы используем cookie! Оставаясь на сайте, вы соглашаетесь с <a class="link" href="{{route('privacy')}}">Политикой в отношении обработки персональных данных</a></div>
        <button type="button" class="close" aria-label="Close" onclick="acceptCookie()"></button>
    </div>
    @include('inc.header')
    <div class="se-pre-con">
        <div class="gooey">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    @yield('content')
    @include('inc.footer')
</body>

</html>
