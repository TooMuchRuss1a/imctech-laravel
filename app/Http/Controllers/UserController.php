<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Event;
use App\Models\Social;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function home(Request $request)
    {
        return view('home');
    }

    public function pschool(Request $request)
    {
        $students = Event::findOrFail(2)->activities()->count();

        return view('pschool', ['students' => $students]);
    }

    public function psession(Request $request)
    {
        $students = Event::findOrFail(3)->activities()->count();

        return view('psession', ['students' => $students]);
    }

    public function analytics(Request $request) {
        $students = Activity::where('event_id', 2)->get()->count();
        $groups = array();
        $users = Event::findOrFail(2)
            ->join('activities', 'activities.event_id', '=', 'events.id')
            ->join('users', 'users.id', '=', 'activities.user_id')
            ->orderBy('agroup')
            ->get();

        foreach ($users as $user) {
            if (isset($groups[substr($user->agroup, 7)])) {
                $groups[substr($user->agroup, 7)]++;
            }
            else {
                $groups[substr($user->agroup, 7)] = 1;
            }
        }
        ksort($groups);

        return view('analytics', [
            'students' => $students,
            'groups' => $groups
        ]);
    }

    public function psessionReg(Request $request) {
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
}
