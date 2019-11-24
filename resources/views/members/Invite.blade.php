@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => 'http://localhost/clockify1/public/get/back'])
    @csrf
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
