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
                                    <tr>
                                        <td>
                                            {{ date("Y-m-d") }}
                                        </td>

                                        <td>
                                            @if (! $last_project)
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
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4> لیست زمان های کاری شما</h4>
                            </div>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>عنوان پروژه</th>
                                    <th>عنوان کار</th>
                                    <th>تاریخ</th>
                                    <th>ساعت شروع</th>
                                    <th>ساعت پایان</th>
                                    <th>نوع کار</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($contributor->works as $work)
                                    <tr>
                                        <td>{{ $project->title }}</td>

                                        <td>
                                            {{ $work->title }}
                                        </td>

                                        <td>
                                            {{ date("Y-m-d",strtotime($work->created_at)) }}
                                        </td>

                                        <td>
                                            {{ date("H:i:s",strtotime($work->start_time)) }}
                                        </td>

                                        <td>
                                            @if(is_null($work->stop_time))
                                                --:--:--
                                            @else
                                                {{ date("H:i:s",strtotime($work->stop_time)) }}
                                            @endif
                                        </td>

                                        <td>
                                            {{ $work->billable ? 'پولی' : 'رایگان' }}
                                        </td>

                                        <td>
                                            <form action="/task/{{ $work->id }}/edit/" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button class="btn-outline-dark">ویرایش</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <p> شما تاکنون برای این پروژه زمان کار ثبت نکرده اید!</p>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
