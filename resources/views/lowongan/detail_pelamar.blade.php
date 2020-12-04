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
    <div class="bg-white shadow-sm border px-2 px-lg-3 py-3 mb-5">
        <div class="py-1">Informasi Lowongan</div>
        <table class="table table-sm" cellspacing="0">
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

        <div class="py-1">Informasi Mahasiswa Pelamar</div>
        <table class="table table-sm" cellspacing="0">
            <tr>
                <td class="greybox"><b>Kampus</b></td>
                <td>
                    <a href="{{ url('kampus/detail/'.$rekrut->univ_id) }}" class="text-dark">{{ $rekrut->univ_nama }}</a>
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>NIM</b></td>
                <td>
                    {{ $rekrut->mahasiswa_nim ? $rekrut->mahasiswa_nim : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>TTL</b></td>
                <td>
                    {{ $rekrut->mahasiswa_tempat_lahir ? $rekrut->mahasiswa_tempat_lahir : '-' }}, {{ $rekrut->mahasiswa_tgl_lahir ? $rekrut->mahasiswa_tgl_lahir : '-' }}
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
                    {{ $rekrut->mahasiswa_cv ? $rekrut->mahasiswa_cv : '-' }}
                </td>
            </tr>
            <tr>
                <td class="greybox"><b>KHS</b></td>
                <td>
                    {{ $rekrut->mahasiswa_khs ? $rekrut->mahasiswa_khs : '-' }}
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
        @if($rekrut->rekrut_status=="melamar")
        <div class="row">
                <div class="col-6">
                    <input type="button" class="btn btn-danger btn-block" value="Tolak Lamaran" id="btnTolak">
                </div>
                <div class="col-6 pl-0">
                    <input type="button" class="btn btn-primary btn-block" value="Undang Test" id="btnUndang">
                </div>
            </div>
        </td>
        @elseif($rekrut->rekrut_status=="ditolak")
        <div class="alert alert-warning">
            Anda sudah menolak lamaran ini. <input type="button" class="btn btn-primary" value="Batal Penolakan" id="btnBatalTolak">
        </div>
        @endif
    </div>
    <!-- end detail info -->

<form method="post" id="formadd" action="#">
@csrf
    <!-- Confirm Tolak Modal -->
    <div class="modal fade" id="confirmTolakModal">
        <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
            <h4 class="modal-title">Konfirmasi Tolak Lamaran</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <input type="hidden" name="rekrut_id" value="{{ $rekrut->rekrut_id }}">
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
    <div class="modal fade" id="btnBatalTolak">
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

            <input type="submit" class="btn btn-primary" id="sendsubmit" value="Ya">
            
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
                Anda akan mengirim undangan test kepada mahasiswa ini. Silahkan isi detail di bawah ini:
                
                <textarea id="undangPelamar" class="form-control" placeholder="Detail Undangan" name="detail_undangan" required="required"
                            data-parsley-required
                            data-parsley-required-message="Masukan detail undangan"></textarea><br /><br />
                <label>File undangan</label><br />
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="cvMahasiswa" name="mahasiswa_cv" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps">
                        <label class="custom-file-label" for="cvMahasiswa">Pilih file</label>
                    </div>
                </div>
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
        var editor = new Jodit("#undangPelamar", {
        "spellcheck": false,
        "buttons": "undo,redo,|,bold,underline,italic,|,superscript,subscript,|,ul,ol,|,outdent,indent,align,fontsize,|,image,link,|",
        });
    })
</script>
@endsection