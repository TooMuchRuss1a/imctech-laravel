@extends('layouts.app')

@section('head')
    <title>IMCTech - Регистрация</title>
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

    <link rel="stylesheet" href="/css/registration.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/registration_mobile.css">
    <script src="/js/nav.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" href="/css/recaptcha.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/recaptcha_mobile.css">
@endsection

@section('content')
    <div class="reg-box">
        <div class="regname">Регистрация
            <div class="error">{{{$error}}}</div>
        </div>
        <form name="frmContact" method="post" action="{{ route('registration')}}">
            @csrf
            <div class="user-box">
                <input type="text" name="email" required="" autocomplete="off" value="@if (!empty($data['email'])){{{$data['email']}}}@endif">
                <label>Почта ДВФУ</label>
                <div>ivanov.ii@students.dvfu.ru</div>
            </div>
            <div class="user-box">
                <input type="password" name="pass" required="" autocomplete="off">
                <label>Придумайте пароль</label>
                <div>***</div>
            </div>
            <div class="user-box">
                <input type="password" name="pass_rep" required="" autocomplete="off">
                <label>Повторите пароль</label>
                <div>***</div>
            </div>
            <div class="user-box">
                <input type="text" name="name" required="" autocomplete="off" value="@if (!empty($data['name'])){{{$data['name']}}}@endif">
                <label>ФИО</label>
                <div>Иванов Иван Иванович</div>
            </div>
            <div class="user-box">
                <input type="text" name="agroup" required="" autocomplete="off" value="@if (!empty($data['agroup'])){{{$data['agroup']}}}@endif">
                <label>Группа</label>
                <div>Б1234-01.01.01при</div>
            </div>
            <div class="user-box">
                <input type="text" name="vk" required="" autocomplete="off" value="@if (!empty($data['vk'])){{{$data['vk']}}}@endif">
                <label>Ссылка на ВК</label>
                <div>https://vk.com/durov</div>
            </div>
            <div class="g-recaptcha" data-theme="dark" data-sitekey="6LcYs80eAAAAAHcpAI3xP1tKPyGWUXgX01K2Y75R"></div>
            <input class="prikol" type="submit" name="Submit" id="Submit" value="Зарегистрироваться">
        </form>
    </div>
@endsection
