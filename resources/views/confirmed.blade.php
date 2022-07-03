@extends('layouts.app')

@section('head')
    <title>IMCTech - Регистрация</title>
    <meta charset="UTF-8">
    <meta property="og:type"             content="article"/>
    <meta property="og:locale"           content="ru_RU"/>
    <meta property="og:site_name"        content="IMCTech"/>
    <meta property="og:title"            content="JOIN US"/>
    <meta property="og:description"      content="Строим цифровое будущее"/>
    <meta property="og:url"              content="https://imctech.ru/"/>
    <meta property="og:image"            content="https://imctech.ru/img/main.jpg"/>
    <meta property="og:image:secure_url" content="https://imctech.ru/img/main.jpg"/>
    <meta property="og:image:type"       content="image/jpeg"/>

    <link rel="stylesheet" href="/css/confirm.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/confirm_mobile.css">
    <script src="/js/nav.js"></script>
    <meta http-equiv="Refresh" content="10; URL=https://imctech.ru/login">
@endsection

@section('content')
    <div class="box">
        <img src="/img/fedya1.png" class="fedya1-d">
        <div class="box-container">
            <h1 class="box-name">Регистрация прошла успешно</h1>
            <div class="box-text">Теперь вы можете авторизоваться в системе IMCTech и пользоваться ее сервисами</div>
            <div class="box-text">Ваш логин = почта без @students.dvfu.ru</div>
            <div class="box-text"><text>Перенаправляем вас на страницу авторизации...</text></div>
        </div>
        <img src="/img/fedya1.png" class="fedya1-m">
    </div>
@endsection

@section('footer')
    @parent
@endsection
