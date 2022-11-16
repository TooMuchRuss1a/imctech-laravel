<?php use Illuminate\Support\Facades\Route;?>
{{--@section('header')--}}
<header id="nav" class="header">
    <div class="header_inner">
        <div class="header_logo">
            <a class="header_logo_link" href="<?php if (Route::current()->getName() == "home") {echo "#";} else {echo "/";} ?>"><img class="header_logoimg" src="/img/logos/imctech.png"><text> IMCTech</text></a>
        </div>
        <div class="nav">
            @auth
                <div class="dropdown1">
                    <button onclick="myFunction()" class="dropbtn1">{{{auth()->user()->login}}}</button>
                    <div id="myDropdown1" class="dropdown1-content">
                        <div class="dd-text">ФИО</div>
                        <div class="dd-text-description">{{{auth()->user()->name}}}</div>
                        <div class="dd-text">Группа</div>
                        <div class="dd-text-description">{{{auth()->user()->agroup}}}</div>
                        <div class="dd-text">email</div>
                        <div style="text-transform:lowercase; @if(!auth()->user()->hasVerifiedEmail()) color:rgb(255,50,50); @endif" class="dd-text-description">{{{auth()->user()->email}}}</div>
                        <div class="dd-text"><a href="{{route('service')}}">Сервис</a><a href={{{route('logout')}}}>Выход</a></div>
                    </div>
                </div>
            @else <a class="nav_link" href="/login">Войти</a>
            @endauth
        </div>
    </div>
</header>
