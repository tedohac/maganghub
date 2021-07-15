@component('mail::message')
# Lamaran Magang Baru
Anda mendapatkan lamaran magang baru atas lowongan:<br />
{{ $param['lowongan']->lowongan_judul }}
<br /><br />
Dari Mahasiswa:
<table>
    <tr>
        <td width="50">Kampus</td>
        <td>: {{ $param['mahasiswa']->univ_nama }}</td>
    </tr>
    <tr>
        <td>Prodi</td>
        <td>: {{ $param['mahasiswa']->prodi_nama }}</td>
    </tr>
    <tr>
        <td>Mahasiswa</td>
        <td>: {{ $param['mahasiswa']->mahasiswa_nama }}</td>
    </tr>
<table><br>

@component('mail::button', ['url' => $param['url']])
Lihat Detail Lamaran
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
