@extends('layouts.landing', ['title' => 'Daftar Kampus Baru - MagangHub'])

@section('head')
    <!-- SB Admin Template -->
    <link href="{{ url('styles/sb-admin.css') }}" rel="stylesheet">
    <style rel="stylesheet">
        body {
            background: #FFB4B0;
        }
        #content-left {
            background-image: url("{{ url('img/bg-landing.png') }}");
            background-position: center top;
            background-repeat: no-repeat;
            background-size: 100% 100%;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }
        .row-eq-height {
            display: -webkit-box;
            display: -webkit-flex;
            display: -ms-flexbox;
            display: flex;
            background-color: #fff;
            margin-top: 100px;
            border-radius: 10px;
            -o-border-radius: 10px;
            -ms-border-radius: 10px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
        }
        @media screen and (max-width: 991px) {
            .row-eq-height {
                margin: 100px 10px;
                flex-direction:  column;
                -o-flex-direction:  column;
                -ms-flex-direction:  column;
                -moz-flex-direction:  column;
                -webkit-flex-direction:  column;
            }
            #content-left {
                border-top-right-radius: 10px;
                border-bottom-left-radius: 0;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row row-eq-height shadow">
            <div class="col-md-6 px-4 py-5 text-white" id="content-left">
				<h3 class="mb-5">Daftarkan Kampus Anda Sekarang!</h3>
                <p class="text-justify">Anda seorang admin Kampus? daftar sekarang untuk dapat menyalurkan mahasiswa anda ke banyak lowongan terbaik di sini. Prosesnya mudah, aman, dan gratis!</p>
                <a class="btn btn-light px-1 py-1 mt-2" href="{{ route('login') }}">Sudah punya akun?</a>
            </div>
            <div class="col-md-6 px-4 py-5" id="content-right">
                <h3 class="mb-5">DAFTAR KAMPUS BARU</h3>

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

			    <form action="{{ route('registkampus') }}" method="post" id="registform">
                @csrf
				<div class="form-label-group mb-3">
                    <input id="namaKampus" class="form-control" placeholder="" name="univ_nama" required="required" autofocus="autofocus" type="text" value="{{ old('univ_nama') }}"
                        data-parsley-required
                        data-parsley-maxlength="200"
                        data-parsley-required-message="Masukan nama kampus"
                        data-parsley-maxlength-message="Max nama kampus 200 karakter">
                    <label for="namaKampus">Nama Kampus</label>
                    @error('univ_nama')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror
                    <!-- <div class="small text-danger"></div> -->
                </div>

				<div class="form-label-group mb-3">
                    <input id="npsnKampus" class="form-control" placeholder="" name="univ_npsn" required="required" type="text" value="{{ old('univ_npsn') }}"
                        data-parsley-required
                        data-parsley-required-message="Masukan NPSN kampus">
                    <label for="npsnKampus">NPSN</label>
                    @error('univ_npsn')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror
                </div>

				<div class="form-label-group mb-3">
                    <input id="emailKampus" class="form-control" placeholder="" name="user_email" required="required" type="email" value="{{ old('user_email') }}"
                        data-parsley-type="email"
                        data-parsley-required
                        data-parsley-required-message="Masukan e-mail admin kampus"
                        data-parsley-type-message="Format e-mail tidak valid">
                    <label for="emailKampus">E-mail Admin Kampus</label>
                    @error('user_email')
                        <span class="form-text text-danger">
                            {{ $message }}
                        </span>    
                    @enderror
                </div>

                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-label-group mb-3">
                            <input id="passKampus" class="form-control" placeholder="" name="user_password" required="required"  type="password"
                                data-parsley-required
                                data-parsley-required-message="Masukkan password">
                            <label for="passKampus">Password</label>
                            @error('user_password')
                                <span class="form-text text-danger">
                                    {{ $message }}
                                </span>    
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-label-group mb-3">
                            <input id="copassKampus" class="form-control" placeholder="" name="user_password_confirmation" required="required"  type="password"
                                data-parsley-required
                                data-parsley-required-message="Masukkan password"
                                data-parsley-equalto="#passKampus"
                                data-parsley-equalto-message="Password harus sama">
                            <label for="copassKampus">Konfirmasi Password</label>
                            @error('user_password_confirmation')
                                <span class="form-text text-danger">
                                    {{ $message }}
                                </span>    
                            @enderror
                        </div>
                    </div>
                </div>

                <input class="btn btn-success btn-block" value="DAFTAR" type="submit">
                </form>
                
            </div>
        </div>
    </div>
@endsection
    

@section('bottom')
    <!-- Parsley Form Validation -->
    <script src="{{ url('js/parsley.min.js') }}"></script>
	<script>
        $("#registform").parsley({
            errorClass: 'is-invalid text-danger',
            errorsWrapper: '<span class="form-text text-danger"></span>',
            errorTemplate: '<span></span>',
            trigger: 'change'
        }) /* If you want to validate fields right after page loading, just add this here : .validate()*/ ;
        
        // Parsley full doc is avalailable here : https://github.com/guillaumepotier/Parsley.js/
	</script>
@endsection