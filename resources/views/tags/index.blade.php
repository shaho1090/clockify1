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
                                        <form action="/tags/store" method="post">
                                            @csrf
                                            <input type="text" name="tag_title">
                                            <button type="submit" class="btn" >ثبت</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-heading">
                                <h3>  </h3>
                            </div>
                            @if (is_null($tags))
                                <p> هنوز هیچ تگی در این فضای کاری ایجاد نشده است.</p>
                            @else
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>عنوان تگ</th>
                                        <th>مشاهده انجام کار</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tags as $tag)
                                        <tr>
                                            <td>
                                                <a href="show/{{$tag->id}}">{!! $tag->title !!} </a>
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-dark"><a href="/works/index/{{$tag->id}}">مشاهده زمان های کاری</a></button>
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
