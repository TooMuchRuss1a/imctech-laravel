@extends('layouts.landing.app')

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

    <link rel="stylesheet" href="/css/landing/pschool.css?version=3.2{{{date('_Y-m-d_H:i:s')}}}">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/landing/pschool_mobile.css?version=3.2{{{date('_Y-m-d_H:i:s')}}}">
@endsection

@section('content')
    <a href="#">
        <div id="scrup" class="scroll-up"></div>
    </a>

    <div class="intro">
        <div class="containerglitch">
            <div class="stack" style="--stacks: 3;">
                <span style="--index: 0;">ПРОЕКТНАЯ ШКОЛА</span>
                <span style="--index: 1;">ПРОЕКТНАЯ ШКОЛА</span>
                <span style="--index: 2;">ПРОЕКТНАЯ ШКОЛА</span>
            </div>
            <h1 class="intro_subtitle">join us</h1>
        </div>
        @if($event->register_until > now())
            <a class="btn" href="{{route('service.activity')}}">Участвовать</a>
            <img src="/img/pointer.png" class="pointer">
        @else
            <a class="btn-grey">Участвовать
                <div class="btn-grey_popup">регистрация закрыта</div>
            </a>
        @endif
    </div>

    <div class="projects_bg">
        @if(cache('timetable'))
            <div class="projects">
                <div class="reged"><text>{{{$event->activities()->count()}}}</text> студентов уже записалось на Осеннюю проектную школу 2022</div>
                <div class="wrapper">
                    <div class="marquee">
                        <p>
                            РАСПИСАНИЕ РАСПИСАНИЕ РАСПИСАНИЕ РАСПИСАНИЕ РАСПИСАНИЕ РАСПИСАНИЕ РАСПИСАНИЕ РАСПИСАНИЕ
                        </p>
                        <p>
                            РАСПИСАНИЕ РАСПИСАНИЕ РАСПИСАНИЕ РАСПИСАНИЕ РАСПИСАНИЕ РАСПИСАНИЕ РАСПИСАНИЕ РАСПИСАНИЕ
                        </p>
                    </div>
                </div>
            </div>
            <div class="flex-parent">
                <div class="input-flex-container">
                    @forelse($days as $day)
                        <div class="input @if($loop->index == $activeDay) active @endif">
                            <span data-year="{{{$day->date->locale('ru')->isoFormat('D MMM')}}}" data-info="{{{$day->name}}}"></span>
                        </div>
                    @empty
                    @endforelse
                </div>
                <div class="description-flex-container" style="padding-bottom: 20px;">
                    @forelse($days as $day)
                        <div class="container @if($loop->index == $activeDay) active @endif">
                            <div class="wrapper">
                                <h3>{{{$day->date->locale('ru')->isoFormat('D MMMM')}}} - {{{$day->place}}}</h3>
                                <ul class="sessions">
                                    @forelse($day->timelines as $timeline)
                                        <li>
                                            <div class="time">{{{$timeline->from->format('H:i')}}} - {{{$timeline->to->format('H:i')}}}</div>
                                            <div class="textarea">
                                                {!!nl2br(htmlspecialchars($timeline->description))!!}
                                            </div>
                                        </li>
                                    @empty
                                        <div class="textarea">Похоже тут пусто ¯\_(ツ)_/¯</div>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
            <script>
                $(function(){
                    var inputs = $('.input');
                    var paras = $('.description-flex-container').find('.container');
                    inputs.click(function(){
                        var t = $(this),
                            ind = t.index(),
                            matchedPara = paras.eq(ind);

                        t.add(matchedPara).addClass('active');
                        inputs.not(t).add(paras.not(matchedPara)).removeClass('active');
                    });
                });
            </script>
        @endif
        <div class="projects">
            @if(!cache('timetable'))<div class="reged"><text>{{{$event->activities()->count()}}}</text> студентов уже записалось на Осеннюю проектную школу 2022</div>@endif
            <div class="wrapper">
                <div class="marquee">
                    <p>
                        VR/AR GameDev Hackathon web data science VR/AR GameDev Hackathon web data science
                    </p>
                    <p>
                        VR/AR GameDev Hackathon web data science VR/AR GameDev Hackathon web data science
                    </p>
                </div>
            </div>
        </div>

        <div class="program">
            <div class="program-box">
                <img src="/img/1653718954_57b95b.jpg">
                <div>Обучение
                    <div>В процессе обучения ты узнаешь, как эффективно работать в команде, как работать над кейсами и участвовать в хакатонах, что, для кого и как нужно разрабатывать, чтобы быть успешным. Подробное расписание ты сможешь посмотреть в чате, доступ к которому откроется после регистрации, и на сайте</div>
                </div>
            </div>
            <div class="program-box">
                <img src="/img/1653721813_b64a7c.jpg">
                <div>Хакатон
                    <div>24 часа, куча пиццы и напитков, команда светлых голов и проект готов! Вам предстоит выбрать предложенный компаниями или свой собственный проект и реализовать его минимальный жизнеспособный продукт за сутки. По истечении времени командам нужно будет представить свои проекты экспертам</div>
                </div>
            </div>
            <div class="program-box">
                <img src="/img/1653721794_0fa056.jpg">
                <div>Выставка
                    <div>В промежутке между Хакатоном и Выставкой проектов вам предстоит доработать свои проекты и подготовить их уже к публичной выставке в Аяксе. Сотни людей смогут посмотреть и потрогать твой проект и дать настоящий пользовательский фидбэк с искренними эмоциями. Приятно ведь, когда хвалят</div>
                </div>
            </div>
        </div>
        <div class="program">
            <div class="program-box">
                <img src="/img/closing.jpg">
                <div>Закрытие<div>После активной работы хочется отдохнуть, не так ли? Для этого команда IMCTech выделяет специальный день, когда студенты смогут забыть про все свои заботы и оторваться на всю катушку: настолки, пицца, VR игры и прочие крутые развлечения, которые не заставят тебя заскучать</div>
                </div>
            </div>
            <div class="program-box">
                <img src="/img/coworking.jpg">
                <div>Коворкинг<div>Институт математики и компьютерных технологий любезно предоставляет студентам коворкинг в G464 и прочие технические возможности по просьбе. Пока что коворкинг не отличается чем-то прям сверхъестественным, но мы точно им когда-то займемся. Если у вас есть желание нам помочь, то свяжитесь с нами, пожалуйста</div>
                </div>
            </div>
            <div class="program-box">
                <img src="/img/1653721841_fbdf42.jpg">
                <div>Сотрудничество<div>Команда IMCTech активно сотрудничает с компаниями: Farpost, Red Bull, Додо Пицца, Slavda Group и другими - и продолжает расширять этот круг. После Зимней проектной школы 2022 студенты, успешно защитившие свои проекты, были приглашены на экскурсию в офис Farpost</div>
                </div>
            </div>
        </div>
    </div>

    @if($projects->count() != 0)
        <div class="projects_bg">
            <div class="projects">
                <div class="wrapper">
                    <div class="marquee">
                        <p>
                            ПРОЕКТЫ СТУДЕНТОВ ПРОЕКТЫ СТУДЕНТОВ ПРОЕКТЫ СТУДЕНТОВ ПРОЕКТЫ СТУДЕНТОВ ПРОЕКТЫ СТУДЕНТОВ
                        </p>
                        <p>
                            ПРОЕКТЫ СТУДЕНТОВ ПРОЕКТЫ СТУДЕНТОВ ПРОЕКТЫ СТУДЕНТОВ ПРОЕКТЫ СТУДЕНТОВ ПРОЕКТЫ СТУДЕНТОВ
                        </p>
                    </div>
                </div>
            </div>

            @foreach($projects as $project)
                <div class="pj" style="margin-top: 40px;">
                    <div onclick="like({{{$project->id}}})" class="like-d" id="d-{{$project->id}}" @if($loop->iteration % 2 == 0) style="right: 0 !important;" @endif>
                        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="currentColor" @if(auth()->check() && in_array(request()->user()->id, $project->projectLikes->pluck('user_id')->toArray())) color="cornflowerblue" @endif class="bi bi-heart" viewBox="0 0 16 16">
                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                        </svg>
                        <div>{{{$project->project_likes_count}}}</div>
                    </div>
                    <div onclick="like({{{$project->id}}})" class="like-m" id="m-{{$project->id}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40%" height="40%" fill="currentColor" @if(auth()->check() && in_array(request()->user()->id, $project->projectLikes->pluck('user_id')->toArray())) color="cornflowerblue" @endif class="bi bi-heart" viewBox="0 0 16 16">
                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"/>
                        </svg>
                        <div>{{{$project->project_likes_count}}}</div>
                    </div>
                    @if($loop->iteration % 2 == 0)
                        <img class="pj-img-d" src="{{{$project->image_d}}}">
                    @endif
                    <div class="pj-container">
                        <div class="pj-name">{{{$project->name}}}</div>
                        <div class="pj-subname">{{{$project->subname}}}</div>
                        <div class="pj-text">
                            <div class="pj-text-a">{!!$project->text!!}</div>
                        </div>
                        @if($project->publicProjectUsers->count() != 0)
                            <div class="pj-team">Команда:</div>
                            <div>
                                @foreach($project->publicProjectUsers->sortBy('user.name') as $projectUser)
                                    <a class="pj-team-c" rel="noopener noreferrer" target="_blank" href="{{{$projectUser->user->vk->link}}}">
                                        <img class="vk" src="/img/vk.png">
                                        <text>{{{$projectUser->user->FI}}}</text>
                                    </a>
                                    <br>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    @if($loop->iteration % 2 != 0)
                        <img class="pj-img-d" src="{{{$project->image_d}}}">
                    @endif
                    <img class="pj-img-m" src="{{{$project->image_m}}}">
                </div>
            @endforeach
        </div>
    @endif

    <script>
        var scrUp = document.getElementById("scrup");
    </script>
    <script>
        function like(id)
        {
            let likeM = document.getElementById('m-' + id);
            let likeD = document.getElementById('d-' + id);
            likeM.classList.add('loading')
            likeD.classList.add('loading')
            $.ajax({
                type: "GET",
                url: "api/like/project/"+id,
                success: function(result) {
                    if (result === 'login') {
                        window.location.href = '{{{route('login')}}}';
                    }
                    else if (result === null) {
                        likeM.classList.remove('loading')
                        likeD.classList.remove('loading')
                    }
                    else {
                        likeM.firstElementChild.setAttribute("color", result.action === 'liked' ? 'cornflowerblue' : 'white');
                        likeM.lastElementChild.innerHTML = result.value;
                        likeD.firstElementChild.setAttribute("color", result.action === 'liked' ? 'cornflowerblue' : 'white');
                        likeD.lastElementChild.innerHTML = result.value;
                        likeM.classList.remove('loading')
                        likeD.classList.remove('loading')
                    }
                },
                error: function(result) {
                    likeM.classList.remove('loading')
                    likeD.classList.remove('loading')
                }
            });
        }
    </script>


