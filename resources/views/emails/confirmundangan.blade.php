@component('mail::message')
# Undangan Test Dikonfirmasi
Undangan test dari anda dikonfirmasi oleh mahasiswa pada lowongan:<br />
{{ $param['rekrut']->lowongan_judul }}
<br /><br />
Dari Mahasiswa:
<table>
    <tr>
        <td width="10%">Kampus</td>
        <td>: {{ $param['rekrut']->univ_nama }}</td>
    </tr>
    <tr>
        <td>Prodi</td>
        <td>: {{ $param['rekrut']->prodi_nama }}</td>
    </tr>
    <tr>
        <td>Mahasiswa</td>
        <td>: {{ $param['rekrut']->mahasiswa_nama }}</td>
    </tr>
</table><br>

@component('mail::button', ['url' => $param['url']])
Lihat Detail Lamaran
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
