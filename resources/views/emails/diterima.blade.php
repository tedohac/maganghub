@component('mail::message')
# Selamat! Anda Diterima Magang
{{ $param['rekrut']->perusahaan_nama }} telah menyatakan bahwa anda lolos test untuk magang pada lowongan berikut:
<table>
    <tr>
        <td width="10%">Lowongan</td>
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
</table><br>

Selamat melaksanakan magang! Semoga sukses!

Semoga sukses!<br>
Terimakasih,<br>
{{ config('app.name') }}
@endcomponent
