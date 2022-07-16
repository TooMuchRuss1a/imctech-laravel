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
        <div class="regname">Восстановление
            <div style="margin: 0 0 0 0;">{{{$error}}}</div>
            <div class="reg"><a rel="noopener noreferrer" target="_blank" href="/registration">Регистрация</a></div>
        </div>
        <form name="frmContact" method="post" action="{{route('vospassHash', $hash)}}">
            @csrf
            <div class="user-box">
                <input type="password" name="new_pass" required="" autocomplete="off">
                <label>Новый пароль</label>
                <div>***</div>
            </div>
            <div class="user-box">
                <input type="password" name="new_pass_rep" required="" autocomplete="off">
                <label>Повторите пароль</label>
                <div>***</div>
            </div>
            <div class="g-recaptcha" data-theme="dark" data-sitekey="6LcYs80eAAAAAHcpAI3xP1tKPyGWUXgX01K2Y75R"></div>
            <input class="prikol" type="submit" name="Submit" id="Submit" value="Войти">
        </form>
    </div>
@endsection
