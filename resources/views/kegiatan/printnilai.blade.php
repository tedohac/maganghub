<head>
</head>
<body>
    <table border="0" cellspacing="0" style="width: 100%;">
        <tr>
            <td>
                <center>
                    <img src="{{ url('storage/univ/'.$rekrut->univ_profile_pict) }}" style="width: 50px">
                </center>
            </td>
            <td>
                <h2>
                    <center>Laporan Nilai Magang Mahasiswa</center>
                </h2>
            </td>
            <td>
                <center>
                    <img src="{{ url('storage/perusahaan_profile/'.$rekrut->perusahaan_profile_pict) }}" style="width: 50px">
                </center>
            </td>
        </tr>
    </table>
    <hr />
    
    <!-- info mahasiswa -->
    <div>
        <table border="0" cellspacing="0" style="width: 100%;margin-top:30px;">
            <tr>
                <td colspan="2"><center><u>Informasi Mahasiswa Pelamar</u><center></td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
                <td colspan="2"><center><u>Informasi Pekerjaan</u><center></td>
            </tr>
            <tr>
                <td><b>Kampus</b></td>
                <td>
                    : {{ $rekrut->univ_nama }}
                </td>
                <td></td>
                <td><b>Perusahaan</b></td>
                <td>
                    : {{ $rekrut->perusahaan_nama }}
                </td>
            </tr>
            <tr>
                <td><b>NIM</b></td>
                <td>
                    : {{ $rekrut->mahasiswa_nim }}
                </td>
                <td></td>
                <td><b>Judul Lowongan</b></td>
                <td>
                    : {{ $rekrut->lowongan_judul }}
                </td>
            </tr>
            <tr>
                <td><b>Mahasiswa</b></td>
                <td>
                    : {{ $rekrut->mahasiswa_nama }}
                </td>
                <td></td>
                <td><b>Fungsi</b></td>
                <td>
                    : {{ $rekrut->fungsi_nama }}
                </td>
            </tr>
            <tr>
                <td><b>TTL</b></td>
                <td>
                    : {{ $rekrut->mahasiswa_tempat_lahir ? $rekrut->mahasiswa_tempat_lahir : '-' }}, {{ $rekrut->mahasiswa_tgl_lahir ? $rekrut->mahasiswa_tgl_lahir : '-' }}
                </td>
                <td></td>
                <td><b>Kota Penempatan</b></td>
                <td>
                    : {{ $rekrut->city_nama }}
                </td>
            </tr>
            <tr>
                <td><b>Telepon</b></td>
                <td>
                    : {{ $rekrut->mahasiswa_no_tlp ? $rekrut->mahasiswa_no_tlp : '-' }}
                </td>
                <td></td>
                <td><b>Mulai Magang</b></td>
                <td>
                    : {{ date('d F Y', strtotime($rekrut->lowongan_tgl_mulai)) }}
                </td>
            </tr>
            <tr>
                <td><b>Domisili</b></td>
                <td>
                    : {{ $rekrut->city_nama ? $rekrut->city_nama : '-' }}
                </td>
                <td></td>
                <td><b>Durasi</b></td>
                <td>
                    : {{ $rekrut->lowongan_durasi }}
                </td>
            </tr>
            <tr>
                <td><b>Alamat</b></td>
                <td>
                    : {{ $rekrut->mahasiswa_alamat ? $rekrut->mahasiswa_alamat : '-' }}
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td class="greybox"><b>Skills</b></td>
                <td>
                    : @foreach($skills as $skill)
                        {{ $skill->skill_nama }},
                    @endforeach
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>

    </div><br />
    <!-- end info mahasiswa -->
    
    <!-- penilaian -->
    
    <div>
        <table border="1" cellspacing="0" style="width: 100%">
            <thead class="greybox">
                <tr>
                    <td colspan="3">
                        Magang diselesaikan pada {{ date('d F Y', strtotime($rekrut->rekrut_finish)) }}.<br />
                    </td>
                </tr>
            </thead>
        </table>
    </div>
    <!-- end penilaian -->

    <!-- QR -->
    <div>
        <table border="0" cellspacing="0" style="width: 100%;margin-top:10px;">
            <tr>
                <td width="70">
                    <img src="data:image/png;base64, {!! $qrcode !!}" width="90">
                </td>
                <td valign="top">
                    Scan QR disamping untuk melihat laporan lebih lengkap, atau pada URL:<br />
                    {{ $public_url }}
                </td>
            </tr>
        </table>

    </div><br />
    <!-- end QR -->
    
    <!-- nilai -->
    <div>
        <h3 style="text-align: center;margin-top: 0;">
            Penilaian
        </h3>
        <table border="1" cellspacing="0" style="width: 100%">
            <thead class="greybox">
                <tr>
                    <th width="10">No</th>
                    <th>Komponen</th>
                    <th>Nilai</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Aspek Kedisiplinan</td>
                    <td>{{ $rekrut->rekrut_aspek_kedisiplinan }}</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Aspek Keterampilan</td>
                    <td>{{ $rekrut->rekrut_aspek_keterampilan }}</td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Aspek Sikap/Perilaku</td>
                    <td>{{ $rekrut->rekrut_aspek_sikap }}</td>
                </tr>
                <tr>
                    <td colspan="2">Rata-rata</td>
                    <td>{{ round(($rekrut->rekrut_aspek_kedisiplinan + $rekrut->rekrut_aspek_keterampilan + $rekrut->rekrut_aspek_sikap)/3, 2) }}</td>
                </tr>
            </tbody>
        </table><br />
        
        <b>Feedback dari perusahaan:</b><br />
        {{ $rekrut->rekrut_feedback }}
    </div>
    <!-- end kegiatan -->

</body>