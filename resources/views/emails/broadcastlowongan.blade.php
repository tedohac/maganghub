@component('mail::message')
# Tawaran Lowongan Magang
{{ $param['lowongan']->perusahaan_nama }} menawarkan anda lowongan magang dengan deskripsi sebagai berikut:
<table>
    <tr>
        <td>Lowongan</td>
        <td>: {{ $param['lowongan']->lowongan_judul }}</td>
    </tr>
    <tr>
        <td>Fungsi</td>
        <td>: {{ $param['lowongan']->fungsi_nama }}</td>
    </tr>
    <tr>
        <td>Penempatan</td>
        <td>: {{ $param['lowongan']->city_nama }}</td>
    </tr>
    <tr>
        <td>Mulai Magang</td>
        <td>: {{ date('d M Y', strtotime($param['lowongan']->lowongan_tgl_mulai)) }}</td>
    </tr>
    <tr>
        <td>Durasi Magang</td>
        <td>: {{ $param['lowongan']->lowongan_durasi }}</td>
    </tr>
<table><br>

Syarat lowongan:<br />
{!!html_entity_decode($param['lowongan']->lowongan_requirement)!!}<br /><br />

Job Desk:<br />
{!!html_entity_decode($param['lowongan']->lowongan_jobdesk)!!}<br /><br />

Jika anda tertarik dengan lowongan ini, silahkan ajukan lamaran melalui tombol berikut:

@component('mail::button', ['url' => $param['url']])
Lamar Lowongan
@endcomponent

atau click: <a href="{{ $param['url'] }}">{{ $param['url'] }}</a><br><br>

Semoga sukses!<br>
Terimakasih,<br>
{{ config('app.name') }}
@endcomponent
