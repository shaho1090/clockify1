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
                                        <form action="{{route('projects.store')}}" method="post">
                                            @csrf
                                            <input type="text" name="project_title" required autocomplete="name"
                                                   autofocus>
                                            <button type="submit" class="btn">ثبت</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-heading">
                                <p></p>
                                <h3> لیست پروژه های شما </h3>
                            </div>
                            @if (is_null($projects))
                                <p> هنوز هیچ پروژه ای توسط شما ایجاد نشده است.</p>
                            @else
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>عنوان پروژه</th>
                                        <th>حذف پروژه</th>
                                        <th>مشاهده انجام کار</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($projects as $project)
                                        <tr>
                                            <td>
                                                <form action="{{route('projects.update',$project->id)}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" class="form-control" name="title"
                                                           value="{{ $project->title }}"
                                                           onchange="updateProjectTitle(this.value, {{ $project->id }})">
                                                </form>
                                            </td>

                                            <td>
                                                <form action="/projects/destroy/{{$project->id}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger">حذف این پروژه</button>
                                                </form>
                                            </td>

                                            <td>
                                                <button class="btn btn-outline-dark"><a
                                                        href="/works/index/{{$project->id}}">مشاهده زمان های کاری</a>
                                                </button>
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
    <script src="{{ asset('js/myFunctions.js') }}"></script>
@endsection
