@extends('layouts.front', ['title' => 'Tambah Kegiatan - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

    <!-- Profile -->
    <link href="{{ asset('styles/profile.css?v=').time() }}" rel="stylesheet">
    
    <!-- Jodit -->
    <link href="{{ url('styles/jodit.min.css') }}" rel="stylesheet">

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
        <li class="breadcrumb-item"><a href="{{ route('kegiatan.manage') }}">Kegiatan Magang</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Kegiatan</li>
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

<form method="post" id="formadd" action="{{ route('kegiatan.save') }}" enctype="multipart/form-data">
@csrf
    <!-- add form -->
    <h5 class="mb-2 p-0">
        Tambah Kegiatan
    </h5>
    <div class="card mb-3 p-1">
        <div class="card-body p-1">
            <table class="table table-sm" cellspacing="0">
                <tr>
                    <td valign="center" width="50" class="greybox"><b>Tanggal</b></td>
                    <td>
                        <input type="hidden" name="kegiatan_tgl" value="{{ $kegiatan_tgl }}">
                        {{ date('d F Y', strtotime($kegiatan_tgl)) }}
                    </td>
                </tr>
                <tr>
                    <td valign="center" width="50" class="greybox"><b>Deskripsi</b></td>
                    <td>
                        <textarea id="descKegiatan" class="form-control" placeholder="Deskripsi Kegiatan" name="kegiatan_desc" required="required"
                            data-parsley-required
                            data-parsley-required-message="Masukan deskripsi kegiatan">{{ old('kegiatan_desc') }}</textarea>
                        @error('kegiatan_desc')
                            <span class="form-text text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </td>
                </tr>
                <td valign="center" width="50" class="greybox"><b>Berkas</b></td>
                <td>
                    <small>Masukan ke zip jika berkas lebih dari satu</small>
                    <div class="input-group w-50">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="kegiatanPath" name="kegiatan_path">
                            <label class="custom-file-label" for="kegiatanPath">Pilih berkas kegiatan</label>
                        </div>
                    </div>
                </td>
                <tr>
                    <td valign="center" width="50" class="greybox"></td>
                    <td>
                        <input type="button" class="btn btn-success btn-block" value="Simpan" id="btnSimpan">
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <!-- end add form -->

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
                Apakah anda yakin untuk menyimpan kegiatan ini?
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

<script>
    $(document).ready(function (){

        $('#btnSimpan').click(function(){
            $('#confirmModal').modal('show');
        });

        $('#formadd').parsley().on('form:validate', function (formInstance) {
            var success = formInstance.isValid();
            
            if (!success) {
                $('#confirmModal').modal('hide');
            }
        });
    });
</script>

<!-- Jodit-->
<script src="{{ url('js/jodit.min.js') }}"></script>
<script>
    $(document).ready(function(){
        var editor = new Jodit("#descKegiatan", {
            "spellcheck": false,
            "buttons": "undo,redo,|,bold,underline,italic,|,superscript,subscript,|,ul,ol,|,outdent,indent,align,fontsize,|,image,link,|",
        });
    })
</script>

<script>
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });
</script>
@endsection