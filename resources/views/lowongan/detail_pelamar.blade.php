@extends('layouts.front', ['title' => 'Detail Pelamar - MagangHub'])

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
        @if(\App\Univ::getIsBanned($rekrut->univ_id))
            <span class="badge badge-danger"><i class="fas fa-exclamation-triangle"></i> Kampus ini sedang dalam pengawasan</span>
        @endif
    </div>
</div>
@endsection


@section('content')
    <ol class="breadcrumb p-1 ml-auto">
        <li class="breadcrumb-item ml-auto"><a href="{{ route('/') }}">MagangHub</a></li>
        <li class="breadcrumb-item"><a href="{{ url('perusahaan/detail/'.$rekrut->lowongan_perusahaan_id) }}">Profil Perusahaan</a></li>
        <li class="breadcrumb-item"><a href="{{ route('lowongan.manage') }}">Kelola Lowongan</a></li>
        <li class="breadcrumb-item"><a href="{{ url('perekrutan/pelamar/'.$rekrut->lowongan_id) }}">Pelamar</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Pelamar</li>
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
        Detail Pelamar
    </h5>
    <!-- lamaran status -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">

        @if($rekrut->rekrut_status=="magang")
        <div class="alert alert-warning">
            Mahasiswa ini sudah lulus pada lowongan lain dan sedang melakukan magang
        </div>
        @elseif($rekrut->rekrut_status=="melamar")
        <div class="row">
            <div class="col-6">
                <input type="button" class="btn btn-danger btn-block" value="Tolak Lamaran" id="btnTolak">
            </div>
            <div class="col-6 pl-0">
                <input type="button" class="btn btn-primary btn-block" value="Undang Test" id="btnUndang">
            </div>
        </div>
        @elseif($rekrut->rekrut_status=="melamartlk")
        <div class="alert alert-warning">
            Anda sudah menolak lamaran ini. <input type="button" class="btn btn-primary p-1" value="Batal Penolakan" id="btnBatalTolak">
        </div>
        @elseif($rekrut->rekrut_status=="diundang")
        <div class="alert alert-warning">
            Anda sudah mengirim undangan test, menunggu konfirmasi mahasiswa. 
            <a href="{{ url('perekrutan/kirimulangundangan/'.$rekrut->rekrut_id) }}" class="btn btn-primary p-1">Kirim Ulang Undangan</a>
        </div>
        @elseif($rekrut->rekrut_status=="cnfrmtest")
        <div class="alert alert-warning">
            Mahasiswa mengkonfirmasi atas undangan test dari anda, sudah ada hasil test?
        </div>
        <div class="row">
            <div class="col-6">
                <input type="button" class="btn btn-danger btn-block" value="Tidak Lulus Test" id="btnTdkLulus">
            </div>
            <div class="col-6 pl-0">
                <input type="button" class="btn btn-primary btn-block" value="Lulus Test dan Diterima" id="btnLulus">
            </div>
        </div>
        @elseif($rekrut->rekrut_status=="tlkundang")
        <div class="alert alert-warning">
            Mahasiswa menolak undangan terakhir dari anda (mohon lihat detail undangan di bawah) dengan alasan:<br />
            {{ $rekrut->rekrut_tolakundangan_reason }}<br />
            Anda dapat mengirim kembali undangan ke mahasiswa tersebut.
        </div>
        <div class="row">
            <div class="col-6">
                <input type="button" class="btn btn-primary btn-block" value="Undang Test Kembali" id="btnUndang">
            </div>
        </div>
        @elseif($rekrut->rekrut_status=="tdklulus")
        <div class="alert alert-warning">
            Anda telah menyatakan bahwa mahasiswa ini tidak lulus test.
        </div>
        @elseif($rekrut->rekrut_status=="lulus")
        <div class="alert alert-warning">
            Anda telah menyatakan bahwa mahasiswa ini lulus test dan diterima magang pada lowongan ini.<br />
            Mahasiswa dapat langsung membuat kegiatan magang.
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
                    Undangan Test<br />
                    <small>{{ ($rekrut->rekrut_waktu_diundang) ? date('d M Y H:i', strtotime($rekrut->rekrut_waktu_diundang)) : "" }}</small>
                </span> 
            </div>
            <div class="step {{ ($rekrut->rekrut_waktu_konfirmundangan) ? 'active' : '' }}"> 
                <span class="icon"> 
                    <i class="fa fa-file-alt pt-2"></i> 
                </span> 
                <span class="text">
                    Konfirmasi Test<br />
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
        <div class="pb-5"></div>
    </div>
    <!-- end lamaran status -->

    @if($rekrut->rekrut_waktu_diundang)
    <!-- undangan test -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <div class="py-1">Undangan Test</div>
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
    </div>
    <!-- end undangan test -->
    @endif

    <!-- info mahasiswa -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <div class="py-1">Informasi Mahasiswa Pelamar</div>
        <table class="table" cellspacing="0">
            <tr>
                <td class="greybox"><b>Kampus</b></td>
                <td>
                    <a href="{{ url('kampus/detail/'.$rekrut->univ_id) }}" class="text-dark">{{ $rekrut->univ_nama }}</a>
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Prodi</b></td>
                <td>
                    {{ ($rekrut->prodi_fakultas!="") ? $rekrut->prodi_fakultas."-" : "" }} {{ $rekrut->prodi_nama }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>NIM</b></td>
                <td>
                    {{ $rekrut->mahasiswa_nim }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Mahasiswa</b></td>
                <td>
                    {{ $rekrut->mahasiswa_nama }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>TTL</b></td>
                <td>
                    {{ $rekrut->mahasiswa_tempat_lahir ? $rekrut->mahasiswa_tempat_lahir : '-' }}, {{ $rekrut->mahasiswa_tgl_lahir ? date('d F Y', strtotime($rekrut->mahasiswa_tgl_lahir)) : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Telepon</b></td>
                <td>
                    {{ $rekrut->mahasiswa_no_tlp ? $rekrut->mahasiswa_no_tlp : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Domisili</b></td>
                <td>
                    {{ $rekrut->city_nama ? $rekrut->city_nama : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Alamat</b></td>
                <td>
                    {{ $rekrut->mahasiswa_alamat ? $rekrut->mahasiswa_alamat : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>CV</b></td>
                <td>
                    @if($rekrut->mahasiswa_cv)
                        <a class="btn btn-outline-success p-1" href="{{ url('storage/mahasiswa_cv/'.$rekrut->mahasiswa_cv) }}"> 
                            <i class="fas fa-cloud-download-alt"></i>
                            Download CV
                        </a>
                    @else
                        <span class="badge badge-secondary p-1">Belum melengkapi CV</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>KHS</b></td>
                <td>
                    @if($rekrut->mahasiswa_khs)
                        <a class="btn btn-outline-success p-1" href="{{ url('storage/mahasiswa_khs/'.$rekrut->mahasiswa_khs) }}"> 
                            <i class="fas fa-cloud-download-alt"></i>
                            Download KHS
                        </a>
                    @else
                        <span class="badge badge-secondary p-1">Belum melengkapi KHS</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>Skills</b></td>
                <td>
                    @foreach($skills as $skill)
                        <span class="badge badge-info p-1">{{ $skill->skill_nama }}</span>
                    @endforeach
                </td>
            </tr>
        </table>
    </div>
    <!-- end info mahasiswa -->
        
    <!-- info lowongan -->
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-3">
        <div class="py-1">Informasi Lowongan</div>
        <table class="table" cellspacing="0">
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
    <!-- end info lowongan -->

<form method="post" id="formadd" action="{{ route('perekrutan.undang') }}">
@csrf
    <!-- Confirm Tolak Modal -->
    <div class="modal fade" id="confirmTolakModal">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Tolak Lamaran</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Apakah anda yakin untuk <b>MENOLAK</b> lamaran ini?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

            <a class="btn btn-primary" href="{{ url('perekrutan/tolak/'.$rekrut->rekrut_id) }}">
                Ya
            </a>
            </div>

        </div>
        </div>
    </div>
    <!-- End Confirm Tolak Modal -->

    <!-- Confirm Batal Tolak Modal -->
    <div class="modal fade" id="confirmBatalTolakModal">
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
    
    <!-- Confirm Undang Modal -->
    <div class="modal fade" id="confirmUndangModal">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Undang Pelamar untuk Test</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <input type="hidden" name="rekrut_id" value="{{ $rekrut->rekrut_id }}">
                Anda akan mengirim undangan test kepada mahasiswa ini. Silahkan isi detail di bawah ini:
                
                <textarea id="descUndangan" class="form-control mb-2" placeholder="Detail Undangan" name="undangan_desc" required="required"
                            data-parsley-required
                            data-parsley-required-message="Masukan detail undangan"></textarea><br /><br />
                            
                <label>Tanggal Undangan</label><br />
                <input id="tglUndangan" class="form-control mb-2" placeholder="Tanggal Undangan" name="undangan_tanggal" type="text" required="required"
                    data-parsley-required
                    data-parsley-required-message="Pilih tanggal undangan"
                    data-parsley-type="date"
                    data-parsley-type-message="Format tanggal YYYY-MM-DD">

                <label class="mt-2">Waktu Undangan</label><br />
                <select class="form-control" name="undangan_waktu" required="required"
                    data-parsley-required
                    data-parsley-required-message="Pilih waktu undangan">
                    <option value="" selected>-- Pilih Waktu Undangan --</option>
                    <option value="00:00">00:00</option>
                    <option value="00:30">00:30</option>
                    <option value="01:00">01:00</option>
                    <option value="01:30">01:30</option>
                    <option value="02:00">02:00</option>
                    <option value="02:30">02:30</option>
                    <option value="03:00">03:00</option>
                    <option value="03:30">03:30</option>
                    <option value="04:00">04:00</option>
                    <option value="04:30">04:30</option>
                    <option value="05:00">05:00</option>
                    <option value="05:30">05:30</option>
                    <option value="06:00">06:00</option>
                    <option value="06:30">06:30</option>
                    <option value="07:00">07:00</option>
                    <option value="07:30">07:30</option>
                    <option value="08:00">08:00</option>
                    <option value="08:30">08:30</option>
                    <option value="09:00">09:00</option>
                    <option value="09:30">09:30</option>
                    <option value="10:00">10:00</option>
                    <option value="10:30">10:30</option>
                    <option value="11:00">11:00</option>
                    <option value="11:30">11:30</option>
                    <option value="12:00">12:00</option>
                    <option value="12:30">12:30</option>
                    <option value="13:00">13:00</option>
                    <option value="13:30">13:30</option>
                    <option value="14:00">14:00</option>
                    <option value="14:30">14:30</option>
                    <option value="15:00">15:00</option>
                    <option value="15:30">15:30</option>
                    <option value="16:00">16:00</option>
                    <option value="16:30">16:30</option>
                    <option value="17:00">17:00</option>
                    <option value="17:30">17:30</option>
                    <option value="18:00">18:00</option>
                    <option value="18:30">18:30</option>
                    <option value="19:00">19:00</option>
                    <option value="19:30">19:30</option>
                    <option value="20:00">20:00</option>
                    <option value="20:30">20:30</option>
                    <option value="21:00">21:00</option>
                    <option value="21:30">21:30</option>
                    <option value="22:00">22:00</option>
                    <option value="22:30">22:30</option>
                    <option value="23:00">23:00</option>
                    <option value="23:30">23:30</option>
                </select>

                <label class="mt-2">Alamat undangan</label><br />
                <textarea id="alamatUndangan" class="form-control" placeholder="Alamat Undangan" name="undangan_alamat" required="required"
                    data-parsley-required
                    data-parsley-required-message="Masukan alamat undangan"></textarea>

            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

            <input  type="submit" class="btn btn-primary" id="sendsubmit" value="Ya">
            </div>

        </div>
        </div>
    </div>
    <!-- End Confirm Undang Modal -->
    
    <!-- Confirm Lulus Modal -->
    <div class="modal fade" id="lulusModal">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Lulus Test dan Siap Magang</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Apakah anda yakin untuk menyatakan bahwa mahasiswa ini lulus test dan <b>DITERIMA</b> sebagai mahasiswa magang di perusahaan anda?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

            <a class="btn btn-primary" href="{{ url('perekrutan/lulus/'.$rekrut->rekrut_id) }}">
                Ya
            </a>
            </div>

        </div>
        </div>
    </div>
    <!-- End Confirm Lulus Modal -->
    
    <!-- Confirm Tidak Lulus Modal -->
    <div class="modal fade" id="tdkLulusModal">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Tidak Lulus Test</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                Apakah anda yakin untuk menyatakan bahwa mahasiswa ini <b>TIDAK LULUS TEST</b> pada lowongan magang ini?
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>

            <a class="btn btn-primary" href="{{ url('perekrutan/tdklulus/'.$rekrut->rekrut_id) }}">
                Ya
            </a>
            </div>

        </div>
        </div>
    </div>
    <!-- End Confirm Tidak Lulus Modal -->
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
            $('#confirmTolakModal').modal('show');
        });

        $('#btnBatalTolak').click(function(){
            $('#confirmBatalTolakModal').modal('show');
        });

        $('#btnTdkLulus').click(function(){
            $('#tdkLulusModal').modal('show');
        });

        $('#btnLulus').click(function(){
            $('#lulusModal').modal('show');
        });

        $('#btnUndang').click(function(){
            $('#formadd').attr('action', '{{ route("perekrutan.undang") }}');
            $('#confirmUndangModal').modal('show');
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