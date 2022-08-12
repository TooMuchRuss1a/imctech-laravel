<?php use Illuminate\Support\Facades\Route;?>
{{--@section('header')--}}
<header id="nav" class="header">
    <div class="header_inner">
        <div class="header_logo">
            <a class="header_logo_link" href="<?php if (Route::current()->getName() == "home") {echo "#";} else {echo "/";} ?>"><img class="header_logoimg" src="/img/logos/imctech.png"><text> IMCTech</text></a>
        </div>
        <div class="nav">
            @if(auth()->check())
                <div class="dropdown1">
                    <button onclick="myFunction()" class="dropbtn1">{{{auth()->user()->login}}}</button>
                    <div id="myDropdown1" class="dropdown1-content">
                        <div class="dd-text">ФИО</div>
                        <div class="dd-text-description">{{{auth()->user()->name}}}</div>
                        <div class="dd-text">Группа</div>
                        <div class="dd-text-description">{{{auth()->user()->agroup}}}</div>
                        <div class="dd-text">email</div>
                        @if(!empty(auth()->user()->email_verified_at))
                            <div style="text-transform:lowercase;" class="dd-text-description">{{{auth()->user()->email}}}</div>
                        @else
                            <div style="text-transform:lowercase; color:rgb(255,50,50);" class="dd-text-description">не подтвержден</div>
                        @endif
                        <div class="dd-text"><a href="{{route('service')}}">Сервис</a><a href={{{route('logout')}}}>Выход</a></div>
                    </div>
                </div>
            @else <a class="nav_link" href="/login">Войти</a>
            @endif
        </div>
    </div>
</header>
