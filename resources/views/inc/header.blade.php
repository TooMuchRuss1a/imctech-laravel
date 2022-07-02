<?php use Illuminate\Support\Facades\Route;?>
@section('header')
<header id="nav" class="header">
    <div class="header_inner">
        <div class="header_logo">
            <a class="header_logo_link" href="<?php if (Route::current()->getName() == "home") {echo "#";} else {echo "/";} ?>"><img class="header_logoimg" src="/img/logos/imctech.png"><text> IMCTech</text></a>
        </div>
        <div class="nav">
            @if($user)
                @if($user->ban == "0")
                    <div class="dropdown1">
                        <button onclick="myFunction()" class="dropbtn1">{{{$user->login}}}</button>
                        <div id="myDropdown1" class="dropdown1-content">
                            <div class="dd-text">ФИО</div>
                            <div class="dd-text-description">{{{$user->name}}}</div>
                            <div class="dd-text">Группа</div>
                            <div class="dd-text-description">{{{$user->agroup}}}</div>
                            <div class="dd-text">ВК</div>
                            <div style="text-transform:lowercase;" class="dd-text-description">{{{$user->vk}}}</div>
                            <div class="dd-text">email</div>
                            <div style="text-transform:lowercase;" class="dd-text-description">{{{$user->email}}}</div>
                            <div class="dd-text">Tg ID</div>
                            <div class="dd-text-description">{{{$user->tg}}}</div>
                            <div class="dd-text"><a href="profile">Профиль</a><a href="login/logout">Выход</a></div>
                        </div>
                    </div>
                @else
                    <div class="dropdown1">
                        <button onclick="myFunction()" class="dropbtn1" style="color:rgb(255,50,50);">{{{$user->login}}}</button>
                        <div id="myDropdown1" class="dropdown1-content">
                        <div class="dd-text"><a href="/profile">Профиль</a></div>
                        <div class="dd-text" style="color:rgb(255,50,50);">вы заблокированы</div>
                        <div class="dd-text-description" style="color:rgb(255,50,50);">{{{$user->ban}}}</div>
                        <div class="dd-text"><a href="/profile">Профиль</a><a href="/login/logout">Выход</a></div>
                        </div>
                    </div>
                @endif
            @else <a class="nav_link" href="/login">Войти</a>
            @endif
        </div>
    </div>
</header>
