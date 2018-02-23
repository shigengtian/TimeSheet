<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $date_format = date('Y/m/d');
        $now = date($date_format);
        $date_explode = explode("/", $now);
        $year = (int)$date_explode[0];
        $month = (int)$date_explode[1];

        $calendars = $this->__getCalendars($year, $month);

        
        return view('home/home', ['calendars' => $calendars]);
    }


    private function __getCalendars($year, $month){

        $conditions = [
            ['year', '=', $year],
            ['month', '=', $month]
        ];

        $calendars = DB::table('calendars')
                                    ->where(
                                        $conditions
                                    )
                                    ->orderby('id','ASC')    
                                    ->get();
        return($calendars);
    }
}
