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
                    <div class="card-header">انجام کارهای آقای {{ $member->name }}</div>
                    <div class="card-body">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3></h3>
                            </div>
                            @if (is_null($workTimes))
                                <p> انجام کاری توسط این عضو هنوز ثبت نشده است</p>
                            @else
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>عنوان کار</th>
                                        <th>تاریخ</th>
                                        <th>ساعت شروع</th>
                                        <th>ساعت پایان</th>
                                        <th>مربوط به پروژه :</th>
                                        <th>تگ ها</th>
                                        <th>نوع کار</th>
                                        <th></th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @forelse ($workTimes as $workTime)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control" name="changeTitle"
                                                       value="{{ $workTime->title }}">
                                            </td>

                                            <td>
                                                {{ date("Y-m-d",strtotime($workTime->created_at)) }}
                                            </td>

                                            <td>
                                                {{ date("H:i:s",strtotime($workTime->start_time)) }}
                                            </td>

                                            <td>
                                                @if(is_null($workTime->stop_time))
                                                    --:--:--
                                                @else
                                                    {{ date("H:i:s",strtotime($workTime->stop_time)) }}
                                                @endif
                                            </td>

                                            <td>
                                                @if ($workTime->project)
                                                    {{ $workTime->project->title }}
                                                @endif
                                            </td>

                                            <td>
                                                <fieldset>
                                                    @if ($workTime->tags)
                                                        @foreach($workTime->tags as $workTimeTag)
                                                            | {{ $workTimeTag->title }}
                                                        @endforeach
                                                    @endif
                                                </fieldset>
                                            </td>

                                            <td>
                                                {{ $workTime->billable ? 'پولی' : 'رایگان' }}
                                            </td>

                                            <td>

                                            </td>
                                        </tr>
                                    @empty
                                        <p>  تاکنون زمان کار ثبت نشده!</p>
                                    @endforelse
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
