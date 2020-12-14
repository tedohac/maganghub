<head>
</head>
<body>
    <!-- begin content -->
    <h2 style="text-align: center;padding: 0 0.5rem;">
        Laporan Kegiatan Magang Mahasiswa
    </h2>
    <!-- info mahasiswa -->
    <div>
        <table border="1" cellspacing="0">
            <tr>
                <td colspan="2"><center>Informasi Mahasiswa Pelamar<center></td>
                <td></td>
                <td colspan="2"><center>Informasi Pekerjaan<center></td>
            </tr>
            <tr>
                <td><b>Kampus</b></td>
                <td>
                    {{ $rekrut->univ_nama }}
                </td>
                <td></td>
                <td><b>Perusahaan</b></td>
                <td>
                    {{ $rekrut->perusahaan_nama }}
                </td>
            </tr>
            <tr>
                <td><b>NIM</b></td>
                <td>
                    {{ $rekrut->mahasiswa_nim }}
                </td>
                <td></td>
                <td><b>Judul Lowongan</b></td>
                <td>
                    {{ $rekrut->lowongan_judul }}
                </td>
            </tr>
            <tr>
                <td><b>Mahasiswa</b></td>
                <td>
                    {{ $rekrut->mahasiswa_nama }}
                </td>
                <td></td>
                <td><b>Fungsi</b></td>
                <td>
                    {{ $rekrut->fungsi_nama }}
                </td>
            </tr>
            <tr>
                <td><b>TTL</b></td>
                <td>
                    {{ $rekrut->mahasiswa_tempat_lahir ? $rekrut->mahasiswa_tempat_lahir : '-' }}, {{ $rekrut->mahasiswa_tgl_lahir ? $rekrut->mahasiswa_tgl_lahir : '-' }}
                </td>
                <td></td>
                <td><b>Kota Penempatan</b></td>
                <td>
                    {{ $rekrut->city_nama }}
                </td>
            </tr>
            <tr>
                <td><b>Telepon</b></td>
                <td>
                    {{ $rekrut->mahasiswa_no_tlp ? $rekrut->mahasiswa_no_tlp : '-' }}
                </td>
                <td></td>
                <td><b>Mulai Magang</b></td>
                <td>
                    {{ date('d F Y', strtotime($rekrut->lowongan_tgl_mulai)) }}
                </td>
            </tr>
            <tr>
                <td><b>Domisili</b></td>
                <td>
                    {{ $rekrut->city_nama ? $rekrut->city_nama : '-' }}
                </td>
                <td></td>
                <td><b>Durasi</b></td>
                <td>
                    {{ $rekrut->lowongan_durasi }}
                </td>
            </tr>
            <tr>
                <td><b>Alamat</b></td>
                <td>
                    {{ $rekrut->mahasiswa_alamat ? $rekrut->mahasiswa_alamat : '-' }}
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="greybox"><b>Skills</b></td>
                <td>
                    @foreach($skills as $skill)
                        {{ $skill->skill_nama }},
                    @endforeach
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

    </div>
    <!-- end info mahasiswa -->
        
    <!-- kegiatan -->
    <div>
        <h3 style="text-align: center;padding: 0 0.5rem;">
            Daftar Kegiatan
        </h3>
        <table border="1" cellspacing="0" style="width: 100%">
            <thead class="greybox">
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Pekerjaan</th>
                    <th>Diverifikasi</th>
                </tr>
            </thead>
            <tbody>
            @php ($num = 1)
            @foreach($kegiatans as $kegiatan)
                <tr>
                    <td>{{ $num }}</td>
                    <td>{{ $kegiatan->kegiatan_tgl }}</td>
                    <td>{!! htmlspecialchars_decode($kegiatan->kegiatan_desc) !!}</td>
                    <td>{{ date('d F Y', strtotime($kegiatan->kegiatan_verify_mentor)) }}</td>
                </tr>
                @php ($num++)
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- end kegiatan -->

</body>