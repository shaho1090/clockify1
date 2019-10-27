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
                            @if ($contributors->isEmpty())
                                <p> هنوز هیچ کس برای مشارکت در این پروژه اقدام نکرده است.</p>
                            @else
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>نام کاربری</th>
                                        <th>آدرس ایمیل</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($contributors as $contributor)
                                        <tr>
                                            <td>{!! $contributor->id !!}</td>
                                            <td>
                                                <a href="{!! action('ProjectsController@edit', $contributor->id) !!}">{!! $contributor->name !!} </a>
                                            </td>
                                            <td>{!! $contributor->email !!}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div id="accordion">
                        <div class="card-header">
                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                ارسال ایمیل مشارکت در پروژه
                            </a>
                        </div>

                        <div id="collapseTwo" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                               <form action="/contributors/add" method="post">

                                   <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                   <button type="submit" class="btn" >ارسال</button>
                                   <input type="text" name="project_title">

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
