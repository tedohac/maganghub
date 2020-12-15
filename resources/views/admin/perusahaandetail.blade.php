@extends('layouts.front', ['title' => $perusahaan->perusahaan_nama.' - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

    <!-- DataTable-->
    <link href="{{ url('datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- Profile -->
    <link href="{{ asset('styles/profile.css?v=').time() }}" rel="stylesheet">

    <style>
        .font-20 {
            font-size: 20px;
        }
    </style>
@endsection

@section('banner-front')
<div class="row m-0 mt-5 panel">
    <div class="profile-thumb col-lg-3 col-md-4 pr-md-0 text-center text-dark">
        @if(empty($perusahaan->perusahaan_profile_pict))
        <i class="fas fa-briefcase bg-white border p-2 shadow-sm" style="font-size: 130px"></i>
        @else
        <img src="{{ url('storage/perusahaan_profile/'.$perusahaan->perusahaan_profile_pict) }}" class="bg-white border p-2 shadow">
        @endif
    </div>
    <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
        <h3 class="m-0">{{ $perusahaan->perusahaan_nama }}</h3>
        @if(\App\Perusahaan::getIsVerified($perusahaan->perusahaan_id))
            <small><i class="fas fa-check"></i> Terverifikasi</small>
        @else
            <small>Menunggu kelengkapan profil untuk verifikasi</small>
        @endif
    </div>
</div>
@endsection


@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.perusahaanlist') }}">Daftar Perusahaan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Perusahaan</li>
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
        Profil Perusahaan
        
        @if(Auth::check() && Auth::user()->user_email == $perusahaan->perusahaan_user_email)
        <a class="btn btn-outline-info p-1 float-right" href="{{ route('perusahaan.edit') }}">
            <small><i class="fas fa-edit"></i> Edit Profil</small>
        </a>
        @endif
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">
        <table class="table" cellspacing="0">
            <tr>
                <td class="greybox"><b>NIB</b></td>
                <td>
                    {{ $perusahaan->perusahaan_nib ? $perusahaan->perusahaan_nib : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Nama</b></td>
                <td>
                    {{ $perusahaan->perusahaan_nama ? $perusahaan->perusahaan_nama : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Telepon</b></td>
                <td>
                    {{ $perusahaan->perusahaan_no_tlp ? $perusahaan->perusahaan_no_tlp : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Kota</b></td>
                <td>
                    {{ $perusahaan->city_nama ? $perusahaan->city_nama : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Alamat</b></td>
                <td>
                    {{ $perusahaan->perusahaan_alamat ? $perusahaan->perusahaan_alamat : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Berkas NIB</b></td>
                <td>
                    @if($perusahaan->perusahaan_nib_path!="")
                        <a class="btn btn-outline-success p-1" href="{{ url('storage/perusahaan_nib/'.$perusahaan->perusahaan_nib_path) }}"> 
                            <i class="fas fa-cloud-download-alt"></i>
                            Download NIB
                        </a>
                    @else
                        <span class="badge badge-danger p-1">Belum Dilengkapi</span>
                    @endif
                </td>
            </tr>
        </table>
        <div class="row">
            <div class="col-6">
                @if(empty($perusahaan->perusahaan_verified))
                    <input type="button" class="btn btn-primary btn-block py-1" value="Verifikasi" id="btnVerify">
                @else
                    Kampus sudah diverifikasi pada {{ date('d F Y', strtotime($perusahaan->perusahaan_verified)) }}
                @endif
            </div>
            <div class="col-6">
                <input type="button" class="btn btn-danger btn-block py-1" value="Awasi" id="btnAwasi">
            </div>
            @if(\App\Lowongan::getCountByPerusahaan($perusahaan->perusahaan_id)==0)
            <div class="col-6 mt-2">
                <input type="button" class="btn btn-danger btn-block py-1" value="Hapus" id="btnHapus">
            </div>
            @endif
        </div>
    </div>
    <!-- end detail info -->

    <!-- loker list -->
    <h5 class="mb-2 p-0">
        Lowongan Magang Tersedia
        
        @if(Auth::check() && Auth::user()->user_email == $perusahaan->perusahaan_user_email)
        <a class="btn btn-outline-info p-1 float-right" href="{{ route('lowongan.manage') }}">
            <small><i class="fas fa-edit"></i> Kelola Lowongan</small>
        </a>
        @endif
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">
        
        <table class="table table-sm table-striped table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead class="greybox">
                <tr>
                    <th>#</th>
                    <th>Lowongan</th>
                    <th>Fungsi</th>
                    <th>Penempatan</th>
                    <th>Tgl Mulai</th>
                    <th>Durasi</th>
                    <th>Jlh Dibutuhkan</th>
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
                    <td>{{ $lowongan->lowongan_durasi }}</td>
                    <td>{{ $lowongan->lowongan_jlh_dibutuhkan }}</td>
                </tr>
                @php ($num++)
            @endforeach
            </tbody>
        </table>

    </div>
    <!-- end loker list -->
    
<!-- Verify Modal -->
<div class="modal fade" id="verifyModal">
    <div class="modal-dialog">
    <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
        <h4 class="modal-title">Verifikasi Perusahaan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
            Apakah anda yakin untuk memverifikasi perusahaan ini ?
        </div>

        <!-- Modal footer -->
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>

            <a class="btn btn-primary" href="{{ url('admin/perusahaanverify/'.$perusahaan->perusahaan_id) }}">Ya</a>
        </div>

    </div>
    </div>
</div>
<!-- End Verify Modal -->
@endsection

@section('bottom')
<!-- DataTable-->
<script src="{{ url('datatables/jquery.dataTables.js') }}"></script>
<script src="{{ url('datatables/dataTables.bootstrap4.js') }}"></script>

<!-- SB-Admin-->
<script src="{{ url('js/sb-admin.min.js') }}"></script>

<script>
    $(document).ready(function (){
        var table = $('#dataTable').DataTable();
        
        $('#btnVerify').click(function(){
            $('#verifyModal').modal('show');
        });
    });
</script>
@endsection