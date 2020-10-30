@component('mail::message')
# Reset Password Akun MagangHub
Anda akan melalukan perubahan password pada akun dengan email {{ $param['email'] }}<br>
Silahkan klik pada tautan di bawah ini untuk melakukan perubahan password pada akun MagangHub anda.

@component('mail::button', ['url' => $param['url']])
Reset Password Sekarang
@endcomponent

atau click: <a href="{{ $param['url'] }}">{{ $param['url'] }}</a><br><br>
Terimakasih,<br>
{{ config('app.name') }}
@endcomponent

