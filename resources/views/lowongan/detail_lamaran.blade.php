@extends('layouts.front', ['title' => 'Undangan Test Magang - MagangHub'])

@section('head')
    
    <!-- SB Admin Template -->
    <link href="{{ asset('styles/sb-admin.css?v=').time() }}" rel="stylesheet">

    <!-- DataTable-->
    <link href="{{ url('datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">

    <!-- Profile -->
    <link href="{{ asset('styles/profile.css?v=').time() }}" rel="stylesheet">

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
        @if(empty($rekrut->perusahaan_profile_pict))
        <i class="fas fa-briefcase bg-white border p-2 shadow-sm" style="font-size: 130px"></i>
        @else
        <img src="{{ url('storage/perusahaan_profile/'.$rekrut->perusahaan_profile_pict) }}" class="bg-white border p-2 shadow">
        @endif
    </div>
    <div class="profile-text col-lg-9 col-md-8 p-md-0 mb-2">
        <h3 class="m-0">{{ $rekrut->perusahaan_nama }}</h3>
        <small>Menunggu kelengkapan profil untuk verifikasi</small>
    </div>
</div>
@endsection


@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item ml-auto"><a href="{{ route('perekrutan.lamaranlist') }}">Daftar Lamaran</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Lamaran</li>
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
        Detail Lamaran
    </h5>
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">

        @if($rekrut->rekrut_status=="magang")
        <div class="alert alert-warning">
            Anda sudah diterima magang pada lowongan lain.
        </div>
        @elseif($rekrut->rekrut_status=="melamar")
        <div class="alert alert-warning">
            Menunggu undangan test dari perusahaan.
        </div>
        @elseif($rekrut->rekrut_status=="melamartlk")
        <div class="alert alert-warning">
            Mohon maaf, lamaran ini ditolak perusahaan. Tetap semangat dan jangan menyerah!
        </div>
        @elseif($rekrut->rekrut_status=="diundang")
        <div class="alert alert-warning">
            Perusahaan mengundang anda untuk test, perhatikan pada informasi undangan di bawah. Mohon konfirmasi bahwa anda akan hadir pada test tersebut.
        </div>
        <div class="row">
                <div class="col-6">
                    <input type="button" class="btn btn-danger btn-block" value="Tolak Undangan" id="btnTolak">
                </div>
                <div class="col-6 pl-0">
                    <input type="button" class="btn btn-primary btn-block" value="Konfirmasi Undangan" id="btnConfirm">
                </div>
            </div>
        </td>
        @elseif($rekrut->rekrut_status=="siap test")
        <div class="alert alert-warning">
            Anda sudah mengkonfirmasi untuk menghadiri test, semoga sukses!
        </div>
        @elseif($rekrut->rekrut_status=="tlkundang")
        <div class="alert alert-warning">
            Anda sudah menolak undangan test pada lamaran ini, mohon hubungi perusahaan untuk penawaran undangan kembali.
        </div>
        @elseif($rekrut->rekrut_status=="tdklulus")
        <div class="alert alert-warning">
            Anda dinyatakan tidak lulus test pada lowongan magang ini, tetap semangat dan semoga sukses!
        </div>
        @elseif($rekrut->rekrut_status=="lulus")
        <div class="alert alert-warning">
            Anda telah diterima magang pada lowongan ini, anda dapat langsung membuat kegiatan magang pada hari pertama magang anda.
        </div>
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

        @if($rekrut->rekrut_waktu_diundang)
        <h5 class="mt-3 p-1 border-bottom">Undangan Test</h5>
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
        @endif

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

<form method="post" id="formadd" action="{{ route('perekrutan.undang') }}">
@csrf
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
                
                <input type="hidden" name="rekrut_id" value="{{ $rekrut->rekrut_id }}">
                <label class="mt-2">Alasan Penolakan</label><br />
                <textarea id="alasanPenolakan" class="form-control" placeholder="Alasan Penolakan" name="alasan_penolakan" required="required"
                    data-parsley-required
                    data-parsley-required-message="Masukan alasan penolakan"></textarea>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

            <input  type="submit" class="btn btn-primary" id="sendsubmit" value="Ya">
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
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        $('#btnTolak').click(function(){
            $('#formadd').attr('action', '{{ route("perekrutan.tolakundangan") }}');
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

@endsection