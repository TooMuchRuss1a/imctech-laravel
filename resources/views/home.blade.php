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
    
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/home_mobile.css">
    <script src="/js/nav.js"></script>
@endsection

@section('content')
<a href="#">
    <div id="scrup" class="scroll-up"></div>
</a>

<div class="imctech">
    <div class="imctech_title">
        IMCTech
    </div>
    <div class="imctech_subtitle-d">Академия цифровой трансформации</div>
    <div class="imctech_subtitle-m">Студенческий совет ИМКТ</div>
    <div class="imctech_x">x</div>
    <div class="imctech_subtitle-d">Студенческий совет ИМКТ</div>
    <div class="imctech_subtitle-m">Академия цифровой трансформации </div>
    <a href="#pschool">
        <div class="scroll-down"></div>
    </a>
</div>


<div class="intro">
    <div class="container">
        <h1 class="intro_title" id="pschool">проектная школа</h1>
        <h1 class="intro_subtitle">больше чем проекты</h1>
        <h1 class="intro_text">Школа нацелена на подготовку студентов к работе над реальными проектами. Вам покажут, что это круто и интересно. Принять участие может любой человек вне зависимости от направления, курса и института. В рамках школы участники будут генерировать идеи для решения реальных проблем и реализовывать их. Во время работы организаторы будут активно поддерживать участников. В конце проектной школы каждый студент или команда презентуют свой проект. Вполне возможно, что какой-то из них будет ждать большое будущее.</h1>
    </div>
    <a href="/pschool" class="btn">Подробнее</a>
</div>

<div class="area">
    <ul class="circles">
        <div class="g468">
            <div class="container">
                <h1 class="g468_title" id="pschool">Коворкинг - G468</h1>
                <h1 class="g468_subtitle">прикоснуться к прекрасному</h1>
                <h1 class="g468_text">Для тех, кто хочет заняться чем-то серьезным, но мощностей ноутбука не хватает</h1>
            </div>
            <a href="/g468" class="btn">Записаться</a>
        </div>
        <img src="/img/cursor.png">
        <img src="/img/cursor.png">
        <img src="/img/cursor.png">
        <img src="/img/cursor.png">
        <img src="/img/heart.png">
        <img src="/img/bomb.png">
        <img src="/img/cursor.png">
        <img src="/img/heart.png">
        <img src="/img/cursor.png">
        <img src="/img/heart.png">
    </ul>
</div>

<script>
    var myNav = document.getElementById("nav");
    var scrUp = document.getElementById("scrup");
    var dd = document.getElementById("myDropdown1");
    if (dd === null) {
      dd = document.getElementById("nav");
    }
</script>

@endsection

@section('footer')
@parent
<div class="flogo_container">
    <a rel="noopener noreferrer" target="_blank" href="https://www.dvfu.ru"><img class="flogo" src="/img/logos/dvfu.png"></a>
    <a rel="noopener noreferrer" target="_blank" href="https://vk.com/imct_fefu"><img class="flogo" src="/img/logos/imct.png"></a>
</div>
<div class="flogo_container-m">
    <a rel="noopener noreferrer" target="_blank" href="https://www.dvfu.ru"><img class="flogo" src="/img/logos/dvfu.png"></a>
    <a rel="noopener noreferrer" target="_blank" href="https://vk.com/imct_fefu"><img class="flogo" src="/img/logos/imct.png"></a>
</div>
@endsection