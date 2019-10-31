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
                    <div class="card-header">{{ $project_title }}</div>
                    <div class="card-body">
                        <div class="panel panel-default">
                              <div class="panel-heading">ثبت زمان کاری برای این پروژه</div>


                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th>تاریخ</th>
                                            <th>ساعت شروع</th>
                                            <th>ساعت پایان</th>


                                        </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <button class="btn btn-outline-dark"><a href="{!! action('WorksController@setStartTime',$project_id) !!}">شروع </a></button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-outline-dark"><a href="{!! action('WorksController@setStopTime') !!}">پایان</a></button>
                                                </td>
                                                <td>
                                                    {{ date("Y-m-d") }}
                                                </td>
                                                <td>
                                                    {{ $works->start_time ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $works->stop_time ?? ''}}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>

                            </div>

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4> لیست زمان های کاری شما</h4>
                            </div>
                            @if ($works===null)
                                <p> شما تاکنون برای این پروژه زمان کار ثبت نکرده اید!</p>
                            @else
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>عنوان پروژه</th>
                                        <th>تاریخ</th>
                                        <th>ساعت شروع</th>
                                        <th>ساعت پایان</th>
                                        <th>تگ</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($works as $work)
                                        <tr>
                                            <td>

                                            </td>
                                            <td>
                                                <a href="{!! action('ProjectsController@show', $work->id) !!}">{!! $work->title !!} </a>
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-dark"><a href="{!! action('ProjectsController@show', $project->id) !!}">شروع به انجام کار </a></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>

                </div>

            </div>
        </div>
    </div>
    </div>>
@endsection
