@extends('layouts.front', ['title' => 'Edit Kegiatan - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

    <!-- Profile -->
    <link href="{{ asset('styles/profile.css?v=').time() }}" rel="stylesheet">

    <style>
        .font-20 {
            font-size: 20px;
        }
    </style>
@endsection

@section('banner-front')
<div class="row m-0 mt-5 py-4 panel">
</div>
@endsection

@section('content')
    @if(Auth::user()->user_role=='perusahaan')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item"><a href="{{ url('perusahaan/detail/'.$rekrut->lowongan_perusahaan_id) }}">Profil Perusahaan</a></li>
        <li class="breadcrumb-item"><a href="{{ url('perekrutan/pelamar/'.$rekrut->lowongan_id) }}">Pelamar</a></li>
        <li class="breadcrumb-item"><a href="{{ url('kegiatan/mentorview/'.$rekrut->rekrut_id) }}">Kegiatan Magang</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Kegiatan</li>
    </ol>
    @elseif(Auth::user()->user_role=='mahasiswa')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item"><a href="{{ route('kegiatan.manage') }}">Kegiatan Magang</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Kegiatan</li>
    </ol>
    @endif

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

    <!-- add form -->
    <h5 class="mb-2 p-0">
        Detail Kegiatan
    </h5>
    <div class="card mb-3 p-1">
        <div class="card-body p-1">
            <table class="table" cellspacing="0">
                <tr>
                    <td valign="center" width="50" class="greybox"><b>Tanggal</b></td>
                    <td>
                        <input type="hidden" name="kegiatan_tgl" value="{{ $kegiatan->kegiatan_tgl }}">
                        {{ date('d F Y', strtotime($kegiatan->kegiatan_tgl)) }}
                    </td>
                </tr>
                <tr>
                    <td valign="center" width="50" class="greybox"><b>Deskripsi</b></td>
                    <td>
                        {!! htmlspecialchars_decode($kegiatan->kegiatan_desc) !!}
                    </td>
                </tr>
                <td valign="center" width="50" class="greybox"><b>Berkas</b></td>
                <td>
                    <a class="btn btn-outline-success p-1" href="{{ url('storage/kegiatan/'.$kegiatan->kegiatan_path) }}"> 
                        <small>
                            <i class="fas fa-cloud-download-alt"></i>
                            Download Berkas
                        </small>
                    </a>
                </td>
                <tr>
                    <td valign="center" width="50" class="greybox"></td>
                    <td>
                    @if(empty($kegiatan->kegiatan_verify_mentor))
                        @if(Auth::user()->user_role=='perusahaan')
                            @if($rekrut->rekrut_status=='lulus')
                                <input type="button" class="btn btn-primary btn-block" value="Verifikasi" id="btnVerify">
                            @endif
                        @else
                            Belum diverifikasi
                        @endif
                    @else
                        Sudah diverifikasi pada {{ date('d F Y', strtotime($kegiatan->kegiatan_verify_mentor)) }}
                    @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <!-- end add form -->
    
    <!-- info mahasiswa -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <div class="py-1">Informasi Mahasiswa Pelamar</div>
        <table class="table table-sm" cellspacing="0">
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
                    @foreach($skills as $skill)
                        <span class="badge badge-info p-1">{{ $skill->skill_nama }}</span>
                    @endforeach
                </td>
            </tr>
        </table>
    </div>
    <!-- end info mahasiswa -->
        
    <!-- info lowongan -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">
        <div class="py-1">Informasi Pekerjaan</div>
        <table class="table table-sm" cellspacing="0">
            <tr>
                <td class="greybox"><b>Perusahaan</b></td>
                <td>
                    <a href="{{ url('perusahaan/detail/'.$rekrut->perusahaan_id) }}">
                        {{ $rekrut->perusahaan_nama }}
                    </a>
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
        <h5 class="mt-3 p-1 border-bottom">Job Desk</h5>
        {!! $rekrut->lowongan_jobdesk !!}
    </div>
    <!-- end info lowongan -->

<!-- Verify Modal -->
<div class="modal fade" id="verifyModal">
    <div class="modal-dialog">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Verifikasi Kegiatan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            Apakah anda yakin untuk memverifikasi kegiatan ini ?
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>

            <a class="btn btn-primary" href="{{ url('kegiatan/verify/'.$kegiatan->kegiatan_id) }}">Ya</a>
        </div>

    </div>
    </div>
</div>
<!-- End Verify Modal -->
@endsection

@section('bottom')
<!-- SB-Admin-->
<script src="{{ url('js/sb-admin.min.js') }}"></script>

<!-- Parsley Form Validation -->
<script src="{{ url('js/parsley.min.js') }}"></script>
<script>
    $("#formadd").parsley({
        errorClass: 'is-invalid text-danger',
        errorsWrapper: '<span class="form-text text-danger"></span>',
        errorTemplate: '<span></span>',
        trigger: 'change'
    })
</script>

<script>
    $(document).ready(function (){

        $('#btnSimpan').click(function(){
            $('#confirmModal').modal('show');
        });
        
        $('#btnVerify').click(function(){
            $('#verifyModal').modal('show');
        });
    });
</script>
@endsection