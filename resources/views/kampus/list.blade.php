@extends('layouts.front', ['title' => 'Lihat Kampus - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

    <style>
        .card-profile-thumb {
            height: 140px;
            border-bottom: 1px solid rgba(0,0,0,.125);
        }
        .card-profile-thumb img {
            max-height: 100%;
            display: block;
            margin: 0 auto;
        }
        .card-ul{
            list-style: none;
            font-size: 14px;
            color: #777;
        }
        .card-title {
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
    <div class="row w-100 m-0">
    
    @foreach($univs as $univ)
        <div class="col-6 col-lg-4 p-0 mb-3">
            <div class="card m-2 shadow-sm h-100">
                <div class="card-profile-thumb p-3 text-center">
                    @if(empty($univ->univ_profile_pict))
                    <i class="fas fa-university" style="font-size: 100px"></i>
                    @else
                    <img src="{{ url('storage/univ/'.$univ->univ_profile_pict) }}">
                    @endif
                </div>
                <div class="card-body p-3">
                    <h5 class="card-title text-center m-0"><a href="{{ url('kampus/detail/'.$univ->univ_id) }}">{{ $univ->univ_nama }}</a></h5>
                    <div class="mb-3 text-center"><small><i>Menunggu verifikasi MagangHub</i></small></div>
                    <ul class="card-ul border p-0">
                        <li class="text-center p-2 border-bottom">

                            <div class="text-center"><small>akreditasi</small></div>
                            <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<6 ? 'text-warning' : '' }}"></span>
                            <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<5 ? 'text-warning' : '' }}"></span>
                            <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<4 ? 'text-warning' : '' }}"></span>
                            <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<3 ? 'text-warning' : '' }}"></span>
                            <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<2 ? 'text-warning' : '' }}"></span>
                            <span class="font-20">({{ strtoupper($univ->univ_akreditasi) }})</span>

                        </li>
                        <li class="text-center p-2 border-bottom">
                            Jumlah PRODI : 6
                        </li>
                        <li class="text-center p-2 border-bottom">
                            Jumlah Pencari Magang : 57
                        </li>
                        <li class="text-center p-2 border-bottom">
                            <a href="{{ ($univ->univ_website!='') ? $univ->univ_website : '#' }}">{{ ($univ->univ_website!='') ? $univ->univ_website : '-' }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    @endforeach
    </div>
    <!-- end container -->

@endsection

@section('bottom')
<!-- SB-Admin-->
<script src="{{ url('js/sb-admin.min.js') }}"></script>
@endsection