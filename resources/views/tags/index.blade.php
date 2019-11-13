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
                                            <input type="text" name="tag_title" required autocomplete="name" autofocus>
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
                                                <input type="text" class="form-control" name="changeTitle"
                                                       value="{!! $tag->title !!}"
                                                       onchange="updateTagTitle(this.value, {{ $tag->id }})">
                                            </td>

                                            <td>
                                                <form action="/tags/destroy/{{$tag->id}}" method="POST">
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

    <script>
        function updateTagTitle(title, tagId) {
            if (title === "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };

                xmlhttp.open("get", "/tags/update/" + tagId + "/" + title, true);
                xmlhttp.send();

                confirm('Tag Id: ' + tagId + 'newTitle: ' + title);
            }
        }
    </script>
@endsection
