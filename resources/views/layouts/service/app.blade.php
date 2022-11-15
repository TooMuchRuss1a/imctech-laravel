<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/ui/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/ui/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <script async src="https://www.googletagmanager.com/gtag/js?id=G-MPV9RSCKXV"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-MPV9RSCKXV');
    </script>
    <script src="/js/cookie.js"></script>

    <link rel="icon" href="/img/imctech_icon.png">
</head>
<body>

    @if(session('modal'))
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">{{session('modal')['title']}}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @foreach(session('modal')['links'] as $key => $value)
                        <div class="modal-body">
                            {{$key}} - <a target="_blank" href="{{$value}}">{{$value}}</a>
                        </div>
                    @endforeach
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Сделано</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div id="app">
        <div id="cookieNotice" class="alert alert-primary" style="display: none;flex-direction: row;justify-content: space-between;">
            <div>Мы используем cookie! Оставаясь на сайте, вы соглашаетесь с <a class="link-primary" href="{{route('privacy')}}">Политикой в отношении обработки персональных данных</a></div>
            <button type="button" class="btn-close" aria-label="Close" onclick="acceptCookie()"></button>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('service') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @auth
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->login }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endauth
                        <li class="nav-bar nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Вернуться</a>
                            @guest
                                <hr style="margin: 8px 0;">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Войти') }}</a>
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Регистрация') }}</a>
                            @else
                                @if(auth()->user()->hasVerifiedEmail())
                                    <hr style="margin: 8px 0;">
                                    <a class="nav-link" href="{{ route('service.activity') }}">Записаться на мероприятие</a>
                                    @can('view admin')
                                        <hr style="margin: 8px 0;">
                                        @can('view logs')
                                            <a class="nav-link" href="{{ route('admin.audits') }}">Аудит</a>
                                            <a class="nav-link" href="{{ route('admin.api') }}">Api</a>
                                            <a class="nav-link" href="{{ route('admin.errors') }}">Ошибки</a>
                                        @endcan
                                        @can('view users')
                                            <a class="nav-link" href="{{ route('admin.users') }}">Пользователи</a>
                                        @endcan
                                        @can('view events')
                                            <a class="nav-link" href="{{ route('admin.events') }}">Мероприятия</a>
                                        @endcan
                                        @can('edit timetable')
                                            <a class="nav-link" href="{{ route('admin.timetable.index') }}">Расписание</a>
                                        @endcan
                                        @can('getlost')
                                            <a class="nav-link" href="{{ route('admin.getlost') }}">Потеряшки</a>
                                        @endcan
                                        @can('dead souls')
                                            <a class="nav-link" href="{{ route('admin.dead_souls') }}">Мертвые души</a>
                                        @endcan
                                        @can('edit roles')
                                            <a class="nav-link" href="{{ route('admin.roles') }}">Роли</a>
                                        @endcan
                                    @endcan
                                @endif
                            @endguest
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4 d-inline-flex align-items-baseline m-auto">
                    <div class="side-bar border-top card m-lg-4" style="width: 16%">
                        <nav class="nav flex-column">
                            <a class="nav-link" href="{{ route('home') }}">Вернуться</a>
                            @guest
                                <hr style="margin: 2px 0;">
                                <a class="nav-link" href="{{ route('login') }}">Войти</a>
                                <a class="nav-link" href="{{ route('register') }}">Регистрация</a>
                            @endguest
                            @auth
                                @if(auth()->user()->hasVerifiedEmail())
                                    <hr style="margin: 2px 0;">
                                    <a class="nav-link" href="{{ route('service.activity') }}">Записаться на мероприятие</a>
                                    @can('view admin')
                                        <hr style="margin: 8px 0;">
                                        @can('view logs')
                                            <a class="nav-link" href="{{ route('admin.audits') }}">Аудит</a>
                                            <a class="nav-link" href="{{ route('admin.api') }}">Api</a>
                                            <a class="nav-link" href="{{ route('admin.errors') }}">Ошибки</a>
                                        @endcan
                                        @can('view users')
                                            <a class="nav-link" href="{{ route('admin.users') }}">Пользователи</a>
                                        @endcan
                                        @can('view events')
                                            <a class="nav-link" href="{{ route('admin.events') }}">Мероприятия</a>
                                        @endcan
                                        @can('edit timetable')
                                            <a class="nav-link" href="{{ route('admin.timetable.index') }}">Расписание</a>
                                        @endcan
                                        @can('getlost')
                                            <a class="nav-link" href="{{ route('admin.getlost') }}">Потеряшки</a>
                                        @endcan
                                        @can('dead souls')
                                            <a class="nav-link" href="{{ route('admin.dead_souls') }}">Мертвые души</a>
                                        @endcan
                                        @can('edit roles')
                                            <a class="nav-link" href="{{ route('admin.roles') }}">Роли</a>
                                        @endcan
                                    @endcan
                                @endif
                            @endauth
                        </nav>
                    </div>
            @yield('content')
        </main>
    </div>
    <div class="container">
        <footer class="py-3 my-4">
            <ul class="nav justify-content-center border-bottom pb-3 mb-3">
                <li class="nav-item"><a href="{{route('privacy')}}" class="nav-link px-2 text-muted">Политика в отношении персональных данных</a></li>
            </ul>
            <p class="text-center text-muted">IMCTechService</p>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="https://github.com/jquery/jquery-ui/blob/main/ui/i18n/datepicker-ru.js"></script>
    <script>
        $.datepicker.regional['ru'] = {
            closeText: 'Закрыть', // set a close button text
            currentText: 'Сегодня', // set today text
            monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь', 'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'], // set month names
            monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн','Июл','Авг','Сен','Окт','Ноя','Дек'], // set short month names
            dayNames: ['Воскресенье','Понедельник','Вторник','Среда','Четверг','Пятница','Суббота'], // set days names
            dayNamesShort: ['Вск','Пон','Вто','Сре','Чет','Пят','Суб'], // set short day names
            dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'], // set more short days names
            dateFormat: 'yy-mm-dd', // set format date
            firstDay: 1,
        };

        $.datepicker.setDefaults($.datepicker.regional['ru']);

        $( function() {
            $('.datepicker').datepicker({
                showOtherMonths: true,
                selectOtherMonths: true
            });
        });
    </script>
    <script>
        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
        }
    </script>
    <script type="text/javascript">
        $(window).on('load', function() {
            $('#staticBackdrop').modal('show');
        });
    </script>

</body>
</html>
