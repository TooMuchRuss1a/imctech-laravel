@extends('layouts.app')

@section('head')
    <title>IMCTech</title>
    <meta charset="UTF-8">
    <meta property="og:type" content="article" />
    <meta property="og:locale" content="ru_RU" />
    <meta property="og:site_name" content="IMCTech" />
    <meta property="og:title" content="Проектная школа" />
    <meta property="og:description" content="JOIN US" />
    <meta property="og:url" content="https://imctech.ru/pschool" />
    <meta property="og:image" content="https://imctech.ru/img/pschool.jpg" />
    <meta property="og:image:secure_url" content="https://imctech.ru/img/pschool.jpg" />
    <meta property="og:image:type" content="image/jpeg" />

    <link rel="stylesheet" href="/css/psession.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/psession_mobile.css">
@endsection

@section('content')
    <a href="#">
        <div id="scrup" class="scroll-up"></div>
    </a>

    <div class="intro">
            <div class="intro_title">ПРОЕКТНАЯ СЕССИЯ</div>
        <a class="btn-grey">Участвовать
            <div class="btn-grey_popup">регистрация закрыта</div>
        </a>
    </div>

    <div class="projects_bg">
        <div class="projects">
            <div class="reged"><text>{{{$students}}}</text> студентов уже записалось на Проектную сессию 2022</div>
            <div class="wrapper">
                <div class="marquee">
                    <p>
                        ЛАЙТОВО ДУШЕВНО ИМКТЭШНО СЕМЕЙНО ЛАЙТОВО ДУШЕВНО ИМКТЭШНО СЕМЕЙНО ЛАЙТОВО ДУШЕВНО ИМКТЭШНО СЕМЕЙНО
                    </p>
                    <p>
                        ЛАЙТОВО ДУШЕВНО ИМКТЭШНО СЕМЕЙНО ЛАЙТОВО ДУШЕВНО ИМКТЭШНО СЕМЕЙНО ЛАЙТОВО ДУШЕВНО ИМКТЭШНО СЕМЕЙНО
                    </p>
                </div>
            </div>
        </div>

        <div class="program">
            <div class="program-box">
                <div>ВНИМАНИЕ
                    <img src="/img/fedya1.png">
                    <div>Спасибо за внимание</div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var scrUp = document.getElementById("scrup");
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
    <div class="footer-text" style="padding-bottom: 10px">Перед тем, как записаться на проектную сессию, стоит понимать, что она сможет заменить твою учебную практику только в случае, если твой ведущий преподаватель по практике дал добро. В противном случае мы не сможем гарантировать закрытие практики.</div>
@endsection
