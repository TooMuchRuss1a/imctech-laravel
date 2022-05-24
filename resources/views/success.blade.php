@extends('layouts.app')

@section('head')
    <title>IMCTech</title>
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
    <meta http-equiv="Refresh" content="4; URL=https://imctech.ru/">
    
    <link rel="stylesheet" href="/css/success.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/success_mobile.css">
    <script src="/js/nav.js"></script>
@endsection

@section('content')
    <div class="box">
      <img src="/img/fedya1.png" class="fedya1-d">
      <div class="box-container">
            <h1 class="box-name">Вы вошли</h1>
            <div class="box-text">Теперь вы можете пользоваться сервисами IMCTech</div>
            <div class="box-text"><text>Перенаправляем вас на главную страницу...</text></div>
      </div>
      <img src="/img/fedya1.png" class="fedya1-m">
    </div>
@endsection