@extends('layouts.app')
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-right">
            <div class="col-lg">
                <div class="card">
                    <div class="card-header">لیست پروژه ها</div>
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

                    <div class="card-body">
                        <div class="panel panel-default">
                            @foreach ($errors->all() as $error)
                                <p class="alert alert-danger">{{ $error }}</p>
                            @endforeach
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="panel-heading">
                                <h3> لیست افراد مشارکت کننده در این پروژه </h3>
                            </div>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>نام</th>
                                        <th>آدرس ایمیل</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($contributors as $contributor)
                                        <tr>
                                            <td>{!! $contributor->name !!}</td>
                                            <td>{!! $contributor->email !!} </td>
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
