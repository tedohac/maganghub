@extends('layouts.front', ['title' => $mahasiswa->mahasiswa_nama.' - MagangHub'])

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
        @if(empty($mahasiswa->mahasiswa_profile_pict))
        <i class="fas fa-user-graduate bg-white border p-2 shadow-sm" style="font-size: 130px"></i>
        @else
        <img src="{{ url('storage/mahasiswa_profile/'.$mahasiswa->mahasiswa_profile_pict) }}" class="bg-white border p-2 shadow">
        @endif
    </div>
    <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
        <h3 class="m-0">{{ $mahasiswa->mahasiswa_nama }}</h3>
        {{ $mahasiswa->mahasiswa_nim }} - <a href="{{ url('kampus/detail/'.$mahasiswa->univ_id) }}" class="text-white">{{ $mahasiswa->univ_nama }}</a>
    </div>
</div>
@endsection


@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Mahasiswa</li>
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
        Profil Mahasiswa
        
        @if(Auth::check() && Auth::user()->user_email == $mahasiswa->mahasiswa_user_email)
        <a class="btn btn-outline-info p-1 float-right" href="{{ route('mahasiswa.edit') }}">
            <small><i class="fas fa-edit"></i> Edit Profil</small>
        </a>
        @endif
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">
        <table class="table" cellspacing="0">
            <tr>
                <td class="greybox"><b>Kampus</b></td>
                <td>
                    <a href="{{ url('kampus/detail/'.$mahasiswa->univ_id) }}" class="text-dark">{{ $mahasiswa->univ_nama }}</a>
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Prodi</b></td>
                <td>
                    {{ ($mahasiswa->prodi_fakultas!="") ? $mahasiswa->prodi_fakultas."-" : "" }} {{ $mahasiswa->prodi_nama }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>NIM</b></td>
                <td>
                    {{ $mahasiswa->mahasiswa_nim ? $mahasiswa->mahasiswa_nim : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>TTL</b></td>
                <td>
                    {{ $mahasiswa->mahasiswa_tempat_lahir ? $mahasiswa->mahasiswa_tempat_lahir : '-' }}, {{ $mahasiswa->mahasiswa_tgl_lahir ? date('d F Y', strtotime($mahasiswa->mahasiswa_tgl_lahir)) : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Telepon</b></td>
                <td>
                    {{ $mahasiswa->mahasiswa_no_tlp ? $mahasiswa->mahasiswa_no_tlp : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Domisili</b></td>
                <td>
                    {{ $mahasiswa->city_nama ? $mahasiswa->city_nama : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Alamat</b></td>
                <td>
                    {{ $mahasiswa->mahasiswa_alamat ? $mahasiswa->mahasiswa_alamat : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>CV</b></td>
                <td>
                    @if($mahasiswa->mahasiswa_cv)
                        <a class="btn btn-outline-success p-1" href="{{ url('storage/mahasiswa_cv/'.$mahasiswa->mahasiswa_cv) }}"> 
                            <i class="fas fa-cloud-download-alt"></i>
                            Download CV
                        </a>
                    @else
                        <span class="badge badge-danger p-1">Belum melengkapi CV</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>KHS</b></td>
                <td>
                    @if($mahasiswa->mahasiswa_khs)
                        <a class="btn btn-outline-success p-1" href="{{ url('storage/mahasiswa_khs/'.$mahasiswa->mahasiswa_khs) }}"> 
                            <i class="fas fa-cloud-download-alt"></i>
                            Download KHS
                        </a>
                    @else
                        <span class="badge badge-danger p-1">Belum melengkapi KHS</span>
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

                    @if(Auth::check() && Auth::user()->user_email == $mahasiswa->mahasiswa_user_email)
                    <a class="btn btn-outline-info p-1 float-right" href="{{ route('skill.manage') }}">
                        <small><i class="fas fa-edit"></i> Kelola Skills</small>
                    </a>
                    @endif
                </td>
            </tr>
        </table>
    </div>
    <!-- end detail info -->

@endsection

@section('bottom')
<!-- SB-Admin-->
<script src="{{ url('js/sb-admin.min.js') }}"></script>
@endsection