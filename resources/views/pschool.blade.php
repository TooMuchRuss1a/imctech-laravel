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

    <link rel="stylesheet" href="/css/pschool.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/pschool_mobile.css">
@endsection

@section('content')
    <a href="#">
        <div id="scrup" class="scroll-up"></div>
    </a>

    <a href="{{route('analytics')}}"><img class="charts" src="/img/chart.png"></a>

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
                <div class="description-flex-container">
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
        @else
            <div class="projects">
                <div class="reged"><text>{{{$event->activities()->count()}}}</text> студентов уже записалось на Осеннюю проектную школу 2022</div>
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
                        <div>24 часа, куча пиццы и напитков, команда светлых голов и проект готов! Вам предстоит выбрать предложенный компаниями или свой собственный проект и реализовать его минимальный жизнеспособный продукт за сутки. По истечению времени командам нужно будет представить свои проекты экспертам</div>
                    </div>
                </div>
                <div class="program-box">
                    <img src="/img/1653721794_0fa056.jpg">
                    <div>Выставка
                        <div>В промежутке между Хакатоном и Выставкой проектов вам предстоит доработаь свои проекты и подготовить их уже к публичной выставке в Аяксе. Сотни людей смогут посмотреть и потрогать твой проект и дать настоящий пользовательский фидбэк с искренними эмоциями. Приятно ведь, когда хвалят</div>
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
       @endif
    </div>

    <div class="projects_bg">
        <img src="/img/Abobus.png" class="abobus">

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


        <div class="pj" style="margin-top: 40px;">
            <div class="pj-container">
                <div class="pj-name">FEFU-Сalypse</div>
                <div class="pj-subname">GameDev</div>
                <div class="pj-text">
                    <div class="pj-text-a">Команда "FIniSH Square D" создает игру "FEFU-calypse". В данный момент были разработаны концепты и базовый прототип игры.</div>
                    <div class="pj-text-a">Сюжет: 2042 год, Владивосток, Covid-19 мутировал из-за чего люди стали превращаться в зомби подобных существ. Одним из последних безопасных мест оставался Русский остров, но вирус проник и туда. И теперь главному герою - студенту, напрочь позабывшему об учёбе, предстоит раздобыть вакцину, спасти мир и сдать экзамен по программированию, который может оказаться для него последним.</div>
                    <div class="pj-text-a">Цель проекта: получить конкурентно-способный продукт на видеоигровом рынке. Привлечь внимание потенциальных абитуриентов к университету. Проект - игра в жанре beat'em up, опирающаюся на атмосферу ДВФУ, с использованием платформы для разработки игр: Unity. С реализацией на языке программирования C#. Мотивацией для реализации данного проекта послужила наша любовь к видеоиграм и ДВФУ.</div>
                </div>
                <div class="pj-team">Команда:</div>
                <div>
                    <a class="pj-team-c" rel="noopener noreferrer" target="_blank" href="https://vk.com/pepegger">
                        <img class="vk" src="/img/vk.png">
                        <text>Степанов Владислав - PM</text>
                    </a>
                    <br>
                    <a class="pj-team-c" rel="noopener noreferrer" target="_blank" href="https://vk.com/kysssssska">
                        <img class="vk" src="/img/vk.png">
                        <text>Сайфутдинова Илюза</text>
                    </a>
                </div>
            </div>
            <img class="pj-img-d" src="/img/e8npOp9YoRY.jpg">
            <img class="pj-img-m" src="/img/fc.jpg">
        </div>

        <div class="pj">
            <img class="pj-img-d" src="https://images.wbstatic.net/big/new/33510000/33518126-6.jpg">
            <div class="pj-container">
                <div class="pj-name">VoiceN</div>
                <div class="pj-subname">Социальный проект</div>
                <div class="pj-text">
                    <div class="pj-text-a">Команда "VoiceN", в рамках проектной школы, разработала прототип навыка для Алисы, который включает в себя функционал поиска книг и показ новых поступлений в библиотеке "Логос". </div>
                    <div class="pj-text-a">Цель проекта: предоставить слабовидящим людям продукт, с помощью которого они смогут посредством голоса управлять библиотекой. В том числе прослушивать (перематывать, ставить на паузу и тд.) "говорящие книги", ставить их на книжную полку, слушать записанные радиопередачи и пользоваться прочим функционалом библиотеки "Логос".</div>
                    <div class="pj-text-c">"По большей части нашу команду заинтересовала тема работы с голосовым помощником, а также помощь людям с ограниченными возможностями. Этот проект показал, что действительно, люди заинтересованные в достижении цели, способны за короткий срок погрузиться в тему и показать неплохой результат. Естественно, мы будем продолжать работу над проектом."</div>
                </div>
                <div class="pj-team">Команда:</div>
                <div>
                    <a class="pj-team-none"><text>• Грозецкий Денис - PM</text></a>
                    <br>
                    <a class="pj-team-none"><text>• Гребенников Владимир</text></a>
                    <br>
                    <a class="pj-team-none"><text>• Голобородько Димитрий</text></a>
                    <br>
                    <a class="pj-team-none"><text>• Стефановский Артём</text></a>
                    <br>
                    <a class="pj-team-none"><text>• Святова Марина</text></a>
                    <br>
                    <a class="pj-team-none"><text>• Похорукова Алина</text></a>
                </div>
            </div>
            <img class="pj-img-m" src="https://s0.rbk.ru/v6_top_pics/media/img/8/34/755276725589348.jpg">
        </div>

        <div class="pj">
            <div class="pj-container">
                <div class="pj-name">2D платформер</div>
                <div class="pj-subname">GameDev</div>
                <div class="pj-text">
                    <div class="pj-text-a">Команда "RandomName_Team" разрабатывает 2D платформер с элементами Rouge like.</div>
                    <div class="pj-text-a">Сюжет: некоторые люди постигли тайны ментальных боёв, за победу в которых победитель получает все знания проигравшего, а разум проигравшего стирается. Правила боя задаёт тот, на кого напали/вызвали на бой, сам бой происходит в сознании принимающей стороны, от сюда и правила боя.</div>
                    <div class="pj-text-c">"Участие в зимней проектной школе дало мне и моим товарищам много того, чего, просто учась на отлично, не получишь, и я благодарен ребятам из Академии цифровой трансформации и Студенческого совета ИМКТ за то, что смог стать участником такого классного проекта!"</div>
                </div>
                <div class="pj-team">Команда:</div>
                <div>
                    <a class="pj-team-c" rel="noopener noreferrer" target="_blank" href="https://vk.com/lakmm"><img class="vk" src="/img/vk.png"> <text>Кучеров Валентин - PM</text></a>
                    <br>
                    <a class="pj-team-c" rel="noopener noreferrer" target="_blank" href="https://vk.com/vcitich"><img class="vk" src="/img/vk.png"><text>Нехорошев Виктор</text></a>
                    <br>
                    <a class="pj-team-c" rel="noopener noreferrer" target="_blank" href="https://vk.com/k.matrosova2000"><img class="vk" src="/img/vk.png"> <text>Потега Ксения</text></a>
                    <br>
                    <a class="pj-team-c" rel="noopener noreferrer" target="_blank" href="https://vk.com/e.maslichenko"><img class="vk" src="/img/vk.png"><text>Масличенко Елизавета</text></a>
                </div>
            </div>
            <img class="pj-img-m" src="/img/rntm.png">
            <img class="pj-img-d" src="/img/rnt.png">
        </div>

        <div class="pj" style="margin-bottom: 0;">
            <img class="pj-img-d" src="/img/fpw.jpg">
            <div class="pj-container">
                <div class="pj-name">FEFU Prepod Wiki</div>
                <div class="pj-subname">Социальный проект</div>
                <div class="pj-text">
                    <div class="pj-text-a">Команда "FEFU Prepod Wiki" разработала одноименного <a class="link" rel="noopener noreferrer" target="_blank" href="https://t.me/fefu_prepod_bot">telegram-бота,</a> который по запросу студента выдает основную информацию о преподавателе.</div>
                    <div class="pj-text-a">Для соблюдения этики по отношению к преподавателям они отказались от простой публикации отзывов, так как на эмоциях студент может написать некорректную или неточную информацию. Поэтому они выкладывают в карточки только сухие факты, исходя из статистики. </div>
                    <div class="pj-text-c">"Сама идея у меня возникла после того, как я, будучи первокурсницей, столкнулась с большим количеством новых преподавателей. Неизвестно, что ждёт в новом семестре, непонятно, к чему готовиться, хотелось бы иметь какую-то небольшую базу знаний для того, чтобы найти правильный подход к обучению... Пока мы действуем только внутри ИМКТ, но если другие школы и институты заинтересуются данным проектом, то наша команда всегда открыта к обсуждению и дальнейшему расширению базы данных преподавателей."</div>
                    <div class="pj-text-a">Оставить отзыв о преподавателе можно в <a class="link" rel="noopener noreferrer" target="_blank" href="https://forms.gle/HDTXgY6gjUb1WLKw5">гугл-форме.</a></div>
                </div>
                <div class="pj-team">Команда:</div>
                <div>
                    <a class="pj-team-c" href="https://vk.com/va_hahahaha" rel="noopener noreferrer" target="_blank"><img class="vk" src="/img/vk.png"> <text>Юрина Валентина - PM</text></a>
                    <br>
                    <a class="pj-team-c" href="https://vk.com/idlalexandro" rel="noopener noreferrer" target="_blank"><img class="vk" src="/img/vk.png"> <text>Пушкарев Александр</text></a>
                    <br>
                    <a class="pj-team-c" href="https://m.vk.com/floorisslava" rel="noopener noreferrer" target="_blank"><img class="vk" src="/img/vk.png"> <text>Кадомцев Вячеслав</text></a>
                </div>
            </div>
            <img class="pj-img-m" src="/img/fpw_m.jpg">
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
