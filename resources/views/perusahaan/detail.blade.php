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
        <i class="fas fa-user-graduate bg-white border p-2 shadow-sm" style="font-size: 130px"></i>
        @else
        <img src="{{ url('storage/perusahaan_profile/'.$perusahaan->perusahaan_profile_pict) }}" class="bg-white border p-2 shadow">
        @endif
    </div>
    <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
        <h3 class="m-0">{{ $perusahaan->perusahaan_nama }}</h3>
        <small>Menunggu kelengkapan profil untuk verifikasi</small>
    </div>
</div>
@endsection


@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
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
        <a class="btn btn-outline-info p-1 float-right" href="#">
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
                <td class="greybox"><b>NIB</b></td>
                <td>
                    {{ $perusahaan->perusahaan_nib_path ? $perusahaan->perusahaan_nib_path : '-' }}
                </td>
            </tr>
        </table>
    </div>
    <!-- end detail info -->

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
    });
</script>
@endsection