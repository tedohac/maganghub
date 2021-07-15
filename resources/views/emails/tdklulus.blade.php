@component('mail::message')
# Tidak Lulus Test
Mohon maaf, anda tidak lulus test pada lowongan:<br />
{{ $param['rekrut']->lowongan_judul }}
<br /><br />

@component('mail::button', ['url' => $param['url']])
Lihat Detail Lamaran
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
