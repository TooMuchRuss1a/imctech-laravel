<?php
$groups = array();
$result = DB::table('tbl_springpschool2022')->orderBy('agroup')->get();
foreach ($result as $row) {
    if (isset($groups[substr($row->agroup, 7)])) {
        $groups[substr($row->agroup, 7)]++;
    }
    else {
        $groups[substr($row->agroup, 7)] = 1;
    }
}
ksort($groups);
$groupsArray = "";
foreach ($groups as $key => $value) {
    $groupsArray .= '["'.$key.'", ' . $value . '],';
}

$table = "";
$result = DB::table('tbl_projects')->orderBy('id', 'DESC')->get();
foreach ($result as $row){
    $table .= '<tr><td>'.$row->project.'</td><td>'.$row->customer.'</td><td>'.$row->team.'</td><td>'.$row->students.'</td></tr>';
}

$pschoolcounter = DB::table('tbl_springpschool2022')->count();
?>


@extends('layouts.app')

@section('head')
    <title>Аналитика - Проектная школа IMCTech</title>
    <meta charset="UTF-8">
    <meta property="og:type"             content="article"/>
    <meta property="og:locale"           content="ru_RU"/>
    <meta property="og:site_name"        content="IMCTech"/>
    <meta property="og:title"            content="Аналитика - Проектная школа"/>
    <meta property="og:description"      content="JOIN US"/>
    <meta property="og:url"              content="https://imctech.ru/pschool/analytics"/>
    <meta property="og:image"            content="https://imctech.ru/img/main.jpg"/>
    <meta property="og:image:secure_url" content="https://imctech.ru/img/main.jpg"/>
    <meta property="og:image:type"       content="image/jpeg"/>

    <link rel="stylesheet" href="/css/analytics.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/analytics_mobile.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['bar']});
        google.charts.setOnLoadCallback(drawStuff);

        function drawStuff() {
            var data = new google.visualization.arrayToDataTable([
                ['Направление подготовки', 'Кол-во'],
                <?=$groupsArray?>
            ]);

            var options = {
                'chartArea': {
                    'backgroundColor': {
                        'fill': '#111',
                        'opacity': 100
                    },
                },
                colors: ['#ddd'],
                backgroundColor: '#111',
                legend: { position: 'none' },
                chart: {
                    title: 'Аналитика по направлениям',
                    subtitle: 'Весенняя проектная школа' },
                axes: {
                    x: {
                        0: { side: 'down', label: 'Всего - <?=$pschoolcounter?> студентов'} // Top x-axis.
                    }
                },
                bar: { groupWidth: "90%" }
            };

            var chart = new google.charts.Bar(document.getElementById('top_x_div'));
            // Convert the Classic options to Material options.
            chart.draw(data, google.charts.Bar.convertOptions(options));
        };
    </script>
@endsection

@section('content')
    <a href="#">
        <div id="scrup" class="scroll-up"></div>
    </a>

    <div class="intro_title">АНАЛИТИКА</div>
    <table class="table">
        <thead>
        <tr>
            <th>ПРОЕКТ</th>
            <th>ЗАКАЗЧИК</th>
            <th>КОМАНДА</th>
            <th>ИСПОЛНИТЕЛИ</th>
        </tr>
        </thead>
        <tbody>
        <?=$table ?>
        </tbody>
    </table>
    <div id="top_x_div" class="gstat"></div>

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
@endsection
