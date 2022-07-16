@extends('layouts.app')

@section('head')
    <title>IMCTech</title>
    <meta charset="UTF-8">
    <meta property="og:type" content="article" />
    <meta property="og:locale" content="ru_RU" />
    <meta property="og:site_name" content="IMCTech" />
    <meta property="og:title" content="JOIN US" />
    <meta property="og:description" content="Строим цифровое будущее" />
    <meta property="og:url" content="https://imctech.ru/" />
    <meta property="og:image" content="https://imctech.ru/img/main.jpg" />
    <meta property="og:image:secure_url" content="https://imctech.ru/img/main.jpg" />
    <meta property="og:image:type" content="image/jpeg" />

    <link rel="stylesheet" href="/css/form.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/form_mobile.css">
    <script src="/js/nav.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" href="/css/recaptcha.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/recaptcha_mobile.css">
@endsection

@section('content')
    <div class="reg-box">
        <div class="regname">Заявка
            <div style="margin: 0 0 0 0;">{{{$error}}}</div>
            <div style="color: white; opacity: 0.8;">{{{$user->name}}}</div>
            <div style="color: white;">Если желаешь принять участие в Проектной сессии 2022, то нажми "Участвовать"</div>
        </div>
        <form name="frmContact" method="post" action="{{ route('psessionReg')}}">
        @csrf
        <input class="prikol" type="submit" name="prikol" id="Submit" value="Участвовать">
        </form>
    </div>
@endsection
