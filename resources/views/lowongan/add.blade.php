@extends('layouts.front', ['title' => 'Tambah Lowongan - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

    <!-- Profile -->
    <link href="{{ asset('styles/profile.css?v=').time() }}" rel="stylesheet">

    <!-- Auto complete -->
    <link href="{{ url('styles/select2.min.css') }}" rel="stylesheet" />

    <!-- Datepicker -->
    <link href="{{ url('styles/bootstrap-datepicker3.css') }}" rel="stylesheet">
    
    <!-- Jodit -->
    <link href="{{ url('styles/jodit.min.css') }}" rel="stylesheet">

    <style>
        .font-20 {
            font-size: 20px;
        }
    </style>
@endsection

@section('banner-front')
<div class="row m-0 mt-5 panel">
    <div class="profile-thumb col-lg-3 col-md-4 pr-md-0 text-center text-dark">
        @if(empty($perusahaan->perusahaan_profile_pict))
        <i class="fas fa-briefcase bg-white border p-2 shadow-sm" style="font-size: 130px"></i>
        @else
        <img src="{{ url('storage/perusahaan_profile/'.$perusahaan->perusahaan_profile_pict) }}" class="bg-white border p-2 shadow">
        @endif
    </div>
    <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
        <h3 class="m-0">{{ $perusahaan->perusahaan_nama }}</h3>
        <small>Menunggu kelengkapan profil untuk verifikasi</small>
    </div>
</div>
@endsection

@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item"><a href="{{ url('perusahaan/detail/'.$perusahaan->perusahaan_id) }}">Profil Perusahaan</a></li>
        <li class="breadcrumb-item"><a href="{{ route('lowongan.manage') }}">Kelola </a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Lowongan</li>
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

<form method="post" id="formadd" action="{{ route('lowongan.add') }}">
@csrf
    <!-- add form -->
    <h5 class="mb-2 p-0">
        Tambah Lowongan
    </h5>
    <div class="card mb-3 p-1">
        <div class="card-body p-1">
            <input type="hidden" name="lowongan_status" id="addMode">
            <table class="table table-sm" cellspacing="0">
                <tr>
                    <td valign="center" width="50" class="greybox"><b>Judul Lowongan</b></td>
                    <td>
                        <input id="judulLowongan" class="form-control" placeholder="Judul Lowongan" name="lowongan_judul" required="required" autofocus="autofocus" type="text"
                            value="{{ old('lowongan_judul') }}"
                            data-parsley-required
                            data-parsley-required-message="Masukan judul lowongan">
                        @error('lowongan_judul')
                            <span class="form-text text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td valign="center" width="50" class="greybox"><b>Fungsi Pekerjaan</b></td>
                    <td class="position-relative">
                        <div class="row">
                            <div class="col-6">
                                <select class="form-control" name="lowongan_fungsi_id" required="required"
                                    data-parsley-required
                                    data-parsley-required-message="Pilih fungsi pekerjaan">
                                    <option value="" selected>-- Pilih Fungsi Pekerjaan --</option>
                                @foreach($fungsis as $fungsi)
                                    <option value="{{ $fungsi->fungsi_id }}">{{ $fungsi->fungsi_nama }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                        @error('lowongan_jlh_dibutuhkan')
                            <span class="form-text text-danger">
                                {{ $message }}
                            </span>    
                        @enderror

                    </td>
                </tr>
                <tr>
                    <td valign="center" width="50" class="greybox"><b>Kota Penempatan</b></td>
                    <td>
                        <select class="form-control lowonganCity" name="lowongan_city_id" required="required"
                            data-parsley-required
                            data-parsley-required-message="Pilih kota penempatan">
                        </select>
                        @error('lowongan_city_id')
                            <span class="form-text text-danger">
                                {{ $message }}
                            </span>    
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td valign="center" width="50" class="greybox"><b>Tanggal Mulai</b></td>
                    <td class="position-relative">
                        <input id="tglmulaiLowongan" class="form-control" placeholder="Tanggal Mulai Magang" name="lowongan_tgl_mulai" type="text" required="required"
                            value="{{ old('lowongan_tgl_mulai') }}"
                            data-parsley-required
                            data-parsley-required-message="Pilih tanggal mulai magang"
                            data-parsley-type="date"
                            data-parsley-type-message="Format tanggal YYYY-MM-DD">
                        @error('lowongan_tgl_mulai')
                            <span class="form-text text-danger">
                                {{ $message }}
                            </span>    
                        @enderror

                    </td>
                </tr>
                <tr>
                    <td valign="center" width="50" class="greybox"><b>Durasi</b></td>
                    <td>
                        <div class="row">
                            <div class="col-6">
                                <select class="form-control" name="lowongan_durasi_a" required="required"
                                    data-parsley-required
                                    data-parsley-required-message="Pilih jumlah durasi">
                                    <option value="" selected>-- Pilih Jumlah --</option>
                                @for($i=1; $i<=30; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                                </select>
                            </div>
                            <div class="col-6 pl-0">
                                <select class="form-control" name="lowongan_durasi_b" required="required"
                                    data-parsley-required
                                    data-parsley-required-message="Pilih satuan durasi">
                                    <option value="" selected>-- Pilih Satuan --</option>
                                    <option value="Hari">Hari</option>
                                    <option value="Bulan">Bulan</option>
                                </select>
                            </div>
                        </div>
                        @error('lowongan_durasi')
                            <span class="form-text text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td valign="center" width="50" class="greybox"><b>Jumlah Dibutuhkan</b></td>
                    <td class="position-relative">
                        <div class="row">
                            <div class="col-6">
                                <select class="form-control" name="lowongan_jlh_dibutuhkan" required="required"
                                    data-parsley-required
                                    data-parsley-required-message="Pilih jumlah tenaga dibutuhkan">
                                    <option value="" selected>-- Pilih Jumlah Dibutuhkan --</option>
                                @for($i=1; $i<=30; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                                </select>
                            </div>
                        </div>
                        @error('lowongan_jlh_dibutuhkan')
                            <span class="form-text text-danger">
                                {{ $message }}
                            </span>    
                        @enderror

                    </td>
                </tr>
                <tr>
                    <td valign="center" width="50" class="greybox"><b>Syarat</b></td>
                    <td>
                        <textarea id="syaratLowongan" class="form-control" placeholder="Syarat Lowongan" name="lowongan_requirement" required="required"
                            data-parsley-required
                            data-parsley-required-message="Masukan syarat lowongan">{{ old('lowongan_requirement') }}</textarea>
                        @error('lowongan_requirement')
                            <span class="form-text text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td valign="center" width="50" class="greybox"><b>Job Desk</b></td>
                    <td>
                        <textarea id="jobdeskLowongan" class="form-control" placeholder="Job Desk Lowongan" name="lowongan_jobdesk" required="required"
                            data-parsley-required
                            data-parsley-required-message="Masukan job desk lowongan">{{ old('lowongan_jobdesk') }}</textarea>
                        @error('lowongan_jobdesk')
                            <span class="form-text text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td valign="center" width="50" class="greybox"></td>
                    <td>
                        <div class="row">
                            <div class="col-6">
                                <input type="button" class="btn btn-success btn-block" value="Simpan Draft" id="btnDraft">
                            </div>
                            <div class="col-6 pl-0">
                                <input type="button" class="btn btn-primary btn-block" value="Posting" id="btnPost">
                            </div>
                        </div>
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

        $('#btnDraft').click(function(){
            $('#addMode').val('draft');
            $('.modal-body').html('Apakah anda yakin untuk menyimpan lowongan sebagai draft?');
            $('#confirmModal').modal('show');
        });

        $('#btnPost').click(function(){
            $('#addMode').val('post');
            $('.modal-body').html('Apakah anda yakin untuk menyimpan dan mempublikasikan lowongan?');
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

<!-- Auto Complete-->
<script src="{{ url('js/select2.min.js') }}"></script>
<script type="text/javascript">
    $('.lowonganCity').select2({
        placeholder: '-- Pilih Kota Penempatan --',
        ajax: {
        url: '{{ url('cityautocom') }}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
            return {
                results: data
            };
        },
        cache: true
        }
    });
</script>

<!-- Datepicker-->
<script src="{{ url('js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(document).ready(function(){

        var uploaded=$('input[name="lowongan_tgl_mulai"]');
        uploaded.datepicker({
            format: "yyyy-mm-dd",
            container: $('#tglmulaiLowongan').parent(),
            todayHighlight: true,
            autoclose: true,
            orientation: "auto",
        });
    })
</script>

<!-- Jodit-->
<script src="{{ url('js/jodit.min.js') }}"></script>
<script>
    $(document).ready(function(){
        var editor = new Jodit("#syaratLowongan", {
        "spellcheck": false,
        "buttons": "undo,redo,|,bold,underline,italic,|,superscript,subscript,|,ul,ol,|,outdent,indent,align,fontsize,|,image,link,|",
        });
        var editor = new Jodit("#jobdeskLowongan", {
        "spellcheck": false,
        "buttons": "undo,redo,|,bold,underline,italic,|,superscript,subscript,|,ul,ol,|,outdent,indent,align,fontsize,|,image,link,|",
        });
    })
</script>
@endsection