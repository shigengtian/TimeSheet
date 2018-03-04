<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\IsFalse;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $date_format = date('Y/m/d');
        $now = date($date_format);
        $date_explode = explode("/", $now);
        $year = (int)$date_explode[0];
        $month = (int)$date_explode[1];

        $calendars = $this->__getCalendars($year, $month);
        $renders = [
            'calendars' => $calendars,
        ];

        return view('home/home', $renders);
    }

    public function postTimeSheet(Request $request)
    {
        $date = $request->date;
        $start_time = $request->start_time;
        $end_time = $request->end_time;
        $rest_time = $request->rest_time;

        for ($i = 0; $i < count($date); $i++) {

            $res_vali = $this->__validation_timeSheet($start_time[$i],$end_time[$i],$rest_time[$i]);

            $res = $this->__saveTimeSheet($date[$i], $start_time[$i], $end_time[$i], $rest_time[$i]);
            if ($res == False) {
                return ('error message');
                break;
            }
        }


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

    private function __saveTimeSheet($date, $start_time, $end_time, $rest_time)
    {
        $stff_id = Auth::user()->id;

        $timesheet_count = DB::table('timesheets')
            ->where([
                ['staff_id', '=', $stff_id],
                ['date', '=', $date],
            ])
            ->count();

        $to_save = array(
            'date' => (string)$date,
            'start_time' => (string)$start_time,
            'end_time' => (string)$end_time,
            'rest_time' => (string)$rest_time,
            'staff_id' => $stff_id
        );

        if ($timesheet_count == 0) {

            $res = DB::table('timesheets')->insert($to_save);

        } else if ($timesheet_count > 0) {
            $res = DB::table('timesheets')
                ->where([
                    ['staff_id', '=', $stff_id],
                    ['date', '=', $date]])
                ->update($to_save);
        }

        return $res;
    }

    private function __validation_timeSheet($start_time, $end_time, $rest_time)
    {
        return True;

    }
}
