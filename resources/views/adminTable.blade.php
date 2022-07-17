@extends('layoutsA.app')

@section('head')
    <title>IMCTech - Админка</title>
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
@endsection

@section('content')
    <table class="table table-hover">
        <thead>
        <tr>
            @foreach($keys as $key)
                <th scope="col">{{{$key}}}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($tableData as $row)
        <tr>
            @foreach(get_object_vars($row) as $item)
                <td>{{{$item}}}</td>
            @endforeach
        </tr>
        @endforeach
        </tbody>
    </table>
@endsection
