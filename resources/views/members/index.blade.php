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
                                        دعوت به همکاری در این محیط کاری
                                    </a>
                                </div>
                                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="col-md-6">
                                            <form action="{{ route('invitees.store') }}" method="post">
                                                @csrf
                                                <input type="email" id="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       name="email" value="{{ old('آدرس ایمیل') }}" required
                                                       autocomplete="email">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                              <strong>{{ $message }}</strong>
                                              </span>
                                                @enderror
                                                <p></p>
                                                <button type="submit" class="btn">اضافه کردن به لیست دعوت شده ها
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-heading">
                                <h3></h3>
                            </div>
                            @if (is_null($members))
                                <p> هنوز هیچ کس به این فضای کاری دعوت نشده است.</p>
                            @else
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>نام</th>
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
                                                <button class="btn btn-outline-dark"><a
                                                        href="/works/index/{{$member->id}}">مشاهده زمان های کاری</a>
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
                <div class="card">
                    <div class="card-header">لیست ایمیل های دعوت شده</div>
                    <div class="card-body">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3></h3>
                            </div>
                            @if (is_null($invitees))
                                <p> هنوز هیچ کس به این فضای کاری دعوت نشده است.</p>
                            @else
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>ایمیل</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($invitees as $invitee)
                                        <tr>
                                            <td>
                                                {{$invitee->email}}
                                            </td>

                                            <td>
                                                <form method="post"
                                                      action="{{ route('invitees.destroy',$invitee->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">لغو دعوت نامه
                                                    </button>
                                                </form>
                                            </td>

                                            <td>
                                                <form method="post"
                                                      action="{{ route('send.mail',$invitee->id) }}">
                                                    @csrf
                                                    <button type="submit" class="btn btn-outline-danger">ارسال دعوت نامه
                                                    </button>
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
@endsection
