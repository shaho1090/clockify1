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
                    <div class="card-header">لیست محیط های کاری</div>
                    <div class="card-body">
                        <div class="panel panel-default">
                            <div id="accordion">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                        ایجاد محیط کاری جدید
                                    </a>
                                </div>
                                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <form action="{{route('work-spaces.store')}}" method="post">
                                            @csrf
                                            <input type="text" name="title" required autocomplete="name"
                                                   autofocus>
                                            <button type="submit" class="btn">ثبت</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-heading">
                                <p></p>
                                <h3> لیست محیط های کاری شما </h3>
                            </div>
                            @if (is_null($workSpaces))
                                <p> هنوز هیچ پروژه ای توسط شما ایجاد نشده است.</p>
                            @else
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>عنوان محیط کاری</th>
                                        <th>مشاهده انجام کار</th>
                                        <th>حذف محیط کاری</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($workSpaces as $workSpace)
                                        <tr>
                                            <td>
                                                <form action="{{route('work-spaces.update',$workSpace->id)}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" class="form-control" name="title"
                                                           value="{{ $workSpace->title }}"
                                                           onchange="updateWorkSpaceTitle(this.value, {{ $workSpace->id }})">
                                                </form>
                                            </td>

                                            <td>
                                                <button class="btn btn-outline-dark"><a
                                                        href="/works/index/{{$workSpace->id}}">مشاهده زمان های کاری</a>
                                                </button>
                                            </td>

                                            <td>
                                                <form action="/projects/destroy/{{$workSpace->id}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger">حذف این محیط کاری</button>
                                                </form>
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
