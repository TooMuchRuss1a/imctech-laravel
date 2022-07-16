<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

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

    public function psession(Request $request)
    {
        $user = $this->authController->cookieAuth($request);
        $students = $this->analiticsController->psessionCounter();
        return view('psession', [
            'user' => $user,
            'students' => $students
        ]);
    }

    public function login(Request $request)
    {
        $user = $this->authController->cookieAuth($request);
        if (!empty($user)) {
            (empty($request->cookie('previous_route'))) ? $to = 'home' : $to = $request->cookie('previous_route');
            $this->authController->forgetCookie('previous_route');
            return redirect()->route($to);
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
                    if (!empty($user)) {
                        (empty($request->cookie('previous_route'))) ? $to = 'home' : $to = $request->cookie('previous_route');
                        $this->authController->forgetCookie('previous_route');
                        return redirect()->route($to);
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

    public function registration(Request $request)
    {
        $user = $this->authController->cookieAuth($request);
        $error = "";
        $data = [];
        if (isset($_REQUEST['Submit'])) {
            $data['email'] = $_REQUEST['email'];
            $data['name'] = $_REQUEST['name'];
            $data['agroup'] = $_REQUEST['agroup'];
            $data['vk'] = $_REQUEST['vk'];

            // Все последующие проверки, проверяют форму и выводят ошибку
            // Проверка на совпадение паролей
            if ($_REQUEST['pass'] !== $_REQUEST['pass_rep']) {
                $error = 'Пароль не совпадает';
            }

            // Проверка есть ли вообще повторный пароль
            if (!$_REQUEST['pass_rep']) {
                $error = 'Введите повторный пароль';
            }

            // Проверка есть ли пароль
            if (!$_REQUEST['pass']) {
                $error = 'Введите пароль';
            }

            // Проверка есть ли email
            if ((strpos($_REQUEST['email'], 'dvfu.ru') == false)) {
                $error = 'Введите корпоративный email ДВФУ';
            }

            // Проверка есть ли ФИО
            if (!$_REQUEST['name']) {
                $error = 'Введите ФИО';
            }

            // Проверка ФИО на наличие только букв
            if (preg_match('/[^а-я ^ё]+/msiu', $_REQUEST['name'])) {
                $error = 'Введите ФИО только русскими буквами';
            }

            // Проверка есть ли группа
            if (!$_REQUEST['agroup']) {
                $error = 'Введите группу';
            }

            $emailID = DB::table('tbl_reg')
                ->where('email', $_REQUEST['email'])
                ->where('email_confirmed', '1')
                ->count();

            if ($emailID > 0) {
                $error = 'Эта почта уже зарегистрирована';
            }

            if (isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
                $secret = env('RECAPTCHA_SECRET');
                $ip = $_SERVER['REMOTE_ADDR'];
                $response = $_POST['g-recaptcha-response'];
                $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
                $arr = json_decode($rsp, TRUE);
                if ($arr['success']) {
                } else {
                    $error = "Капча не пройдена";
                }
            } else {
                $error = 'Не установлен флажок "Я не робот"';
            }

            // Если ошибок нет, то происходит регистрация
            if (!$error) {
                $mass = explode("@", $data['email']);
                $data['login'] = $mass[0];

                // Пароль хешируется
                $data['password'] = password_hash($_REQUEST['pass'], PASSWORD_DEFAULT);
                // хешируем хеш, который состоит из логина и времени
                $data['hash'] = md5($data['login'] . time());

                date_default_timezone_set('Asia/Vladivostok');
                $reg_date = Carbon::now()->format('Y-m-d H:i:s.u');
                DB::table('tbl_reg')->insert([
                    'id' => 0,
                    'login' => $data['login'],
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'agroup' => $data['agroup'],
                    'vk' => $data['vk'],
                    'password' => $data['password'],
                    'hash' => $data['hash'],
                    'email_confirmed' => 0,
                    'ban' => 0,
                    'is_admin' => 0,
                    'reg_date' => $reg_date,
                    'last_activity' => $reg_date
                ]);
                $details = [
                    'link' => 'http://imctech.ru/confirm/' . $data['hash']
                ];

                Mail::to($data['email'])->send(new \App\Mail\ConfirmEmail($details));
                redirect('/confirm');
            }
        }
        return view('registration', [
            'user' => $user,
            'error' => $error,
            'data' => $data
        ]);
    }

    public function confirm(Request $request) {
        $user = $this->authController->cookieAuth($request);
        return view('confirm', [
            'user' => $user,
        ]);
    }

    public function confirmed(Request $request) {
        $user = $this->authController->cookieAuth($request);
        return view('confirmed', [
            'user' => $user,
        ]);
    }

    public function confirmHash($hash) {
        if ($result = DB::table('tbl_reg')
            ->where ([
                'hash' => $hash,
                'email_confirmed' => '0'
            ])
            ->first()
        )
        {
            DB::table('tbl_reg')
                ->where('id', "$result->id")
                ->update([
                    'email_confirmed' => '1'
                ]);
            return redirect('/confirmed');
        } else {
            return redirect('/');
        }
    }
    public function psessionReg(Request $request) {
        $user = $this->authController->cookieAuth($request);
        $error = '';
        if (empty($user)) {
            $this->authController->setCookie('previous_route', $request->route()->getName(), 3600);
            return redirect('/login');
        }
        if (isset($_REQUEST['prikol'])) {
            if ($emailID = DB::table('tbl_psession2022')
                ->where('email', $user->email)
                ->count() > 0) {
                return view('adWindow', [
                    'user' => $user,
                    'error' => 'Ты уже участвуешь в мероприятии'
                ]);
            }
            else {
                date_default_timezone_set('Asia/Vladivostok');
                $reg_date = Carbon::now()->format('Y-m-d H:i:s.u');
                DB::table('tbl_psession2022')->insert([
                    'id' => 0,
                    'name' => $user->name,
                    'agroup' => $user->agroup,
                    'vk' => $user->vk,
                    'email' => $user->email,
                    'reg_date' => $reg_date
                ]);
                return view('adWindow', [
                    'user' => $user,
                    'error' => ''
                ]);
            }
        }
        return view('psessionReg', [
            'user' => $user,
            'error' => $error
        ]);
    }

    public function vospass(Request $request) {
        $user = $this->authController->cookieAuth($request);
        $error = '';
        if (isset($_REQUEST['Submit'])) {
            $email = $_REQUEST['email'];
            if (strpos($_REQUEST['email'], 'dvfu.ru') == true) {
                if (isset($_POST['g-recaptcha-response']) && $_POST['g-recaptcha-response']) {
                    $secret = env('RECAPTCHA_SECRET');
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $response = $_POST['g-recaptcha-response'];
                    $rsp = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$ip");
                    $arr = json_decode($rsp, TRUE);
                    if ($arr['success']) {
                        $result = DB::table('tbl_reg')
                            ->where([
                                'email' => $email,
                                'email_confirmed' => '1'
                            ])
                            ->first();

                        if (!empty($result)) {
                            $details['hash'] = md5($email . time());

                            Mail::to($email)->send(new \App\Mail\Vospass($details));

                            DB::table('tbl_reg')
                                ->where('id', "$result->id")
                                ->update([
                                    'hash' => $details['hash']
                                ]);
                            return redirect()->route('vospassAnswer');
                        }
                        else {$error = "Почты не существует";}
                    }
                    else {$error = "Капча не пройдена";}
                }
                else {$error = 'Не установлен флажок "Я не робот"';}
            } else {
                $error = "Введите корпоративную почту ДВФУ";
            }
        }
        return view('vospass', [
            'user' => $user,
            'error' => $error
        ]);
    }

    public function vospassHash(Request $request, $hash) {
        $user = $this->authController->cookieAuth($request);
        $error = '';
        $result = DB::table('tbl_reg')
            ->where([
                'hash' => $hash
            ])
            ->first();
        if (!empty($result)) {
            if (isset($_REQUEST['Submit'])) {
                if ($_REQUEST['new_pass'] == $_REQUEST['new_pass_rep']) {
                    $new_pass = $_REQUEST['new_pass'];
                    $hased_pass = password_hash($new_pass, PASSWORD_DEFAULT);
                    $new_hash = md5($hash . time());
                    DB::table('tbl_reg')
                        ->where('id', "$result->id")
                        ->update([
                            'password' => $hased_pass,
                            'hash' => $new_hash
                        ]);
                    return redirect()->route('login');
                } else $error = 'Пароли не совпадают';
            }
        } else return redirect()->route('home');
        return view('vospassHash', [
            'error' => $error,
            'user' => $user,
            'hash' => $hash
        ]);
    }

    public function vospassAnswer(Request $request) {
        $user = $this->authController->cookieAuth($request);
        return view('vospassAnswer', [
            'user' => $user,
        ]);
    }
}
