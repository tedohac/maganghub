<head>
</head>
<body>
    <table border="0" cellspacing="0" style="width: 100%;">
        <tr>
            <td width="50px">
                <center>
                    <img src="{{ url('storage/univ/'.$rekrut->univ_profile_pict) }}" style="width: 50px">
                </center>
            </td>
            <td>
                <h2>
                    <center>Detail Rekruitment</center>
                </h2>
            </td>
            <td width="50px">
                <center>
                    <img src="{{ url('storage/perusahaan_profile/'.$rekrut->perusahaan_profile_pict) }}" style="width: 50px">
                </center>
            </td>
        </tr>
    </table>
    <hr />
    
    <!-- Status Lamaran -->
    <div>
        <table border="1" cellspacing="0" style="width: 100%;margin-top:30px;">
            <tr>
                <td colspan="2"><b>Status Lamaran</b></td>
            </tr>
            <tr>
                <td width="150px"><b>Melamar</b></td>
                <td>
                    {{ ($rekrut->rekrut_waktu_melamar) ? date('d M Y H:i', strtotime($rekrut->rekrut_waktu_melamar)) : "" }}
                </td>
            </tr>
            <tr>
                <td><b>Undangan Test</b></td>
                <td>
                    {{ ($rekrut->rekrut_waktu_diundang) ? date('d M Y H:i', strtotime($rekrut->rekrut_waktu_diundang)) : "" }}
                </td>
            </tr>
            <tr>
                <td><b>Konfirmasi Test</b></td>
                <td>
                    {{ ($rekrut->rekrut_waktu_konfirmundangan) ? date('d M Y H:i', strtotime($rekrut->rekrut_waktu_konfirmundangan)) : "" }}
                </td>
            </tr>
            <tr>
                <td><b>Diterima</b></td>
                <td>
                    {{ ($rekrut->rekrut_waktu_diterima) ? date('d M Y H:i', strtotime($rekrut->rekrut_waktu_diterima)) : "" }}
                </td>
            </tr>
        </table>

    </div>
    <!-- end Status Lamaran -->

    <!-- info mahasiswa -->
    <div>
        <table border="0" cellspacing="0" style="width: 100%;margin-top:30px;">
            <tr>
                <td colspan="2"><u>Informasi Mahasiswa Pelamar</u></td>
            </tr>
            <tr>
                <td width="50px"><b>Kampus</b></td>
                <td>
                    : {{ $rekrut->univ_nama }}
                </td>
            </tr>
            <tr>
                <td><b>Prodi</b></td>
                <td>
                    : {{ $rekrut->prodi_nama }}
                </td>
            </tr>
            <tr>
                <td><b>NIM</b></td>
                <td>
                    : {{ $rekrut->mahasiswa_nim }}
                </td>
            </tr>
            <tr>
                <td><b>Mahasiswa</b></td>
                <td>
                    : {{ $rekrut->mahasiswa_nama }}
                </td>
            </tr>
            <tr>
                <td><b>TTL</b></td>
                <td>
                    : {{ $rekrut->mahasiswa_tempat_lahir ? $rekrut->mahasiswa_tempat_lahir : '-' }}, {{ $rekrut->mahasiswa_tgl_lahir ? $rekrut->mahasiswa_tgl_lahir : '-' }}
                </td>
            </tr>
            <tr>
                <td><b>Telepon</b></td>
                <td>
                    : {{ $rekrut->mahasiswa_no_tlp ? $rekrut->mahasiswa_no_tlp : '-' }}
                </td>
            </tr>
            <tr>
                <td><b>Domisili</b></td>
                <td>
                    : {{ $rekrut->city_nama ? $rekrut->city_nama : '-' }}
                </td>
            </tr>
            <tr>
                <td><b>Alamat</b></td>
                <td>
                    : {{ $rekrut->mahasiswa_alamat ? $rekrut->mahasiswa_alamat : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Skills</b></td>
                <td>
                    : @foreach($skills as $skill)
                        {{ $skill->skill_nama }},
                    @endforeach
                </td>
            </tr>
        </table>

    </div>
    <!-- end info mahasiswa -->
    
    <!-- info Lowongan -->
    <div>
        <table border="0" cellspacing="0" style="width: 100%;margin-top:30px;">
            <tr>
                <td colspan="2"><u>Informasi Lowongan</u></td>
            </tr>
            <tr>
                <td width="130px"><b>Perusahaan</b></td>
                <td>
                    : {{ $rekrut->perusahaan_nama }}
                </td>
            </tr>
            <tr>
                <td><b>Judul Lowongan</b></td>
                <td>
                    : {{ $rekrut->lowongan_judul }}
                </td>
            </tr>
            <tr>
                <td><b>Fungsi</b></td>
                <td>
                    : {{ $rekrut->fungsi_nama }}
                </td>
            </tr>
            <tr>
                <td><b>Kota Penempatan</b></td>
                <td>
                    : {{ $rekrut->city_nama }}
                </td>
            </tr>
            <tr>
                <td><b>Mulai Magang</b></td>
                <td>
                    : {{ date('d F Y', strtotime($rekrut->lowongan_tgl_mulai)) }}
                </td>
            </tr>
            <tr>
                <td><b>Durasi</b></td>
                <td>
                    : {{ $rekrut->lowongan_durasi }}
                </td>
            </tr>
        </table>
        <br />
        <h3 style="margin-top: 0;">
            <u>Syarat</u>
        </h3>
        {!! $rekrut->lowongan_requirement !!}
        <br />
        <h3 style="margin-top: 0;">
            <u>Job Desk</u>
        </h3>
        {!! $rekrut->lowongan_jobdesk !!}
    </div>
    <!-- end info Lowongan -->

</body>