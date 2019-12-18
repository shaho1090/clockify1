@component('mail::message')
# Introduction

با سلام از شما برای مشارکت در چند پروژه دعوت شده است.
برای قبول همکاری در این پروژه ها روی دکمه زیر کلیک کنید.
{{$workSpaceId}}
{{$email}}
@component('mail::button',
    ['url' => 'http://localhost/clockify1/public/accept/invitation/'.$workSpaceId//.'/'.$email.'/',
   //  'email' => $email,
  //   'workSpaceId' => $workSpaceId
  ])
    @csrf
قبول همکاری
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
