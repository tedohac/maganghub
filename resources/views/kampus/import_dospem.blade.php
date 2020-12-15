@extends('layouts.front', ['Import Dosen Pembimbing - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

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
        @if($univ->univ_profile_pict == "")
        <i class="fas fa-university bg-white border p-2 shadow-sm" style="font-size: 130px"></i>
        @else
        <img src="{{ url('storage/univ/'.$univ->univ_profile_pict) }}" class="bg-white border p-2 shadow-sm">
        @endif
    </div>
    <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
        <h3 class="m-0">{{ $univ->univ_nama }}</h3>
        @if(\App\Univ::getIsVerified($univ->univ_id))
            <small><i class="fas fa-check"></i> Terverifikasi</small>
        @else
            <small>Menunggu kelengkapan profil untuk verifikasi</small>
        @endif
    </div>
</div>
@endsection


@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item"><a href="{{ route('kampus.list') }}">Cari Kampus</a></li>
        <li class="breadcrumb-item"><a href="{{ url('kampus/detail/'.$univ->univ_id) }}">Detail Kampus</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dospem.manage') }}">Kelola DOSPEM</a></li>
        <li class="breadcrumb-item active" aria-current="page">Import</li>
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

    
<form method="post" id="formadd" action="{{ route('dospem.import') }}" enctype="multipart/form-data">
@csrf
    <!-- import form -->
    <h5 class="mb-2 p-0">
        Import Dosen Pembimbing
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">

        <table class="table table-sm" cellspacing="0">
            <tr>
                <td valign="center" width="50" class="greybox"><b>Catatan</b></td>
                <td>
                    <div class="alert alert-info">
                        Import data dosen pembimbing akan melakukan proses tambah dosen pembimbing secara bulk data.<br />
                        Sama seperti tambah DOSPEM, jika ada daftar NIK atau e-mail yang sudah terdaftar, daftar tersebut akan dilewati.
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Download Template</b></td>
                <td>
                    <a class="btn btn-outline-success p-1" href="{{ asset('template/template_import_dospem.csv') }}"> 
                        <i class="fas fa-cloud-download-alt"></i>
                        Template Dosen Pembimbing
                    </a>
                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"><b>Upload Data</b></td>
                <td>
                    
                    <div class="input-group w-50">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="importFile" name="import_file" accept=".csv">
                            <label class="custom-file-label" for="importFile">Pilih file</label>
                        </div>
                    </div>
                    <span id="errorimportFile" class="form-text text-danger"></span>
                </td>
            </tr>
            <tr>
                <td valign="center" width="50" class="greybox"></td>
                <td>
                    <input type="button" class="btn btn-success btn-block" value="Import Dosen Pembimbing" id="btnsubmit" data-toggle="modal" data-target="#confirmModal">
                </td>
            </tr>
        </table>

    </div>
    <!-- end import form -->

    <!-- Confirm Modal -->
    <div class="modal fade" id="confirmModal">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Konfirmasi</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Apakah anda yakin untuk import data dosen pembimbing?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>

            <input  type="submit" class="btn btn-primary" id="sendsubmit" value="Ya">
            </div>

        </div>
        </div>
    </div>
    <!-- End Confirm Modal -->
</form>
@endsection

@section('bottom')
<!-- SB-Admin-->
<script src="{{ url('js/sb-admin.min.js') }}"></script>

<!-- Parsley Form Validation -->
<script src="{{ url('js/parsley.min.js') }}"></script>
<script>
    $("#formadd").parsley({
        errorClass: 'is-invalid text-danger',
        errorsWrapper: '<span class="form-text text-danger"></span>',
        errorTemplate: '<span></span>',
        trigger: 'change'
    })
</script>

<!-- custom-file-input -->
<script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
@endsection