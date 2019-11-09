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
                    <div class="card-header">{{ $project->title }}</div>
                    <div class="card-body">
                        <div class="panel panel-default">
                            <div class="panel-heading">ثبت زمان کاری برای این پروژه</div>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>تاریخ امروز</th>
                                    <th>ثبت ساعت</th>
                                    <th>ساعت شروع</th>
                                    <th>ساعت پایان</th>
                                    <th>تعیین نوع کار</th>
                                    <th>تعیین عنوان برای کار</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <form method="post" action="/task-start/{{ $contributor->id }}">
                                <tr>
                                    <td>
                                        {{ date("Y-m-d") }}
                                    </td>
                                    <td>
                                         <form method="post" action="/task-start/{{ $contributor->id }}">
                                                @csrf
                                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                <button class="btn btn-outline-dark" type="submit" name="start">شروع
                                                </button>
                                            </form>
                                        @else
                                            <form method="post" action="/task-end/{{ $contributor->id }}">
                                                @csrf
                                                <input type="hidden" name="project_id" value="{{ $project->id }}">
                                                <button class="btn btn-outline-dark" type="submit" name="stop">پایان
                                                </button>
                                            </form>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $last_project ? date("H:i:s",strtotime($last_project->start_time)) :'--:--:--'}}
                                    </td>

                                    <td>
                                        @if(($last_project)&&($last_project->stop_time))
                                            {{ date("H:i:s",strtotime($last_project->stop_time)) }}
                                        @else
                                            --:--:--
                                        @endif
                                    </td>

                                    <form method="post" action="/task/{{$contributor->id}}/edit">
                                        @csrf
                                        @method('PATCH')
                                        <td>
                                            <select name="selectBillable">
                                                <option value="1">
                                                    پولی
                                                </option>
                                                <option value="0">
                                                    رایگان
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input typeof="text" name="title" placeholder="عنوان کار">
                                        </td>

                                        <td>
                                            <button class="btn btn-outline-dark" type="submit" name="final_set">ذخیره نهایی</button>
                                        </td>
                                    </form>

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
