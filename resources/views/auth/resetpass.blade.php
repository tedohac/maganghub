@extends('layouts.landing', ['title' => 'Reset Password - MagangHub'])

@section('head')
    <!-- SB Admin Template -->
    <link href="{{ url('styles/sb-admin.css') }}" rel="stylesheet">
    <style rel="stylesheet">
        body {
            background: #FFB4B0;
        }
        #content {
            background-color: #fff;
            margin-top: 100px;
            border-radius: 10px;
            -o-border-radius: 10px;
            -ms-border-radius: 10px;
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="card-login mx-auto shadow px-4 py-5" id="content">
            <h4>Reset Password</h4>
            <p class="text-justify">Silahkan masukan password baru anda.</p>
            
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

            <form action="{{ route('resetpassprocess') }}" method="post" id="registform">
            @csrf
            
            <div class="form-label-group mb-3">
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="token" value="{{ $token }}">
                <input id="passKampus" class="form-control" placeholder="" name="user_password" required="required" autofocus="autofocus"  type="password"
                    data-parsley-required
                    data-parsley-required-message="Masukkan password">
                <label for="passKampus">Password</label>
                @error('user_password')
                    <span class="form-text text-danger">
                        {{ $message }}
                    </span>    
                @enderror
            </div>
        
            <div class="form-label-group mb-3">
                <input id="copassKampus" class="form-control" placeholder="" name="pass_confirmation" required="required" autofocus="autofocus"  type="password"
                    data-parsley-required
                    data-parsley-required-message="Masukkan password"
                    data-parsley-equalto="#passKampus"
                    data-parsley-equalto-message="Password harus sama">
                <label for="copassKampus">Konfirmasi Password</label>
                @error('pass_confirmation')
                    <span class="form-text text-danger">
                        {{ $message }}
                    </span>    
                @enderror
            </div>

            <input class="btn btn-success btn-block" value="Ubah Password" type="submit">
            </form>
                
        </div>
    </div>
@endsection
    
@section('bottom')
    <!-- Bootstrap core JavaScript -->
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