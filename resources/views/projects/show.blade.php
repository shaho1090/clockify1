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
                    <div class="card-header">{!! $project->title !!}</div>
                    <div class="card-body">
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <h4> لیست افراد شرکت کننده در پروژه</h4>
                            </div>
                               <table class="table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>نام کاربری</th>
                                        <th>آدرس ایمیل</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($projects->user as $user)
                                        <tr>
                                            <td>{!! $user->pivot->id !!}</td>
                                            <td>
                                                <a href="{!! action('ProjectsController@edit') !!}">{!! $user->pivot->name !!} </a>
                                            </td>
                                            <td>{!! $user->pivot->email !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        <div id="accordion">
                        <div class="card-header">
                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                ارسال ایمیل مشارکت در پروژه
                            </a>
                        </div>

                        <div id="collapseTwo" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                               <form action="/contributors/invite" method="post">
                                   <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                   <input type="text" name="email">
                                   <input type="hidden" name="project_id" value={!! $project->id !!}>
                                   <input type="hidden" name="project_title" value={!! $project->title !!}>
                                   <button type="submit" class="btn" >ارسال</button>
                               </form>
                            </div>
                        </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
