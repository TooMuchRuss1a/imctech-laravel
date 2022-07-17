<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function __construct(AnalyticsController $analyticsController, AuthController $authController)
    {
        $this->analiticsController = $analyticsController;
        $this->authController = $authController;
    }

    public function getAdminData(){
        $data = [];
        $data['tbl_reg'] = DB::table('tbl_reg')->count();
        $data['tbl_psession2022'] = DB::table('tbl_psession2022')->count();
        $data['tbl_springpschool2022'] = DB::table('tbl_springpschool2022')->count();

        return $data;
    }

    public function isAdmin($user) {
        if (empty($user)) {
            return false;
        }
        if ($user->is_admin == '1') {
            return true;
        }
        else {
            return false;
        }
    }

    public function admin(Request $request)
    {
        $user = $this->authController->cookieAuth($request);
        if ($this->isAdmin($user)) {
            return view('admin', ['user' => $user, 'data' => $this->getAdminData()]);
        }
        else {
            return redirect()->route('home');
        }
    }

    public function adminTable(Request $request, $table)
    {
        $user = $this->authController->cookieAuth($request);
        if ($this->isAdmin($user)) {
            switch ($table) {
                case 'reg':
                    $tableData = DB::table('tbl_reg')
                        ->select('id', 'login', 'email', 'name', 'agroup', 'vk', 'email_confirmed', 'ban', 'is_admin', 'reg_date', 'last_activity')
                        ->get();
                    break;
                case 'psession2022':
                    $tableData = DB::table('tbl_psession2022')
                        ->select('id', 'name', 'agroup', 'vk', 'email', 'reg_date')
                        ->get();
                    break;
                case 'springpschool2022':
                    $tableData = DB::table('tbl_springpschool2022')
                        ->select('id', 'name', 'agroup', 'vk', 'email', 'reg_date', 'project')
                        ->get();
                    break;
                default:
                    return abort(404);
            }
            $row = $tableData->first();
            return view('adminTable', ['user' => $user, 'tableData' => $tableData, 'keys' => array_keys(get_object_vars($row)), 'data' => $this->getAdminData()]);
        }
        else {
            return redirect()->route('home');
        }
    }


}
