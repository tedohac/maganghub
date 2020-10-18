@component('mail::message')
# Selamat datang di MagangHub!
Terimakasih telah mendaftar sebagai {{ $param['role'] }} di MagangHub. Mohon lakukan verifikasi e-mail dengan cara klik pada tautan di bawah ini untuk dapat mulai menggunakan MagangHub.

@component('mail::button', ['url' => $param['url']])
Verifikasi Sekarang
@endcomponent
or click: <a href="{{ $param['url'] }}">{{ $param['url'] }}</a><br><br>
Terimakasih,<br>
{{ config('app.name') }}
@endcomponent
