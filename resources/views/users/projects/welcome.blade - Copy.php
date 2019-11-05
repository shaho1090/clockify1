@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-right">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-center ">خوش آمدید</div>


                    <div class="card-body">
                        <div class="panel panel-default">
                            با سلام شما به پروژه {!!$project_title ?? ''!!} دعوت شده اید. <br />اگر عضو نیستید از طریق <a href="http://localhost/clockify1/public/register"> این لینک  </a>ثبت نام کنید و یا وارد <a href="http://localhost/clockify1/public/login"> حساب کاربری  </a>خود شوید.
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
