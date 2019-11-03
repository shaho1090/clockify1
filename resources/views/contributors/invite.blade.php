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
                    <div class="card-header">ارسال ایمیل جهت دعوت به همکاری در  این پروژه </div>
                    <div class="card-body">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4>{!! $project->title !!}</h4>
                            </div>
                            <form action="/contributors/sendEmail" method="post">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>ارسال ایمیل</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>ایمیل :</td>
                                        <td> <input type="text" name="email" style="width:200px;"> </td>
                                        <td><input type="hidden" name="project_id" value="{!! $project->id !!}"></td>
                                        <td><button type="submit" class="btn btn-outline-danger" >ارسال</button></td>
                                     </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
