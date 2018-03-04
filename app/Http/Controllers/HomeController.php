<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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
        $calendars = $this->__getCalendars($year, $month);

        $renders = [
            'calendars' => $calendars,
        ];

        if ($request->isMethod('post')) {
            $date = $request->date;
            $start_time = $request->start_time;
            $end_time = $request->end_time;
            $rest_time = $request->rest_time;

            $res_vali = $this->__validation_timeSheet($date, $start_time, $end_time, $rest_time);

            if($res_vali == True){
                $res = $this->__saveTimeSheet($date, $start_time, $end_time, $rest_time);
            }else{
                dd($res_vali);
            }


        }
        return view('home/home', $renders);
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

        $res = True;
        $now_time = date("Y-m-d H:i:s");
        DB::beginTransaction();
        try {
            for ($i = 0; $i < count($date); $i++) {

                $timesheet_count = DB::table('timesheets')
                    ->where([
                        ['staff_id', '=', $stff_id],
                        ['date', '=', $date[$i]],
                    ])
                    ->count();
                $to_save = array(
                    'date' => (string) $date[$i],
                    'start_time' => (string) $start_time[$i],
                    'end_time' => (string) $end_time[$i],
                    'rest_time' => (string) $rest_time[$i],
                    'staff_id' => $stff_id
                );

                if ($timesheet_count == 0) {
                    $to_save = array_merge($to_save, array('created_time'=>$now_time));
                    DB::table('timesheets')->insert($to_save);
                } else if ($timesheet_count > 0) {
                    $to_save = array_merge($to_save, array('update_time'=>$now_time));
                    DB::table('timesheets')
                        ->where([
                            ['staff_id', '=', $stff_id],
                            ['date', '=', $date[$i]]])
                        ->update($to_save);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            $res = False;
            DB::rollback();
        }
        return $res;
    }

    private function __validation_timeSheet($date, $start_time, $end_time, $rest_time)
    {
        $vali_flag = true;

        for ($i = 0; $i < count($date); $i++) {
            if(preg_match('/^(?:[01][0-9]|2[0-3]):[0-5][0-9]$/',$date[$i]) || strlen($date[$i]) == 0) {
                $vali_flag = false;
            }
            if(preg_match('/^(?:[01][0-9]|2[0-3]):[0-5][0-9]$/',$start_time[$i]) || strlen($date[$i]) == 0) {
                $vali_flag = false;
            }
            if(preg_match('/^(?:[01][0-9]|2[0-3]):[0-5][0-9]$/',$end_time[$i]) || strlen($date[$i]) == 0) {
                $vali_flag = false;
            }
            if(preg_match('/^(?:[01][0-9]|2[0-3]):[0-5][0-9]$/',$rest_time[$i]) || strlen($date[$i]) == 0) {
                $vali_flag = false;
            }
            if($vali_flag == false){
                break;
            }
        }

        return $vali_flag;
    }
}
