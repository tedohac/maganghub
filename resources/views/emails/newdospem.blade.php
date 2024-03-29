@component('mail::message')
# Selamat datang di MagangHub!
Admin kampus <b>{{ $param['univ_nama'] }}</b> telah mendaftarkan anda sebagai dosen pembimbing di MagangHub. Berikut identitas anda:<br>
<table>
    <tr>
        <td>Kampus</td>
        <td>: {{ $param['univ_nama'] }}</td>
    </tr>
    <tr>
        <td>Program Studi</td>
        <td>: {{ $param['prodi_nama'] }}</td>
    </tr>
    <tr>
        <td>NIK</td>
        <td>: {{ $param['request']->dospem_nik }}</td>
    </tr>
    <tr>
        <td>Nama Dosen</td>
        <td>: {{ $param['request']->dospem_nama }}</td>
    </tr>
<table><br>
Dan berikut informasi login untuk akun anda:<br><br>
<table>
    <tr>
        <td>e-mail</td>
        <td>: {{ $param['request']->dospem_user_email }}</td>
    </tr>
    <tr>
        <td>Password</td>
        <td>: {{ $param['password'] }}</td>
    </tr>
<table><br>
Untuk mulai menggunakan akun anda, langkah selanjutnya adalah mengaktifkan akun dengan cara klik pada tombol di bawah ini. Kemudian anda dapat langsung login menggunakan informasi di atas.<br>

@component('mail::button', ['url' => $param['url']])
Verifikasi Sekarang
@endcomponent

atau click: <a href="{{ $param['url'] }}">{{ $param['url'] }}</a><br><br>
Terimakasih,<br>
{{ config('app.name') }}
@endcomponent
