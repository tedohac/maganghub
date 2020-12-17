@extends('layouts.front', ['title' => 'Dashboard Admin - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">
    
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
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dashboard Admin</li>
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

    <!-- content -->
    <h5 class="mb-2 p-0">
        Dashboard Admin
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
    
        <div class="row">

            <div class="col-xl-4 col-sm-6 mb-3">
                <a class="text-white" href="#">
                    <div class="card text-white bg-primary o-hidden h-100 shadow p-2">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-university"></i>
                            </div>
                            <div>
                                Admin Kampus<br />
                                {{ \App\User::getCountAdmin('admin kampus') }} Pengguna
                            </div>
                        </div>
                    </div>
                </a>
            </div>
                
            <div class="col-xl-4 col-sm-6 mb-3">
                <a class="text-white" href="#">
                    <div class="card text-white bg-info o-hidden h-100 shadow p-2">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-briefcase"></i>
                            </div>
                            <div>
                                Perusahaan<br />
                                {{ \App\User::getCountAdmin('perusahaan') }} Pengguna
                            </div>
                        </div>
                    </div>
                </a>
            </div>
                
            <div class="col-xl-4 col-sm-6 mb-3">
                <a class="text-white" href="#">
                    <div class="card text-white bg-primary o-hidden h-100 shadow p-2">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-user"></i>
                            </div>
                            <div>
                                Dosen Pembimbing<br />
                                {{ \App\User::getCountAdmin('dospem') }} Pengguna
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-xl-4 col-sm-6 mb-3">
                <a class="text-white" href="#">
                    <div class="card text-white bg-info o-hidden h-100 shadow p-2">
                        <div class="card-body">
                            <div class="card-body-icon">
                                <i class="fas fa-fw fa-user-graduate"></i>
                            </div>
                            <div>
                                Mahasiswa<br />
                                {{ \App\User::getCountAdmin('mahasiswa') }} Pengguna
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    </div>
    <!-- end content -->
    
@endsection

@section('bottom')
<!-- SB-Admin-->
<script src="{{ url('js/sb-admin.min.js') }}"></script>

@endsection