@extends('layouts.app')
@section('sidebar')
    @include('layouts.sidebar')
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-right">
        <div class="col-lg">
            <div class="card">
                <div class="card-header">داشبورد</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    به صفحه اکانت خود خوش آمدید!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

