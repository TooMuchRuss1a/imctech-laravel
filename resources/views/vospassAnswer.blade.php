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

    <link rel="stylesheet" href="/css/confirm.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/confirm_mobile.css">
    <script src="/js/nav.js"></script>
@endsection

@section('content')
    <div class="box">
        <img src="/img/fedya1.png" class="fedya1-d">
        <div class="box-container">
            <h1 class="box-name">Подтвердите почту</h1>
            <div class="box-text">Для восстановления пароля необходимо перейти по ссылке в присланном письме</div>
            <div class="box-text">Проверьте папку "Спам" или "Нежелательная почта"</div>
            <div class="box-text">В случае возникновения проблем обратитесь в поддержку - <a class="link" href="mailto:support@imctech.ru">support@imctech.ru</a></text></div>
        </div>
        <img src="/img/fedya1.png" class="fedya1-m">
    </div>
@endsection

@section('footer')
    @parent
@endsection
