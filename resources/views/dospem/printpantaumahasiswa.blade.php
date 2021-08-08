<head>
</head>
<body>
    <table border="0" cellspacing="0" style="width: 100%;">
        <tr>
            <td width="50px">
                <center>
                    <img src="{{ url('storage/univ/'.$dospem->univ_profile_pict) }}" style="width: 50px">
                </center>
            </td>
            <td>
                <h2>
                    <center>Daftar Mahasiswa Bimbingan</center>
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
                <td width="100"><b>DOSPEM</b></td>
                <td>
                    : {{ $dospem->dospem_nama }}
                </td>
            </tr>
            <tr>
                <td width="100"><b>PRODI</b></td>
                <td>
                    : {{ $dospem->prodi_nama }}
                </td>
            </tr>
            <tr>
                <td width="100"><b>Kampus</b></td>
                <td>
                    : {{ $dospem->univ_nama }}
                </td>
            </tr>
        </table>

    </div><br />
    <!-- end info mahasiswa -->
    
    <!-- kegiatan -->
    <div>
        <h3 style="text-align: center;margin-top: 0;">
            Daftar Mahasiswa
        </h3>
        <i>Daftar mahasiswa pada {{ date("Y-m-d H:i:s") }} </i>
        <table border="1" cellspacing="0" style="width: 100%">
            <thead class="greybox">
                <tr>
                    <th>#</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>E-Mail</th>
                    <th><small>Status<br />Magang</small></th>
                </tr>
            </thead>
            <tbody>
            @php ($num = 1)
            @foreach($mahasiswas as $mahasiswa)
                <tr>
                    <td>{{ $num }}</td>
                    <td>{{ $mahasiswa->mahasiswa_nim }}</td>
                    <td>{{ $mahasiswa->mahasiswa_nama }}</td>
                    <td>{{ $mahasiswa->mahasiswa_user_email }}</td>
                    <td>{{ $mahasiswa->mahasiswa_status }}</td>
                </tr>
                @php ($num++)
            @endforeach
            </tbody>
        </table>
    </div>
    <!-- end kegiatan -->

</body>