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
                    <div class="card-header">لیست زمان های کاری شما </div>
                    <div class="card-body">
                        <div class="panel panel-default">
                            <div class="panel-heading">ثبت زمان کار جدید</div>
                            <form method="post" action="/work-time/start">
                                @csrf
                                <table class="table" >
                                    <thead>
                                    <tr>
                                        <th>تاریخ امروز</th>
                                        <th>ثبت ساعت</th>
                                        <th>ساعت شروع</th>
                                        <th>ساعت پایان</th>
                                        <th>تعیین عنوان برای کار</th>
                                        <th>مربوط به پروژه :</th>
                                        <th>تعیین نوع کار</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                      <tr>
                                        <td>
                                            {{ date("Y-m-d") }}
                                        </td>

                                        <td>
                                            @if (! $incompleteWorkTime)
                                                <button class="btn btn-outline-dark" type="submit" name="start" formaction="/work-time/start">
                                                    شروع
                                                </button>
                                            @else
                                               <button class="btn btn-outline-dark" type="submit" name="stop" formaction="/work-time/stop">
                                                    پایان
                                               </button>
                                            @endif
                                        </td>

                                        <td>
                                             {{ $incompleteWorkTime ? date("H:i:s",strtotime($incompleteWorkTime->start_time)) :'--:--:--'}}
                                        </td>

                                        <td>
                                            {{ $incompleteWorkTime ? date("H:i:s",strtotime($incompleteWorkTime->stop_time)) :'--:--:--'}}
                                        </td>

                                        <td>
                                            <input typeof="text" class="form-control" name="title" placeholder="عنوان کار">
                                        </td>
                                          <td>
                                              <select id="source"  class="form-control"  size="1" name="project_id" >
                                                  <option value="" disabled selected>انتخاب پروژه</option>
                                                  @foreach($projects as $project)
                                                      <option value="{!! $project->id !!} ">
                                                          {!! $project->title !!}
                                                      </option>
                                                  @endforeach
                                              </select>
                                          </td>
                                        <td>
                                            <select name="selectBillable" class="form-control">
                                                <option value="1" >
                                                    پولی
                                                </option>
                                                <option value="0">
                                                    رایگان
                                                </option>
                                            </select>
                                        </td>
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
                                    <th>عنوان کار</th>
                                    <th>تاریخ</th>
                                    <th>ساعت شروع</th>
                                    <th>ساعت پایان</th>
                                    <th>مربوط به پروژه :</th>
                                    <th>نوع کار</th>
                                    <th></th>
                                </tr>
                                </thead>

                                <tbody>
                                @forelse ($workTimes as $workTime)
                                    <tr>
                                        <td>{{ $workTime->title }}</td>

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
                                            {{ $workTime->billable ? 'پولی' : 'رایگان' }}
                                        </td>

                                        <td>
                                            <form action="/work-time/{{ $workTime->id }}/edit/" method="POST">
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
