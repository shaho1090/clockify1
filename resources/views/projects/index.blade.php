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
                            <div id="accordion">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                        اضافه کردن پروژه جدید
                                    </a>
                                </div>
                                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <form action="store" method="post">
                                            @csrf
                                            <input type="text" name="project_title" required autocomplete="name" autofocus>
                                            <button type="submit" class="btn" >ثبت</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-heading">
                                <h3> لیست پروژه های شما </h3>
                            </div>
                            @if (is_null($projects))
                                <p> هنوز هیچ پروژه ای  توسط شما ایجاد نشده است.</p>
                            @else
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>عنوان پروژه</th>
                                        <th>مشاهده انجام کار</th>
                                        <th>دعوت به همکاری در این پروژه</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($projects as $project)
                                        <tr>
                                            <td>
                                                <a href="show/{{$project->id}}">{!! $project->title !!} </a>
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-dark"><a href="/works/index/{{$project->id}}">مشاهده زمان های کاری</a></button>
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-dark"><a href="">دعوت به همکاری</a></button>
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
    </div>
@endsection
