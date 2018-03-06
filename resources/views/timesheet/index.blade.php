@extends('layouts.apps')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">2018-02</h3>

                </div>
                <form method="post" action="home">
                @csrf
                <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table">
                            <tr>
                                <th class="col-xs-2">日付</th>
                                <th>曜日</th>
                                <th>出勤時間</th>
                                <th>退勤時間</th>
                                <th>休憩時間</th>
                                <th>作業時間</th>
                            </tr>
                            @php
                                $sum_job_time = 0;
                            @endphp
                            @foreach ($calendars as $calendar)
                                @php
                                    if(strlen(trim($calendar->public_holiday))>0 || in_array($calendar->day_of_week,[0,6])){
                                      $holiday_color = '#A9E2F3';
                                      $holiday_time_class = 'defult_time_no';
                                  }else{
                                      $holiday_color = '';
                                      $holiday_time_class = '';
                                   }
                                   if(strlen(trim($calendar->public_holiday))>0){
                                      $holiday_name = '  ('.$calendar->public_holiday.')';
                                  }else{
                                      $holiday_name = '';
                                   }

                                   if (count($time_sheets) > 0){
                                        $start_time = ($time_sheets[$loop->index]->start_time != null)? $time_sheets[$loop->index]->start_time : '';
                                        if($start_time != ''){
                                            $start_time_explode = explode(":", $start_time);
                                            $start_time_minutes = (int)($start_time_explode[0])*60 + (int)($start_time_explode[1] / 15) * 15;
                                        }
                                        $end_time = ($time_sheets[$loop->index]->end_time != null)? $time_sheets[$loop->index]->end_time : '';
                                        if($end_time != ''){
                                            $end_time_explode = explode(":", $end_time);
                                            $end_time_minutes = (int)($end_time_explode[0])*60 + (int)($start_time_explode[1] / 15) * 15;
                                        }
                                        $rest_time = ($time_sheets[$loop->index]->rest_time != null)? $time_sheets[$loop->index]->rest_time : '';
                                         if($rest_time != ''){
                                            $rest_time_explode = explode(":", $rest_time);
                                            $rest_time_minutes = (int)($rest_time_explode[0])*60 + (int)($rest_time_explode[1] / 15) * 15;
                                        }
                                        if($start_time != '' && $end_time != '' && $rest_time != ''){
                                            $job_time = ($end_time_minutes-$start_time_minutes-$rest_time_minutes)/60;
                                            $sum_job_time += $job_time;
                                        }else{
                                            $job_time = '';
                                        }
                                   }else{
                                        $start_time = '';
                                        $end_time = '';
                                        $rest_time = '';
                                   }
                                @endphp
                                <tr bgcolor={{$holiday_color}}>
                                    <td>{{ $calendar->year."-".$calendar->month."-".$calendar->day }}</td>
                                    <td>{{ $calendar->day_of_week_jp.$holiday_name}}</td>
                                    <td>{{$start_time}}</td>
                                    <td>{{$end_time}}</td>
                                    <td>{{$rest_time}}</td>
                                    <td>{{$job_time}}</td>
                                </tr>
                            @endforeach
                            <tr bgcolor="#ffffc0">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>合計:</td>
                                <td>{{$sum_job_time}}</td>
                            </tr>
                        </table>
                        <div class="box-footer">
                            <button class="btn btn-primary pull-right">印刷レビュー</button>
                        </div>
                    </div>
                </form>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection