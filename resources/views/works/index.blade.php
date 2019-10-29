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

                            <div class="panel-heading">
                                <h3> لیست زمان های کاری شما</h3>
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
                                             <button class="btn btn-outline-dark"><a href="{!! action('ProjectsController@show', $project->id) !!}">شروع به انجام کار </a>
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
@endsection
