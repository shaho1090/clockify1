@extends('layouts.app')
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-right">
            <div class="col-lg">
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="card">
                    <div class="card-header">ویرایش ساعت کاری </div>
                    <div class="card-body">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4></h4>
                            </div>
                            <form action="/works/storeEdited" method="post">
                              <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                              <table class="table">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>ساعت شروع به کار</th>
                                    <th>ساعت پایان کار</th>
                                    <th>مدت زمان کار </th>
                                    <th>فی </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{!!$work->id !!}</td>
                                        <td>{!!date('H:i:s',strtotime($work->start_time)) !!}</td>
                                        <td>{!!date('H:i:s',strtotime($work->stop_time)) !!}</td>
                                        <td>{!!gmdate('H:i:s',$totalDuration) !!}</td>
                                        <td>
                                            <select name="selectBillable">
                                                <option value="{!! $work->billable !!}">
                                                    {!! $work->billable ? 'پولی' : 'رایگان' !!}
                                                </option>
                                                <option value="{!! !$work->billable !!}">
                                                    {!! $work->billable ?  'رایگان' :'پولی' !!}
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                                <input type="hidden" name="work_id" value="{!! $work->id !!}">
                                <button type="submit" class="btn btn-outline-danger" >ثبت تغییرات</button>
                           </form>

                         </div>

                     </div>
                </div>
            </div>
        </div>
    </div>
@endsection
