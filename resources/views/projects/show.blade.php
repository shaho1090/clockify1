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
                    <div class="card-header">ویرایش پروژه</div>
                    <div class="card-body">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4></h4>
                            </div>
                            <form action="{{route('user_project_update')}}" method="post">
                                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>عنوان پروژه : {!! $project->title !!}</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>

                                   </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>عنوان جدید را برای پروژه اینجا وارد کنید :<input type="text" name="project_title"> </td>
                                        <td><button type="submit" name="user_project_update" class="btn btn-outline-danger" >ثبت تغییرات</button></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <input type="hidden" name="project_id" value="{!! $project->id !!}">
                              </form>
                        </div>

                        <div id="accordion">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseOne">
                                  حذف این پروژه
                                </a>
                            </div>

                            <div id="collapseOne" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                  <form method="get" action="user/project/destroy/{{$project}}">
                                       <button type="submit" name="destroy" class="btn btn-outline-danger ">حذف این پروژه </button>
                                      <input type="hidden" name="project_id" value="{!! $project->id !!}">
                                  </form>
                                 </div>
                            </div>
                        </div>

                        <div id="accordion">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                   نمایش افراد مشارکت کننده در این پروژه
                                </a>
                            </div>

                            <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    @if (is_null($contributors))
                                        <p> هیچ کس در این پروژه مشارکت نکرده است.</p>
                                    @else
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>نام </th>
                                                <th>آدرس ایمیل</th>
                                                <th>نقش</th>
                                                <th>مشاهده انجام کار</th>

                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($contributors as $contributor)
                                                <tr>
                                                    <td>{!! $contributor->name !!}</td>
                                                    <td>{!! $contributor->email !!}</td>
                                                    <td>@if ($contributor->pivot->access == 0 )
                                                            {{ 'owner' }}
                                                        @elseif ($contributor->pivot->access == 1)
                                                            {{ 'admin' }}
                                                        @else
                                                            {{'user'}}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-outline-dark"><a href="{!! action('WorksController@index', $project->id) !!}">مشاهده زمان های کاری</a></button>
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
        </div>
    </div>
@endsection