@endsection

@section('footer')
@parent
<div class="flogo_container">
    <a rel="noopener noreferrer" target="_blank" href="https://www.dvfu.ru"><img class="flogo" src="/img/logos/dvfu.png"></a>
    <a rel="noopener noreferrer" target="_blank" href="https://vk.com/imct_fefu"><img class="flogo" src="/img/logos/imct.png"></a>
    <a rel="noopener noreferrer" target="_blank" href="https://russky.digital"><img class="flogo" src="/img/logos/rd.png"></a>
    <a rel="noopener noreferrer" target="_blank" href="https://www.farpost.ru"><img class="flogo" src="/img/logos/farpost.png"></a>
    <a rel="noopener noreferrer" target="_blank" href="https://dodopizza.ru"><img class="flogo" src="/img/logos/dodo.png"></a>
    <a rel="noopener noreferrer" target="_blank" href="https://www.slavda.ru"><img class="flogo" src="/img/logos/slavda.png"></a>
</div>
<div class="flogo_container-m">
    <a rel="noopener noreferrer" target="_blank" href="https://www.dvfu.ru"><img class="flogo" src="/img/logos/dvfu.png"></a>
    <a rel="noopener noreferrer" target="_blank" href="https://vk.com/imct_fefu"><img class="flogo" src="/img/logos/imct.png"></a>
    <a rel="noopener noreferrer" target="_blank" href="https://russky.digital"><img class="flogo" src="/img/logos/rd.png"></a>
</div>
<div class="flogo_container-m" style="padding: 10px 70px;">
    <a rel="noopener noreferrer" target="_blank" href="https://www.farpost.ru"><img class="flogo" src="/img/logos/farpost.png"></a>
    <a rel="noopener noreferrer" target="_blank" href="https://dodopizza.ru"><img class="flogo" src="/img/logos/dodo.png"></a>
    <a rel="noopener noreferrer" target="_blank" href="https://www.slavda.ru"><img class="flogo" src="/img/logos/slavda.png"></a>
</div>
@endsection
