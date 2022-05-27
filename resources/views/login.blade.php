@extends('layouts.app')

<?php
$error = "";
$reason = "";
$secret = env('RECAPTCHA_SECRET');
// Проверка нажата ли кнопка отправки формы
if (isset($_REQUEST['Submit'])) {
    if (isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
        $ip = $_SERVER['REMOTE_ADDR'];
        $response = $_POST['g-recaptcha-response'];
        $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
        $arr = json_decode($rsp, TRUE);
        if ($arr['success']) {
            $login = $_REQUEST['login'];
            $pass = $_REQUEST['pass'];

            // берёт из БД пароль и id пользователя 
            $result = DB::table('tbl_reg')->where('login', "$login")->where('email_confirmed', '1')->first();
            if ($result) {
                if (password_verify($pass, $result->password)) {
                    if ($result->ban == "0") {
                        // Если функция возвращает true, то вы входите
                        $password_hased = password_hash($pass, PASSWORD_DEFAULT);
                        setcookie("login", $login, time() + 259200, "/");
                        setcookie("password", $pass, time() + 259200, "/");
                        header('Location: login/success');
                        exit;
                    } else {
                        $error = "Вы заблокированы";
                        $reason = $result->ban;
                    }
                } else {
                    // Если функция возвращает false, то выводит ошибку
                    $error = "Неверный пароль";
                }
            } else {
                $error = "Логин не существует или почта не подтверждена";
            }
        } else {
            $error = "Капча не пройдена";
        }
    } else {
        $error = 'Не установлен флажок "Я не робот"';
    }

    if (strpos($_REQUEST['login'], 'dvfu.ru') == true) {
        $error = "Логин = почта без @students.dvfu.ru";
    }
}

?>

@section('head')
    <title>IMCTech</title>
    <meta charset="UTF-8">
    <meta property="og:type" content="article" />
    <meta property="og:locale" content="ru_RU" />
    <meta property="og:site_name" content="IMCTech" />
    <meta property="og:title" content="JOIN US" />
    <meta property="og:description" content="Строим цифровое будущее" />
    <meta property="og:url" content="https://imctech.ru/" />
    <meta property="og:image" content="https://imctech.ru/img/main.jpg" />
    <meta property="og:image:secure_url" content="https://imctech.ru/img/main.jpg" />
    <meta property="og:image:type" content="image/jpeg" />

    <link rel="stylesheet" href="/css/form.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/form_mobile.css">
    <script src="/js/nav.js"></script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" href="/css/recaptcha.css">
    <link rel="stylesheet" type="text/css" media="(orientation: portrait)" href="/css/recaptcha_mobile.css">
@endsection

@section('content')
    <div class="reg-box">
        <div class="regname">Авторизация
            <div style="margin: 0 0 0 0;"><?= $error ?></div>
            <div style="margin: 0 0 0 0;"><?= $reason ?></div>
            <div class="reg"><a rel="noopener noreferrer" target="_blank" href="/registration">Регистрация</a></div>
        </div>
        <form name="frmContact" method="post" action="{{ route('login')}}">
            @csrf
            <div class="user-box">
                <input type="text" name="login" required="" autocomplete="off">
                <label>Логин</label>
                <div>ivanov.ii</div>
            </div>
            <div class="user-box" style="margin-bottom: 40px;">
                <input type="password" name="pass" required="" autocomplete="off">
                <label>Пароль</label>
                <div>***</div>
                <a style="bottom: -10px; right: 0;padding: 0 0; font-size:0.13rem" rel="noopener noreferrer" target="_blank" href="/vospass">Забыли пароль?</a>
            </div>
            <div class="g-recaptcha" data-theme="dark" data-sitekey="6LcYs80eAAAAAHcpAI3xP1tKPyGWUXgX01K2Y75R"></div>
            <input class="prikol" type="submit" name="Submit" id="Submit" value="Войти">
        </form>
    </div>
@endsection