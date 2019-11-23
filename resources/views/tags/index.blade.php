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
                    <div class="card-header">لیست تگ ها</div>
                    <div class="card-body">
                        <div class="panel panel-default">
                            <div id="accordion">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                        اضافه کردن تگ جدید
                                    </a>
                                </div>
                                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <form action="{{route('tags.store')}}" method="post">
                                            @csrf
                                            <input type="text" name="title" required autocomplete="name" autofocus>
                                            <button type="submit" class="btn">ثبت</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <p></p>
                            <div class="panel-heading">
                                <h4>لیست تگ ها</h4>
                            </div>
                            @if ($tags)
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>عنوان تگ</th>
                                        <th>حذف تگ</th>
                                        <th>مشاهده انجام کار</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tags as $tag)
                                        <tr>
                                            <td>
                                                <form action="{{route('tags.update',$tag->id)}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" class="form-control" name="title"
                                                           value="{{ $tag->title }}"
                                                           onchange="updateTagTitle(this.value, {{ $tag->id }})">
                                                </form>
                                            </td>


                                            <td>
                                                <form action="{{route('tags.destroy',$tag->id)}}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-outline-danger">حذف این تگ</button>
                                                </form>
                                            </td>

                                            <td>
                                                <button class="btn btn-outline-dark"><a
                                                        href="/works/index/{{$tag->id}}">مشاهده زمان های کاری</a>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p> هنوز هیچ تگی در این فضای کاری ایجاد نشده است.</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/myFunctions.js') }}"></script>
@endsection

