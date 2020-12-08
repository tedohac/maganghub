@extends('layouts.front', ['title' => 'Undangan Test Magang - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

    <!-- DataTable-->
    <link href="{{ url('datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- Profile -->
    <link href="{{ asset('styles/profile.css?v=').time() }}" rel="stylesheet">

    <!-- Jodit -->
    <link href="{{ url('styles/jodit.min.css') }}" rel="stylesheet">

    <!-- Datepicker -->
    <link href="{{ url('styles/bootstrap-datepicker3.css') }}" rel="stylesheet">

    <!-- Tracking -->
    <link href="{{ asset('styles/tracking.css?v=').time() }}" rel="stylesheet">

    <style>
        .font-20 {
            font-size: 20px;
        }
    </style>
@endsection

@section('banner-front')
<div class="row m-0 mt-5 panel">
    <div class="profile-thumb col-lg-3 col-md-4 pr-md-0 text-center text-dark">
        @if(empty($rekrut->mahasiswa_profile_pict))
        <i class="fas fa-user-graduate bg-white border p-2 shadow-sm" style="font-size: 130px"></i>
        @else
        <img src="{{ url('storage/mahasiswa_profile/'.$rekrut->mahasiswa_profile_pict) }}" class="bg-white border p-2 shadow">
        @endif
    </div>
    <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
        <h3 class="m-0">{{ $rekrut->mahasiswa_nama }}</h3>
        {{ $rekrut->mahasiswa_nim }} - <a href="{{ url('kampus/detail/'.$rekrut->univ_id) }}" class="text-white">{{ $rekrut->univ_nama }}</a>
    </div>
</div>
@endsection


@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item ml-auto"><a href="{{ route('perekrutan.lamaranlist') }}">Daftar Lamaran</a></li>
        <li class="breadcrumb-item active" aria-current="page">Undangan</li>
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

    <!-- detail info -->
    <h5 class="mb-2 p-0">
        Undangan Test Magang
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">

        @if($rekrut->rekrut_status=="diundang")
        <div class="row">
                <div class="col-6">
                    <input type="button" class="btn btn-danger btn-block" value="Tolak Undangan" id="btnTolak">
                </div>
                <div class="col-6 pl-0">
                    <input type="button" class="btn btn-primary btn-block" value="Konfirmasi Undangan" id="btnConfirm">
                </div>
            </div>
        </td>
        @endif

        <div class="track">
            <div class="step {{ ($rekrut->rekrut_waktu_melamar) ? 'active' : '' }}"> 
                <span class="icon"> 
                    <i class="fa fa-share-square pt-2"></i> 
                </span> 
                <span class="text">
                    Melamar<br />
                    <small>{{ ($rekrut->rekrut_waktu_melamar) ? date('d M Y H:i', strtotime($rekrut->rekrut_waktu_melamar)) : "" }}</small>
                </span>
            </div>
            <div class="step {{ ($rekrut->rekrut_waktu_diundang) ? 'active' : '' }}"> 
                <span class="icon"> 
                    <i class="fa fa-user pt-2"></i> 
                </span> 
                <span class="text">
                    Undangan<br />
                    <small>{{ ($rekrut->rekrut_waktu_diundang) ? date('d M Y H:i', strtotime($rekrut->rekrut_waktu_diundang)) : "" }}</small>
                </span> 
            </div>
            <div class="step {{ ($rekrut->rekrut_waktu_konfirmundangan) ? 'active' : '' }}"> 
                <span class="icon"> 
                    <i class="fa fa-file-alt pt-2"></i> 
                </span> 
                <span class="text">
                    Siap Test<br />
                    <small>{{ ($rekrut->rekrut_waktu_konfirmundangan) ? date('d M Y H:i', strtotime($rekrut->rekrut_waktu_konfirmundangan)) : "" }}</small>
                </span>
            </div>
            <div class="step {{ ($rekrut->rekrut_waktu_diterima) ? 'active' : '' }}"> 
                <span class="icon"> 
                    <i class="fa fa-check-double pt-2"></i> 
                </span> 
                <span class="text">
                    Diterima<br />
                    <small>{{ ($rekrut->rekrut_waktu_diterima) ? date('d M Y H:i', strtotime($rekrut->rekrut_waktu_diterima)) : "" }}</small>
                </span>
            </div>
        </div>

        <div class="py-1">{{ $rekrut->perusahaan_nama }} mengundang anda untuk test magang pada:</div>
        <table class="table" cellspacing="0">
            <tr>
                <td class="greybox"><b>Waktu</b></td>
                <td>{{ date('d M Y H:i', strtotime($rekrut->rekrut_undangan_waktu)) }}</td>
            </tr>
            <tr>
                <td class="greybox"><b>Tempat</b></td>
                <td>{{ $rekrut->rekrut_undangan_alamat }}</td>
            </tr>
            <tr>
                <td class="greybox"><b>Deskripsi</b></td>
                <td>{!! $rekrut->rekrut_undangan_desc !!}</td>
            </tr>
        </table>

        <div class="py-1">Informasi Lowongan</div>
        <table class="table" cellspacing="0">
            <tr>
                <td class="greybox"><b>Perusahaan</b></td>
                <td>
                    <a href="{{ url('perusahaan/detail/'.$rekrut->perusahaan_id) }}">
                        {{ $rekrut->perusahaan_nama }}
                    </a>
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Judul Lowongan</b></td>
                <td>
                    {{ $rekrut->lowongan_judul }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Fungsi</b></td>
                <td>
                    {{ $rekrut->fungsi_nama }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Kota Penempatan</b></td>
                <td>
                    {{ $rekrut->city_nama }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Mulai Magang</b></td>
                <td>
                    {{ $rekrut->lowongan_tgl_mulai }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Durasi</b></td>
                <td>
                    {{ $rekrut->lowongan_durasi }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Jumlah Dibutuhkan</b></td>
                <td>
                    {{ $rekrut->lowongan_jlh_dibutuhkan }}
                </td>
            </tr>
        </table>
        <h5 class="mt-3 p-1 border-bottom">Syarat</h5>
        {!! $rekrut->lowongan_requirement !!}
        
        <h5 class="mt-3 p-1 border-bottom">Job Desk</h5>
        {!! $rekrut->lowongan_jobdesk !!}
    </div>
    <!-- end detail info -->

    <!-- Confirm Undangan Modal -->
    <div class="modal fade" id="confirmModal">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Konfirmasi Undangan</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Apakah anda yakin untuk <b>KONFIRMASI</b> undangan test ini?<br>
                Perusahaan akan menyiapkan test untuk anda.
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

            <a class="btn btn-primary" href="{{ url('perekrutan/confirmundangan/'.$rekrut->rekrut_id) }}">
                Ya
            </a>
            </div>

        </div>
        </div>
    </div>
    <!-- End Confirm Undangan Modal -->

    <!-- Confirm Tolak Undangan Modal -->
    <div class="modal fade" id="tolakModal">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Tolak Undangan</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Apakah anda yakin untuk <b>MENOLAK</b> undangan test ini?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

            <a class="btn btn-primary" href="{{ url('perekrutan/tolakundangan/'.$rekrut->rekrut_id) }}">
                Ya
            </a>
            </div>

        </div>
        </div>
    </div>
    <!-- End Confirm Tolak Modal -->

    <!-- Confirm Batal Tolak Modal -->
    <div class="modal fade" id="batalTolakModal">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Batal Penolakan Lamaran</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Apakah anda yakin untuk <b>MEMBATALKAN PENOLAKAN</b> pada lamaran ini?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            
            <a class="btn btn-primary" href="{{ url('perekrutan/bataltolak/'.$rekrut->rekrut_id) }}">
                Ya
            </a>
            </div>

        </div>
        </div>
    </div>
    <!-- End Confirm Batal Tolak Modal -->
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
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $('#btnTolak').click(function(){
            $('#tolakModal').modal('show');
        });

        $('#btnBatalTolak').click(function(){
            $('#confirmBatalTolakModal').modal('show');
        });

        $('#btnConfirm').click(function(){
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
        var editor = new Jodit("#descUndangan", {
        "spellcheck": false,
        "buttons": "undo,redo,|,bold,underline,italic,|,superscript,subscript,|,ul,ol,|,outdent,indent,align,fontsize,|,image,link,|",
        });
    })
</script>

<!-- Datepicker-->
<script src="{{ url('js/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(document).ready(function(){

        var uploaded=$('input[name="undangan_tanggal"]');
        uploaded.datepicker({
            format: "yyyy-mm-dd",
            container: $('#tglUndangan').parent(),
            todayHighlight: true,
            autoclose: true,
            orientation: "auto",
        });
    })
</script>
@endsection