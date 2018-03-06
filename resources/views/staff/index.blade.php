@extends('layouts.apps')

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table class="table">
                            <tr>
                                <th class="col-xs-2">ID</th>
                                <th>名前</th>
                                <th>電話番号</th>
                                <th>メールアドレス</th>
                                <th></th>
                            </tr>
                            @foreach ($staffs as $staff)
                                <tr>
                                    <td>{{ $staff->id }}</td>
                                    <td>{{ $staff->name }}</td>
                                    <td>{{ $staff->phone }}</td>
                                    <td>{{ $staff->email }}</td>
                                    <td>{{ $staff->id }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@endsection