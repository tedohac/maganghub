@component('mail::message')
# Selamat! Anda Diterima Magang
{{ $param['rekrut']->perusahaan_nama }} telah menyatakan bahwa anda lolos test untuk magang pada lowongan berikut:
<table>
    <tr>
        <td>Lowongan</td>
        <td>: {{ $param['rekrut']->lowongan_judul }}</td>
    </tr>
    <tr>
        <td>Perusahaan</td>
        <td>: {{ $param['rekrut']->perusahaan_nama }}</td>
    </tr>
    <tr>
        <td>Fungsi</td>
        <td>: {{ $param['rekrut']->fungsi_nama }}</td>
    </tr>
    <tr>
        <td>Penempatan</td>
        <td>: {{ $param['rekrut']->city_nama }}</td>
    </tr>
<table><br>

Mohon segera konfirmasi untuk dapat mulai magang pada halaman berikut:

@component('mail::button', ['url' => $param['url']])
Detail Undangan
@endcomponent

atau click: <a href="{{ $param['url'] }}">{{ $param['url'] }}</a><br><br>

Semoga sukses!<br>
Terimakasih,<br>
{{ config('app.name') }}
@endcomponent
