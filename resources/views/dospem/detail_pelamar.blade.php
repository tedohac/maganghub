@extends('layouts.front', ['title' => 'Detail Pelamar - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

    <!-- Profile -->
    <link href="{{ asset('styles/profile.css?v=').time() }}" rel="stylesheet">

    <!-- Tracking -->
    <link href="{{ asset('styles/tracking.css?v=').time() }}" rel="stylesheet">

    <style>
        .font-20 {
            font-size: 20px;
        }
    </style>
@endsection

@section('banner-front')
<div class="row m-0 mt-5 panel">
    <div class="profile-thumb col-lg-3 col-md-4 pr-md-0 text-center text-dark">
        @if(empty($rekrut->mahasiswa_profile_pict))
        <i class="fas fa-user-graduate bg-white border p-2 shadow-sm" style="font-size: 130px"></i>
        @else
        <img src="{{ url('storage/mahasiswa_profile/'.$rekrut->mahasiswa_profile_pict) }}" class="bg-white border p-2 shadow">
        @endif
    </div>
    <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
        <h3 class="m-0">{{ $rekrut->mahasiswa_nama }}</h3>
        {{ $rekrut->mahasiswa_nim }} - <a href="{{ url('kampus/detail/'.$rekrut->univ_id) }}" class="text-white">{{ $rekrut->univ_nama }}</a>
    </div>
</div>
@endsection


@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mahasiswa.pantau') }}">Daftar Mahasiswa</a></li>
        <li class="breadcrumb-item"><a href="{{ url('dospem/lamaranlist-dospem/'.$rekrut->mahasiswa_id) }}">Daftar Lamaran</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Lamaran</li>
    </ol>

    @if(session('errors'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif
    @if (Session::has('error'))
        <div class="alert alert-danger">
            {{ Session::get('error') }}
        </div>
    @endif

    <!-- detail info -->
    <h5 class="mb-2 p-0">
        Detail Pelamar

        <a class="btn btn-outline-info p-1 mr-1 float-right" href="{{ route('perekrutan.printdetailpelamar', ['id' => $rekrut->rekrut_id]) }}">
            <small><i class="fas fa-file-pdf"></i> Cetak Detail Pelamar</small>
        </a>
    </h5>
    <!-- lamaran status -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">

        @if($rekrut->rekrut_status=="magang")
        <div class="alert alert-warning">
            Mahasiswa ini sudah lulus pada lowongan lain dan sedang melakukan magang
        </div>
        @elseif($rekrut->rekrut_status=="melamar")
        @elseif($rekrut->rekrut_status=="melamartlk")
        <div class="alert alert-warning">
            Perusahaan sudah menolak lamaran ini.
        </div>
        @elseif($rekrut->rekrut_status=="diundang")
        <div class="alert alert-warning">
            Perusahaan sudah mengirim undangan test, menunggu konfirmasi mahasiswa. 
        </div>
        @elseif($rekrut->rekrut_status=="siap test")
        <div class="alert alert-warning">
            Mahasiswa mengkonfirmasi atas undangan test dari Perusahaan, sudah ada hasil test?
        </div>
        @elseif($rekrut->rekrut_status=="tlkundang")
        <div class="alert alert-warning">
            Mahasiswa menolak undangan terakhir dari perusahaan (mohon lihat detail undangan di bawah) dengan alasan:<br />
            {{ $rekrut->rekrut_tolakundangan_reason }}<br />
            Perusahaan dapat mengirim kembali undangan ke mahasiswa tersebut.
        </div>
        @elseif($rekrut->rekrut_status=="tdklulus")
        <div class="alert alert-warning">
            Perusahaan telah menyatakan bahwa mahasiswa ini tidak lulus test.
        </div>
        @elseif($rekrut->rekrut_status=="lulus")
        <div class="alert alert-warning">
            Perusahaan telah menyatakan bahwa mahasiswa ini lulus test dan diterima magang pada lowongan ini.<br />
            Mahasiswa dapat langsung membuat kegiatan magang.
        </div>
        @endif

        <div class="track">
            <div class="step {{ ($rekrut->rekrut_waktu_melamar) ? 'active' : '' }}"> 
                <span class="icon"> 
                    <i class="fa fa-share-square pt-2"></i> 
                </span> 
                <span class="text">
                    Melamar<br />
                    <small>{{ ($rekrut->rekrut_waktu_melamar) ? date('d M Y H:i', strtotime($rekrut->rekrut_waktu_melamar)) : "" }}</small>
                </span>
            </div>
            <div class="step {{ ($rekrut->rekrut_waktu_diundang) ? 'active' : '' }}"> 
                <span class="icon"> 
                    <i class="fa fa-user pt-2"></i> 
                </span> 
                <span class="text">
                    Undangan<br />
                    <small>{{ ($rekrut->rekrut_waktu_diundang) ? date('d M Y H:i', strtotime($rekrut->rekrut_waktu_diundang)) : "" }}</small>
                </span> 
            </div>
            <div class="step {{ ($rekrut->rekrut_waktu_konfirmundangan) ? 'active' : '' }}"> 
                <span class="icon"> 
                    <i class="fa fa-file-alt pt-2"></i> 
                </span> 
                <span class="text">
                    Siap Test<br />
                    <small>{{ ($rekrut->rekrut_waktu_konfirmundangan) ? date('d M Y H:i', strtotime($rekrut->rekrut_waktu_konfirmundangan)) : "" }}</small>
                </span>
            </div>
            <div class="step {{ ($rekrut->rekrut_waktu_diterima) ? 'active' : '' }}"> 
                <span class="icon"> 
                    <i class="fa fa-check-double pt-2"></i> 
                </span> 
                <span class="text">
                    Diterima<br />
                    <small>{{ ($rekrut->rekrut_waktu_diterima) ? date('d M Y H:i', strtotime($rekrut->rekrut_waktu_diterima)) : "" }}</small>
                </span>
            </div>
        </div>
    </div>
    <!-- end lamaran status -->

    @if($rekrut->rekrut_waktu_diundang)
    <!-- undangan test -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <div class="py-1">Undangan Test</div>
        <table class="table" cellspacing="0">
            <tr>
                <td class="greybox"><b>Waktu</b></td>
                <td>{{ date('d M Y H:i', strtotime($rekrut->rekrut_undangan_waktu)) }}</td>
            </tr>
            <tr>
                <td class="greybox"><b>Tempat</b></td>
                <td>{{ $rekrut->rekrut_undangan_alamat }}</td>
            </tr>
            <tr>
                <td class="greybox"><b>Deskripsi</b></td>
                <td>{!! $rekrut->rekrut_undangan_desc !!}</td>
            </tr>
        </table>
    </div>
    <!-- end undangan test -->
    @endif

    <!-- info mahasiswa -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <div class="py-1">Informasi Mahasiswa Pelamar</div>
        <table class="table" cellspacing="0">
            <tr>
                <td class="greybox"><b>Kampus</b></td>
                <td>
                    <a href="{{ url('kampus/detail/'.$rekrut->univ_id) }}" class="text-dark">{{ $rekrut->univ_nama }}</a>
                    @if(\App\Univ::getIsBanned($rekrut->univ_id))
                        <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Kampus ini sedang dalam pengawasan</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Prodi</b></td>
                <td>
                    {{ ($rekrut->prodi_fakultas!="") ? $rekrut->prodi_fakultas."-" : "" }} {{ $rekrut->prodi_nama }}
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
                    {{ $rekrut->mahasiswa_tempat_lahir ? $rekrut->mahasiswa_tempat_lahir : '-' }}, {{ $rekrut->mahasiswa_tgl_lahir ? date('d F Y', strtotime($rekrut->mahasiswa_tgl_lahir)) : '-' }}
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
                        <a class="btn btn-outline-success p-1" href="{{ url('storage/mahasiswa_cv/'.$rekrut->mahasiswa_cv) }}"> 
                            <i class="fas fa-cloud-download-alt"></i>
                            Download CV
                        </a>
                    @else
                        <span class="badge badge-secondary p-1">Belum melengkapi CV</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>KHS</b></td>
                <td>
                    @if($rekrut->mahasiswa_khs)
                        <a class="btn btn-outline-success p-1" href="{{ url('storage/mahasiswa_khs/'.$rekrut->mahasiswa_khs) }}"> 
                            <i class="fas fa-cloud-download-alt"></i>
                            Download KHS
                        </a>
                    @else
                        <span class="badge badge-secondary p-1">Belum melengkapi KHS</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Skills</b></td>
                <td>
                    @if(count($skills))
                        @foreach($skills as $skill)
                            <span class="badge badge-info p-1">{{ $skill->skill_nama }}</span>
                        @endforeach
                    @else
                        <span class="badge badge-danger p-1">Belum menambahkan skill</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <!-- end info mahasiswa -->
        
    <!-- info lowongan -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <div class="py-1">Informasi Lowongan</div>
        <table class="table" cellspacing="0">
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
                    {{ $rekrut->lowongan_tgl_mulai }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Durasi</b></td>
                <td>
                    {{ $rekrut->lowongan_durasi }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Jumlah Dibutuhkan</b></td>
                <td>
                    {{ $rekrut->lowongan_jlh_dibutuhkan }}
                </td>
            </tr>
        </table>
        <h5 class="mt-3 p-1 border-bottom">Syarat</h5>
        {!! $rekrut->lowongan_requirement !!}
        
        <h5 class="mt-3 p-1 border-bottom">Job Desk</h5>
        {!! $rekrut->lowongan_jobdesk !!}
    </div>
    <!-- end info lowongan -->
@endsection

@section('bottom')

<!-- SB-Admin-->
<script src="{{ url('js/sb-admin.min.js') }}"></script>
@endsection