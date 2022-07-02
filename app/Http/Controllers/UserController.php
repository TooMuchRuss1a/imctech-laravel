<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(AnalyticsController $analyticsController, AuthController $authController)
    {
        $this->analiticsController = $analyticsController;
        $this->authController = $authController;
    }

    public function home(Request $request)
    {
        $service = new AuthController();
        $user = $service->cookieAuth($request);
        return view('home', ['user' => $user]);
    }

    public function pschool(Request $request)
    {
        $user = $this->authController->cookieAuth($request);
        $students = $this->analiticsController->pschoolCounter();
        return view('pschool', [
            'user' => $user,
            'students' => $students
        ]);
    }

    public function login(Request $request)
    {
        $user = $this->authController->cookieAuth($request);
        if (!empty($user)) {
            return redirect('/');
        }
        $error = "";
        $reason = "";
        $secret = env('RECAPTCHA_SECRET');

        if (isset($_REQUEST['Submit'])) {
            if (isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
                $ip = $_SERVER['REMOTE_ADDR'];
                $response = $_POST['g-recaptcha-response'];
                $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
                $arr = json_decode($rsp, TRUE);
                if ($arr['success']) {
                    $login = $_REQUEST['login'];
                    $password = $_REQUEST['pass'];
                    $user = $this->authController->auth($login, $password);
                } else {
                    $error = "Капча не пройдена";
                }
            } else {
                $error = 'Не установлен флажок "Я не робот"';
            }

            if (strpos($_REQUEST['login'], 'dvfu.ru') == true) {
                $error = "Логин = почта без @students.dvfu.ru";
            }
            if (empty($user)) {
                $error = "Неверное имя пользователя или пароль";
            }
            elseif ($user->ban == "0") return redirect('/');
            else {
                $error = "Вы заблокированы";
                $reason = $user->ban;
            }
        }
        return view('login', ['user' => $user, 'error' => $error, 'reason' => $reason]);
    }

    public function logout() {
        $this->authController->forgetCookie('login');
        $this->authController->forgetCookie('password');
        return redirect('/');
    }

    public function analytics(Request $request) {
        $user = $this->authController->cookieAuth($request);
        $students = $this->analiticsController->pschoolCounter();
        $groups = $this->analiticsController->getGroups();
        $projects = $this->analiticsController->getProjects();
        return view('analytics', [
            'user' => $user,
            'students' => $students,
            'groups' => $groups,
            'projects' => $projects
        ]);
    }

}
