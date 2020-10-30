@extends('layouts.landing', ['title' => 'Lupa Password - MagangHub'])

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
            <h4>Lupa Password</h4>
            <p class="text-justify">Silahkan masukan alamat e-mail akun anda. Akan kami kirim tautan untuk melakukan proses perubahan password ke e-mail anda.</p>
            
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

            <form action="{{ route('forgetpass') }}" method="post" id="registform">
            @csrf
            <div class="form-label-group mb-3">
                <input id="emailKampus" class="form-control" placeholder="E-mail" name="email" required="required" autofocus="autofocus" type="email"
                    data-parsley-type="email"
                    data-parsley-required
                    data-parsley-required-message="Masukan e-mail"
                    data-parsley-type-message="Format e-mail tidak valid">
                <label for="emailKampus">E-mail</label>
                @error('email')
                    <span class="form-text text-danger">
                        {{ $message }}
                    </span>    
                @enderror
            </div>

            <input class="btn btn-success btn-block" value="Kirim Tautan Reset Password" type="submit">
            </form>
                
        </div>
    </div>
@endsection
    
@section('bottom')
    <!-- Bootstrap core JavaScript -->
    <script src="{{ url('jquery/parsley.min.js') }}"></script>
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