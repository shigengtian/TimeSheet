<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        $date_format = date('Y/m/d');
        $now = date($date_format);
        $date_explode = explode("/", $now);
        $year = (int)$date_explode[0];
        $month = (int)$date_explode[1];


        $users = $this->__getUsers();
        $time_sheets = $this->__getTimeSheet($year,$month);
        $renders = [
            'staffs' => $users,
            'time_sheets'=>$time_sheets,
            'page' => 'スタッフ一覧',
        ];

        return view('staff/index', $renders);
    }


    private function __getUsers()
    {
        $conditions = [
            ['active', '=', 1],
        ];

        $res = DB::table('users')
            ->where(
                $conditions
            )
            ->orderby('id', 'ASC')
            ->get();
        return ($res);
    }

    private function __getTimeSheet($year,$month){

        $conditions = [
            ['date', '>=', $year.'/'.$month.'/01']
        ];

        $res = DB::table('timesheets')
            ->where(
                $conditions
            )
            ->orderby('id', 'ASC')
            ->get();

        return $res;
    }
}
