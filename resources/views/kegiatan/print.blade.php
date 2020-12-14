<head>
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

    <!-- Profile -->
    <link href="{{ asset('styles/profile.css?v=').time() }}" rel="stylesheet">

    <style>
        .font-20 {
            font-size: 20px;
        }
    </style>
</head>
<body>
    <!-- begin content -->
    <h5 class="mb-2 py-2 text-center">
        Laporan Kegiatan Magang Mahasiswa
    </h5>
    <!-- info mahasiswa -->
    <div class="border px-2 px-lg-3 py-3 mb-3 row">
        <div class="col-6">
        
            <div class="py-1">Informasi Mahasiswa Pelamar</div>
            <table class="table table-sm" cellspacing="0">
                <tr>
                    <td class="greybox"><b>Kampus</b></td>
                    <td>
                        <a href="{{ url('kampus/detail/'.$rekrut->univ_id) }}" class="text-dark">{{ $rekrut->univ_nama }}</a>
                    </td>
                </tr>
                <tr>
                    <td class="greybox"><b>NIM</b></td>
                    <td>
                        {{ $rekrut->mahasiswa_nim }}
                    </td>
                </tr>
                <tr>
                    <td class="greybox"><b>Mahasiswa</b></td>
                    <td>
                        {{ $rekrut->mahasiswa_nama }}
                    </td>
                </tr>
                <tr>
                    <td class="greybox"><b>TTL</b></td>
                    <td>
                        {{ $rekrut->mahasiswa_tempat_lahir ? $rekrut->mahasiswa_tempat_lahir : '-' }}, {{ $rekrut->mahasiswa_tgl_lahir ? $rekrut->mahasiswa_tgl_lahir : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="greybox"><b>Telepon</b></td>
                    <td>
                        {{ $rekrut->mahasiswa_no_tlp ? $rekrut->mahasiswa_no_tlp : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="greybox"><b>Domisili</b></td>
                    <td>
                        {{ $rekrut->city_nama ? $rekrut->city_nama : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="greybox"><b>Alamat</b></td>
                    <td>
                        {{ $rekrut->mahasiswa_alamat ? $rekrut->mahasiswa_alamat : '-' }}
                    </td>
                </tr>
                <tr>
                    <td class="greybox"><b>CV</b></td>
                    <td>
                        @if($rekrut->mahasiswa_cv)
                            <span class="badge badge-primary p-1">Sudah melengkapi CV</span>
                        @else
                            <span class="badge badge-secondary p-1">Belum melengkapi CV</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="greybox"><b>KHS</b></td>
                    <td>
                        @if($rekrut->mahasiswa_khs)
                            <span class="badge badge-primary p-1">Sudah melengkapi KHS</span>
                        @else
                            <span class="badge badge-secondary p-1">Belum melengkapi KHS</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="greybox"><b>Skills</b></td>
                    <td>
                        @foreach($skills as $skill)
                            <span class="badge badge-info p-1">{{ $skill->skill_nama }}</span>
                        @endforeach
                    </td>
                </tr>
            </table>

        </div>
        <div class="col-6">
        
            <div class="py-1">Informasi Pekerjaan</div>
            <table class="table table-sm" cellspacing="0">
                <tr>
                    <td class="greybox"><b>Perusahaan</b></td>
                    <td>
                        {{ $rekrut->perusahaan_nama }}
                    </td>
                </tr>
                <tr>
                    <td class="greybox"><b>Judul Lowongan</b></td>
                    <td>
                        {{ $rekrut->lowongan_judul }}
                    </td>
                </tr>
                <tr>
                    <td class="greybox"><b>Fungsi</b></td>
                    <td>
                        {{ $rekrut->fungsi_nama }}
                    </td>
                </tr>
                <tr>
                    <td class="greybox"><b>Kota Penempatan</b></td>
                    <td>
                        {{ $rekrut->city_nama }}
                    </td>
                </tr>
                <tr>
                    <td class="greybox"><b>Mulai Magang</b></td>
                    <td>
                        {{ date('d F Y', strtotime($rekrut->lowongan_tgl_mulai)) }}
                    </td>
                </tr>
                <tr>
                    <td class="greybox"><b>Durasi</b></td>
                    <td>
                        {{ $rekrut->lowongan_durasi }}
                    </td>
                </tr>
            </table>

        </div>
    </div>
    <!-- end info mahasiswa -->
        
    <!-- kegiatan -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">
        <table class="table table-sm table-bordered table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
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

    <!-- SB-Admin-->
    <script src="{{ url('js/sb-admin.min.js') }}"></script>

</body>