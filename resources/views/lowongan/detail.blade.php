@extends('layouts.front', ['title' => 'Detail Lowongan - MagangHub'])

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
<div class="row m-0 mt-5 panel">
    <div class="profile-thumb col-lg-3 col-md-4 pr-md-0 text-center text-dark">
        @if(empty($lowongan->perusahaan_profile_pict))
        <i class="fas fa-briefcase bg-white border p-2 shadow-sm" style="font-size: 130px"></i>
        @else
        <img src="{{ url('storage/perusahaan_profile/'.$lowongan->perusahaan_profile_pict) }}" class="bg-white border p-2 shadow">
        @endif
    </div>
    <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
        <h3 class="m-0">{{ $lowongan->perusahaan_nama }}</h3>
        <small>Menunggu kelengkapan profil untuk verifikasi</small>
    </div>
</div>
@endsection

@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item"><a href="{{ url('perusahaan/detail/'.$lowongan->perusahaan_id) }}">Profil Perusahaan</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detai Lowongan</li>
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

    <!-- detail lowongan -->
    <h5 class="mb-2 p-0">
        {{ $lowongan->lowongan_judul }}
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <table class="table table-sm" cellspacing="0">
            <tr>
                <td class="greybox"><b>Perusahaan</b></td>
                <td>
                    <a href="{{ url('perusahaan/detail/'.$lowongan->perusahaan_id) }}">
                        {{ $lowongan->perusahaan_nama }}
                    </a>
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Fungsi</b></td>
                <td>
                    {{ $lowongan->fungsi_nama }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Kota Penempatan</b></td>
                <td>
                    {{ $lowongan->city_nama }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Mulai Magang</b></td>
                <td>
                    {{ $lowongan->lowongan_tgl_mulai }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Durasi</b></td>
                <td>
                    {{ $lowongan->lowongan_durasi }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Jumlah Dibutuhkan</b></td>
                <td>
                    {{ $lowongan->lowongan_jlh_dibutuhkan }}
                </td>
            </tr>
        </table>

        <h5 class="mt-3 p-1 border-bottom">Syarat</h5>
        {!! $lowongan->lowongan_requirement !!}
        
        <h5 class="mt-3 p-1 border-bottom">Job Desk</h5>
        {!! $lowongan->lowongan_jobdesk !!}
        
        @if(Auth::check() && Auth::user()->user_role == 'mahasiswa')
        <a class="btn btn-block btn-outline-info p-1" href="#" data-toggle="modal" data-target="#confirmModal">
            <i class="fas fa-share-square"></i> Melamar Lowongan
        </a>
        @endif
    </div>
    <!-- end detail lowongan -->

    <!-- Apply Modal -->
    <div class="modal fade" id="confirmModal">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Konfirmasi</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Apakah anda yakin untuk melamar lowongan ini?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>

            <a class="btn btn-primary" href="{{ url('perekrutan/apply/'.$lowongan->lowongan_id) }}">Ya</a>
            </div>

        </div>
        </div>
    </div>
    <!-- End Apply Modal -->
@endsection

@section('bottom')
<!-- DataTable-->
<script src="{{ url('datatables/jquery.dataTables.js') }}"></script>
<script src="{{ url('datatables/dataTables.bootstrap4.js') }}"></script>

<!-- SB-Admin-->
<script src="{{ url('js/sb-admin.min.js') }}"></script>

@endsection