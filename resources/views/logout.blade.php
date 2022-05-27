<?php
    setcookie("login", "", time()-(60*60*24*7), "/");
    setcookie("password", "", time()-(60*60*24*7), "/");
?>

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
    <meta http-equiv="Refresh" content="0; URL=/">
    
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/home_mobile.css">
@endsection