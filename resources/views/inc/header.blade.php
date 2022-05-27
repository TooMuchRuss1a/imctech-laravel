<?php
use Illuminate\Support\Facades\Route;
function login()
{
    if (isset($_COOKIE['login']) && (isset($_COOKIE['password']))) {
        $login = $_COOKIE['login'];
        $pass = $_COOKIE['password'];
        $result = DB::table('tbl_reg')->where('login', "$login")->where('email_confirmed', '1')->first();
        if ($result) {
            if (password_verify($pass, $result->password)) {
                if ($result->ban == "0") {
                    date_default_timezone_set('Asia/Vladivostok');
                    $act_date = date("d.m.Y H:i:s");
                    DB::table('tbl_reg')->where('id', "$result->id")->update(array(
                        'last_activity' => "$act_date",
                    ));

                    $msg = '<div class="dropdown1">
                            <button onclick="myFunction()" class="dropbtn1">' . $result->login . '</button>
                            <div id="myDropdown1" class="dropdown1-content">
                            <div class="dd-text">ФИО</div>
                            <div class="dd-text-description">' . $result->name . '</div>
                            <div class="dd-text">Группа</div>
                            <div class="dd-text-description">' . $result->agroup . '</div>
                            <div class="dd-text">ВК</div>
                            <div style="text-transform:lowercase;" class="dd-text-description">' . $result->vk . '</div>
                            <div class="dd-text">email</div>
                            <div style="text-transform:lowercase;" class="dd-text-description">' . $result->email . '</div>
                            <div class="dd-text">Tg ID</div>
                            <div class="dd-text-description">' . $result->tg . '</div>
                            <div class="dd-text"><a href="profile">Профиль</a><a href="login/logout">Выход</a></div>
                            </div>
                          </div>';
                } else {
                    $msg = '<div class="dropdown1">
                            <button onclick="myFunction()" class="dropbtn1" style="color:rgb(255,50,50);">' . $result->login . '</button>
                            <div id="myDropdown1" class="dropdown1-content">
                            <div class="dd-text"><a href="/profile">Профиль</a></div>
                            <div class="dd-text" style="color:rgb(255,50,50);">вы заблокированы</div>
                            <div class="dd-text-description" style="color:rgb(255,50,50);">' . $result->ban . '</div>
                            <div class="dd-text"><a href="/profile">Профиль</a><a href="/login/logout">Выход</a></div>
                            </div>
                          </div>';
                }
            } else {
                setcookie("login", "", time() - (60 * 60 * 24 * 7), "/");
                setcookie("password", "", time() - (60 * 60 * 24 * 7), "/");
                $msg = '<a class="nav_link" href="/login">Войти</a>';
            }
        } else {
            setcookie("login", "", time() - (60 * 60 * 24 * 7), "/");
            setcookie("password", "", time() - (60 * 60 * 24 * 7), "/");
            $msg = '<a class="nav_link" href="/login">Войти</a>';
        }
    } else {
        $msg = '<a class="nav_link" href="/login">Войти</a>';
    }

    return $msg;
}


?>

@section('header')
<header id="nav" class="header">
    <div class="header_inner">
        <div class="header_logo">
            <a class="header_logo_link" href="<?php if (Route::current()->getName() == "home") {echo "#";} else {echo "/";} ?>"><img class="header_logoimg" src="/img/logos/imctech.png"><text> IMCTech</text></a>
        </div>
        <div class="nav">
            <?php echo login() ?>
        </div>
    </div>
</header>