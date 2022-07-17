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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/css/admin.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/admin_mobile.css">

@yield('head')
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light border">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Выход</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <div class="collapse navbar-collapse"></div>
            <span class="navbar-text">
                {{{$user->login}}}
            </span>
        </div>
    </div>
</nav>
<div class="leftpanel border-top">
    <nav class="nav flex-column">
{{--        <a class="nav-link" aria-current="page" href="#">Active</a>--}}
{{--        <a class="nav-link" href="#">Link</a>--}}
{{--        <a class="nav-link" href="#">Link</a>--}}
{{--        <a class="nav-link disabled">Disabled</a>--}}
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Таблицы
            </a>
            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <li><a class="dropdown-item" href="/admin/table/reg">Основная <span class="badge bg-primary rounded-pill">{{{$data['tbl_reg']}}}</span></a></li>
                <li><a class="dropdown-item" href="/admin/table/psession2022">ПС2022 <span class="badge bg-primary rounded-pill">{{{$data['tbl_psession2022']}}}</span></a></li>
                <li><a class="dropdown-item" href="/admin/table/springpschool2022">ВПШ2022 <span class="badge bg-primary rounded-pill">{{{$data['tbl_springpschool2022']}}}</span></a></li>
            </ul>
        </li>
    </nav>
</div>
<!-- Navbar -->
<div class="rightpanel border" style="border-right: 0!important;">
@yield('content')
</div>
</body>
</html>
