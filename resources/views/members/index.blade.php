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
                    <div class="card-header">لیست اعضای محیط کاری</div>
                    <div class="card-body">
                        <div class="panel panel-default">
                            <div id="accordion">
                                <div class="card-header">
                                    <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                      اضافه کردن عضو جدید به این محیط کاری
                                    </a>
                                </div>
                                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <form action="/invite/members/store" method="post">
                                            @csrf
                                            <input type="text" name="tag_title">
                                            <button type="submit" class="btn" >ارسال ایمیل</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-heading">
                                <h3>  </h3>
                            </div>
                            @if (is_null($members))
                                <p> هنوز هیچ کس به این فضای کاری دعوت نشده است.</p>
                            @else
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>نام </th>
                                        <th>ایمیل</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($members as $member)
                                        <tr>
                                            <td>
                                               {{$member->name}}
                                            </td>
                                            <td>
                                               {{$member->email}}
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-dark"><a href="/works/index/{{$member->id}}">مشاهده زمان های کاری</a></button>
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
