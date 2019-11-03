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
                    <div class="card-header">لیست پروژه ها</div>
                    <div class="card-body">
                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <h3> لیست پروژه های شما </h3>
                            </div>
                            @if (is_null($projects))
                                <p> هنوز هیچ پروژه ای  توسط شما ایجاد نشده است.</p>
                            @else
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>نقش شما</th>
                                        <th>عنوان پروژه</th>
                                        <th>مشاهده انجام کار</th>
                                        <th>دعوت به همکاری در این پروژه</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($projects as $project)
                                        <tr>
                                            <td>@if ( $project->pivot->access == 0 )
                                                    {{ 'owner' }}
                                                @elseif ($project->pivot->access == 1)
                                                    {{ 'admin' }}
                                                @else
                                                    {{'user'}}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{!! action('ProjectsController@editProject', $project) !!}">{!! $project->title !!} </a>
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-dark"><a href="{!! action('WorksController@index', $project->id) !!}">مشاهده زمان های کاری</a></button>
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-dark"><a href="{!! action('ProjectsController@show', $project->id) !!}">دعوت به همکاری</a></button>
                                            </td>

                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                        <div id="accordion">
                        <div class="card-header">
                            <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                اضافه کردن پروژه جدید
                            </a>
                        </div>

                        <div id="collapseTwo" class="collapse" data-parent="#accordion">
                            <div class="card-body">
                               <form action="/projects/add" method="post">

                                   <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                   <input type="text" name="project_title">
                                  <button type="submit" class="btn" >ثبت</button>
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
