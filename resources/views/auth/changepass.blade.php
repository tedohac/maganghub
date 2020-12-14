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
            <h4>Ubah Password</h4>
            
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

            <form action="{{ route('changepassprocess') }}" method="post" id="registform">
            @csrf
            
            <div class="form-label-group mb-3">
                <input id="passLama" class="form-control" placeholder="" name="user_password_lama" required="required" autofocus="autofocus" type="password"
                    data-parsley-required
                    data-parsley-required-message="Masukkan password lama">
                <label for="passLama">Password Lama</label>
                @error('user_password_lama')
                    <span class="form-text text-danger">
                        {{ $message }}
                    </span>    
                @enderror
            </div>

            <div class="form-label-group mb-3">
                <input id="passBaru" class="form-control" placeholder="" name="user_password_baru" required="required" type="password"
                    data-parsley-required
                    data-parsley-required-message="Masukkan password baru">
                <label for="passBaru">Password Baru</label>
                @error('user_password')
                    <span class="form-text text-danger">
                        {{ $message }}
                    </span>    
                @enderror
            </div>
        
            <div class="form-label-group mb-3">
                <input id="copassKampus" class="form-control" placeholder="" name="pass_confirmation" required="required" type="password"
                    data-parsley-required
                    data-parsley-required-message="Masukkan konfirmasi password baru"
                    data-parsley-equalto="#passBaru"
                    data-parsley-equalto-message="Konfirmasi password harus baru harus sama denggan password baru">
                <label for="copassKampus">Konfirmasi Password Baru</label>
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