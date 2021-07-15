@component('mail::message')
# Lamaran Magang Ditolak
Mohon maaf, perusahaan <b>{{ $param['rekrut']->perusahaan_nama }}</b> menolak lamaran anda atas lowongan:<br />
{{ $param['rekrut']->lowongan_judul }}
<br /><br />

@component('mail::button', ['url' => $param['url']])
Lihat Detail Lamaran
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
