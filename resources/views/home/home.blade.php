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
                            </tr>
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
                                        $end_time = ($time_sheets[$loop->index]->end_time != null)? $time_sheets[$loop->index]->end_time : '';
                                        $rest_time = ($time_sheets[$loop->index]->rest_time != null)? $time_sheets[$loop->index]->rest_time : '';
                                   }else{
                                        $start_time = '';
                                        $end_time = '';
                                        $rest_time = '';
                                   }

                                @endphp

                                <tr bgcolor={{$holiday_color}}>
                                    <td>{{ $calendar->year."-".$calendar->month."-".$calendar->day }}</td>
                                    <input name="date[]" type="hidden"
                                           value="{{$calendar->year."-".$calendar->month."-".$calendar->day}}">
                                    <td>{{ $calendar->day_of_week_jp.$holiday_name}}</td>
                                    <td class="bootstrap-timepicker">
                                        <input class="start_time {{$holiday_time_class}}" type="text"
                                               name="start_time[]" value="{{$start_time}}">
                                    </td>
                                    <td class="bootstrap-timepicker">
                                        <input class="end_time {{$holiday_time_class}}" type="text" name="end_time[]" value="{{$end_time}}">
                                    </td>
                                    <td class="bootstrap-timepicker">
                                        <input class="rest_time {{$holiday_time_class}}" type="text" name="rest_time[]" value="{{$rest_time}}">
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary pull-right">出退勤时间登録</button>
                        </div>
                    </div>
                </form>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>

    <script>
        $(function () {
            $('.start_time').timepicker({
                minuteStep: 1,
                showInputs: false,
                showMeridian: false, //24hr mode
                defaultTime: '09:00',
            });
            $('.end_time').timepicker({
                minuteStep: 1,
                showInputs: false,
                showMeridian: false, //24hr mode
                defaultTime: '18:00',
            });
            $('.rest_time').timepicker({
                minuteStep: 1,
                showInputs: false,
                showMeridian: false, //24hr mode
                defaultTime: '1:00',
            });
            $('.defult_time_no').val('');

        });
    </script>
@endsection