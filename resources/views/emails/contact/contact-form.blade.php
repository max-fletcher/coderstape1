@component('mail::message')
Welcome {{ $data['name'] }}

If you got this mail, roll like a good boi !!
If your mail is {{ $data['email'] }} then monch !!
You told me {{ $data['message'] }} lol. Take this milk bone and bepsi...

Thanks,<br>
{{ config('app.name') }}
@endcomponent
