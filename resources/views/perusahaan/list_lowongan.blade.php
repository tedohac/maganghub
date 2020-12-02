@extends('layouts.front', ['title' => 'Lihat Kampus - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

    <style>
        .company-thumb img {
            max-width: 100%;
            display: block;
            margin: 0 auto;
        }
    </style>
@endsection

@section('banner-front')
<div class="py-3">
    <h3 class="">Kampus Terdaftar</h3>
    <p class="text-justify">
        Tenaga magang beragam skill dari banyak kampus terbaik menunggu di sini. Semua kampus di MagangHub memiliki data yang lengkap dan terverifikasi. 
        Kampus kamu belum terdaftar? Kirim undangan ke admin kampus kamu <a href="#" class="text-light">di sini</a>. Admin kampus yang akan mendaftarkan akun mahasiswa di MagangHub.
    </p>
</div>
@endsection

@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item active" aria-current="page">Cari Kampus</li>
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

    <!-- filter -->
    <div class="card mb-3 p-1">
        <div class="card-header p-1">
            
            <a class="btn btn-outline-primary p-1" data-toggle="collapse" href="#collapseSearchCon" role="button" aria-expanded="false" aria-controls="collapseSearchCon">    
                <i class="fas fa-filter"></i>
                Filter
            </a>

            <a href="#"><span class="badge badge-danger">Clear</span></a>
        </div>
        <div class="card-body collapse p-1" id="collapseSearchCon">
        <form id="formsend">

            <div class="row">
                <div class="col-lg-3 mb-3">
                    <div class="form-label-group mb-3">
                        <input id="namaKampus" class="form-control" placeholder="Nama Kampus" name="univ_nama" autofocus="autofocus">
                        <label for="namaKampus">Nama Kampus</label>
                    </div>
                </div>

                <div class="col-12">
                    <input type="submit" formmethod="get" class="btn btn-primary btn-block h-100" value="Apply" formaction="#">
                </div>

            </div>

        </form>
        </div>
    </div>
    <!-- end filter -->

    <!-- container -->
    @foreach($lowongans as $lowongan)
        <div class="bg-white border py-2 m-0 mb-3 shadow-sm row">
            <div class="company-thumb text-center col-lg-2 col-4">
                @if(empty($lowongan->perusahaan_profile_pict))
                <i class="fas fa-briefcase" style="font-size: 100px"></i>
                @else
                <img src="{{ url('storage/perusahaan_profile/'.$lowongan->perusahaan_profile_pict) }}">
                @endif
            </div>
            <div class="col-md-6 col-4">
                <h5 class="m-0 text-primary">{{ $lowongan->lowongan_judul }}</h5>
                {{ $lowongan->perusahaan_nama }} - <small><i>Menunggu verifikasi MagangHub</i></small><br />
                <small>{{ $lowongan->city_nama }}</small>
            </div>
            <div class="col-4 text-right">
                <small>Mulai magang :</small> {{ $lowongan->lowongan_tgl_mulai }}<br />
                <small>Durasi magang:</small> {{ $lowongan->lowongan_durasi }}<br />
                <small>Jumlah dibutuhkan:</small> {{ $lowongan->lowongan_jlh_dibutuhkan }}<br />
                <small>23 orang telah melamar</small>
            </div>
            <div class="col-12 text-right">
                @if(Auth::check() && (Auth::user()->user_role=='mahasiswa' || Auth::user()->user_role=='dospem' || Auth::user()->user_role=='admin kampus'))
                    <a class="btn btn-outline-info p-1 float-right" href="{{ route('perusahaan.edit') }}">
                        <small>Lihat Detail</small>
                    </a>
                @else
                    <small><i>Silahkan login untuk melihat detail dan melamar</i></small>
                @endif
            </div>
        </div>
    @endforeach

@endsection

@section('bottom')
<!-- SB-Admin-->
<script src="{{ url('js/sb-admin.min.js') }}"></script>
@endsection