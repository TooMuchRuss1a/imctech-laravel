<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function auth($login, $password)
    {
        $user = DB::table('tbl_reg')
            ->where('login', $login)
            ->where('email_confirmed', '1')
            ->first();
        if ($user) {
            if (password_verify($password, $user->password)) {
                if ($user->ban == "0") {
                    date_default_timezone_set('Asia/Vladivostok');
                    $act_date = Carbon::now()->format('Y-m-d H:i:s.u');
                    DB::table('tbl_reg')
                        ->where('id', "$user->id")
                        ->update([
                        'last_activity' => $act_date
                        ]);
                    $this->setCookie('login', $login, 43200);
                    $this->setCookie('password', $password, 43200);
                }
                return $user;
            }
        }
        return false;
    }

    public function cookieAuth(Request $request)
    {
        if (!empty($request->cookie('login')) && !empty($request->cookie('password'))) {
            return $this->auth($request->cookie('login'), $request->cookie('password'));
        }
        return false;
    }

    public function setCookie($name, $value, $lifetime){
        Cookie::queue($name, $value, $lifetime);
    }
    public function getCookie($name){
        echo Cookie::get($name);
    }

    public function forgetCookie($name){
        Cookie::queue(Cookie::forget($name));
    }
}
