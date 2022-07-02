<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function pschoolCounter() {
        return DB::table('tbl_springpschool2022')->count();
    }

    public function getGroups() {
        $groups = array();
        $result = DB::table('tbl_springpschool2022')->orderBy('agroup')->get();
        foreach ($result as $row) {
            if (isset($groups[substr($row->agroup, 7)])) {
                $groups[substr($row->agroup, 7)]++;
            }
            else {
                $groups[substr($row->agroup, 7)] = 1;
            }
        }
        ksort($groups);
        return $groups;
    }

    public function getProjects() {
        return DB::table('tbl_projects')->orderBy('id', 'DESC')->get();
    }
}
