@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-right">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center bg-dark text-white">خوش آمدید</div>


                    <div class="card-body">
                        <div class="panel panel-default">
                            shoma be {!! $name ?? '' !!} davat shode ied
                        </div>
                        <div id="accordion">
                            <div class="card-header">
                                <a class="collapsed card-link" data-toggle="collapse" href="#collapseTwo">
                                    اضافه کردن پروژه جدید
                                </a>
                            </div>

                            <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                <div class="card-body">
                                    <form action="/projects/add" method="post">

                                        <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                        <input type="text" name="project_title">
                                        <button type="submit" class="btn" >ثبت</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
