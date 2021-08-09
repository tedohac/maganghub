<head>
</head>
<body>
    <table border="0" cellspacing="0" style="width: 100%;">
        <tr>
            <td width="50px">
                <center>
                    <img src="{{ url('storage/perusahaan_profile/'.$perusahaan->perusahaan_profile_pict) }}" style="width: 50px">
                </center>
            </td>
            <td>
                <h2>
                    <center>Daftar Lowongan</center>
                </h2>
            </td>
            <td width="50px">
            </td>
        </tr>
    </table>
    <hr />
    
    <!-- info mahasiswa -->
    <div>
        <table border="0" cellspacing="0" style="width: 100%;margin-top:30px;">
            <tr>
                <td width="100"><b>Perusahaan</b></td>
                <td>
                    : {{ $perusahaan->perusahaan_nama }}
                </td>
            </tr>
        </table>

    </div><br />
    <!-- end info mahasiswa -->
    
    <!-- kegiatan -->
    <div>
        <h3 style="text-align: center;margin-top: 0;">
            Daftar Lowongan
        </h3>
        <i>Daftar lowongan pada {{ date("Y-m-d H:i:s") }} </i>
        <table border="1" cellspacing="0" style="width: 100%">
            <thead class="greybox">
                <tr>
                    <th>#</th>
                    <th>Lowongan</th>
                    <th>Fungsi</th>
                    <th>Penempatan</th>
                    <th>Tgl Mulai</th>
                    <th><small>Jlh<br />Dibutuhkan</small></th>
                    <th>Status</th>
                    <th>Pelamar</th>
                </tr>
            </thead>
            <tbody>
            @php ($num = 1)
            @foreach($lowongans as $lowongan)
                <tr>
                    <td>{{ $num }}</td>
                    <td>{{ $lowongan->lowongan_judul }}</td>
                    <td>{{ $lowongan->fungsi_nama }}</td>
                    <td>{{ $lowongan->city_nama }}</td>
                    <td>{{ $lowongan->lowongan_tgl_mulai }}</td>
                    <td>{{ $lowongan->lowongan_jlh_dibutuhkan }}</td>
                    <td>{{ $lowongan->lowongan_status }}</td>
                    <td>
                        {{ $lowongan->total_pelamar }}
                    </td>
                </tr>
                @php ($num++)
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- end kegiatan -->

</body>