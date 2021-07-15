@component('mail::message')
# Undangan Test Magang
{{ $param['rekrut']->perusahaan_nama }} mengundang anda untuk test pada:
<table>
    <tr>
        <td width="10%">Tanggal</td>
        <td>: {{ date('d M Y', strtotime($param['request']->undangan_tanggal)) }}</td>
    </tr>
    <tr>
        <td>Waktu</td>
        <td>: {{ date('H:i', strtotime($param['request']->undangan_waktu)) }}</td>
    </tr>
    <tr>
        <td>Tempat</td>
        <td>: {{ $param['request']->undangan_alamat }}</td>
    </tr>
</table><br>

Undangan ini dikirim atas lowongan:
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

Beberapa hal yang perlu diperhatikan:<br />
{!!html_entity_decode($request->undangan_desc)!!}<br /><br />

Mohon segera konfirmasi undangan test ini pada halaman berikut:

@component('mail::button', ['url' => $param['url']])
Detail Undangan
@endcomponent

atau click: <a href="{{ $param['url'] }}">{{ $param['url'] }}</a><br><br>

Semoga sukses!<br>
Terimakasih,<br>
{{ config('app.name') }}
@endcomponent
