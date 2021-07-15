@component('mail::message')
# Lamaran Magang Batal Ditolak
Perusahaan <b>{{ $param['rekrut']->perusahaan_nama }}</b> membatalkan atas penolakan lamaran anda pada lowongan:<br />
{{ $param['rekrut']->lowongan_judul }}
<br /><br />
Semoga beruntung!
<br />
@component('mail::button', ['url' => $param['url']])
Lihat Detail Lamaran
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
