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
        .font-15 {
            font-size: 15px;
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

            @if($filter->nama!="")
                <a href="{{ route('lowongan.list') }}"><span class="badge badge-danger">Clear</span></a>
            @endif
        </div>
        <div class="card-body collapse p-1" id="collapseSearchCon">
        <form method="get" id="formadd" action="{{ route('kampus.list') }}">

            <div class="row">
                <div class="col-6 mb-2">
                    <small>Nama</small><br>
                    <input class="form-control" name="filter_nama" value="{{ $filter->nama }}">
                </div>

                <div class="col-12">
                    <input type="submit" class="btn btn-primary btn-block h-100" value="Apply">
                </div>

            </div>

        </form>
        </div>
    </div>
    <!-- end filter -->

    <!-- container -->
    {{ $univs->links() }}
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
                    <div class="mb-3 text-center">
                        @if(\App\Univ::getIsVerified($univ->univ_id))
                            <small><i class="fas fa-check"></i> Terverifikasi</small>
                        @else
                            <small>Menunggu kelengkapan profil untuk verifikasi</small>
                        @endif
                    </div>
                    <ul class="card-ul border p-0">
                        <li class="text-center p-2 border-bottom">

                            <div class="text-center"><small>Akreditasi</small></div>
                            <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<6 ? 'text-warning' : '' }}"></span>
                            <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<5 ? 'text-warning' : '' }}"></span>
                            <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<4 ? 'text-warning' : '' }}"></span>
                            <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<3 ? 'text-warning' : '' }}"></span>
                            <span class="font-20 fa fa-star {{ $univ->univ_akreditasi!='' && ord($univ->univ_akreditasi)-96<2 ? 'text-warning' : '' }}"></span>
                            <span class="font-20">({{ strtoupper($univ->univ_akreditasi) }})</span>

                        </li>
                        <li class="text-center p-2 border-bottom">

                            <div class="text-center"><small>Score Ulasan Magang</small></div>
                            @php($rating = \App\Rekrut::getRatingKampus($univ->univ_id))
                            @php($rating = empty($rating) ? 0 : $rating->rating*10)
                            
                            @if($rating==0)
                                <span class="badge badge-secondary font-15">-</span>
                            @else
                                <span class="badge badge-info font-15">{{ round($rating) }}</span>
                            @endif

                        </li>
                        <li class="text-center p-2 border-bottom">
                            Jumlah PRODI : {{ \App\Prodi::getCountByUniv($univ->univ_id) }}
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
    {{ $univs->links() }}
    <!-- end container -->

@endsection

@section('bottom')
<!-- SB-Admin-->
<script src="{{ url('js/sb-admin.min.js') }}"></script>
@endsection