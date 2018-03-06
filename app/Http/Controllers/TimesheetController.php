<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimesheetController extends Controller
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

        if ($request->isMethod('post')) {
            $date = $request->date;
            $start_time = $request->start_time;
            $end_time = $request->end_time;
            $rest_time = $request->rest_time;

            $validator = $this->__validation_timeSheet($date, $start_time, $end_time, $rest_time);

            if ($validator == True) {
                $res = $this->__saveTimeSheet($date, $start_time, $end_time, $rest_time);
                if($res == true){
                    $request->session()->flash('sucess', '出退勤时间登録登録しました!!!');
                }
            } else {
                $request->session()->flash('error', '時間を正しく入力してください!!!');
            }
        }

        $calendars = $this->__getCalendars($year, $month);
        $time_sheets = $this->__getTimeSheet($year,$month);
        $renders = [
            'calendars' => $calendars,
            'time_sheets'=>$time_sheets,
            'page' => '勤務状況照会',
        ];

        return view('timesheet/index', $renders);
    }


    private function __getCalendars($year, $month)
    {
        $conditions = [
            ['year', '=', $year],
            ['month', '=', $month]
        ];

        $calendars = DB::table('calendars')
            ->where(
                $conditions
            )
            ->orderby('id', 'ASC')
            ->get();
        return ($calendars);
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
