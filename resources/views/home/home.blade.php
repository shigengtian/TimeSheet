@extends('layouts.apps')

@section('content')
 <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">2018-02</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>日付</th>
                  <th>曜日</th>
                  <th>出勤時間</th>
                  <th>退勤時間</th>
                  <th>休憩時間</th>
                  <th>作業時間</th>
                </tr>
                @foreach ($calendars as $calendar)
                <tr bgcolor="">
                  <td>{{ $calendar->year."-".$calendar->month."-".$calendar->day }}</td>
                  <td>{{ $calendar->day_of_week_jp }}</td>
                  <td>
                    <input class="fromDateTime" type="text" >
                  </td>
                  <td>
                    <input type="text" >
                  </td>
                  <td>
                    <input type="text" >
                  </td>
                  <td>4</td>
                </tr>
                @endforeach
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>

<script type="text/javascript">
$("#fromDateTime").datepicker("option", "dateFormat", 'yy/mm/dd');
</script>
@endsection
